<?php

namespace App\Http\Controllers;

use App\Models\Isprava;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class IspravaController extends Controller
{
    public function index(Request $request): View
    {
        $isprave = $request->user()
            ->isprave()
            ->latest()
            ->get()
            ->map(fn (Isprava $isprava) => $this->presentIsprava($isprava));

        $today = now()->startOfDay();
        $warningThreshold = now()->addDays(90)->endOfDay();

        $summary = [
            'total' => $isprave->count(),
            'active' => $isprave->filter(fn ($item) => ! $item->expires_at || $item->expires_at->isAfter($today))->count(),
            'expiring_soon' => $isprave->filter(fn ($item) => $item->expires_at && $item->expires_at->between($today, $warningThreshold))->count(),
            'with_images' => $isprave->filter(fn ($item) => $item->image_count > 0)->count(),
        ];

        return view('isprave', compact('isprave', 'summary'));
    }

    public function create(): View
    {
        return view('isprave-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateIsprava($request);

        $frontImagePath = $request->file('front_image')
            ? $request->file('front_image')->store('isprave', 'public')
            : null;

        $backImagePath = $request->file('back_image')
            ? $request->file('back_image')->store('isprave', 'public')
            : null;

        $request->user()->isprave()->create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'document_number' => $validated['document_number'] ?? null,
            'issuer' => $validated['issuer'] ?? null,
            'issued_at' => $validated['issued_at'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'reminder_enabled' => $validated['reminder_enabled'] ?? true,
            'reminder_days' => $validated['reminder_days'] ?? 90,
            'note' => $validated['note'] ?? null,
            'front_image_path' => $frontImagePath,
            'back_image_path' => $backImagePath,
        ]);

        return to_route('isprave')->with('status', 'Isprava je spremljena.');
    }

    public function show(Isprava $isprava): View
    {
        return view('isprave-show', [
            'isprava' => $isprava,
            'details' => $this->presentIspravaDetail($isprava),
        ]);
    }

    public function edit(Isprava $isprava): View
    {
        return view('isprave-edit', [
            'isprava' => $isprava,
            'filters' => config('docupocket.isprave.categories', []),
        ]);
    }

    public function update(Request $request, Isprava $isprava): RedirectResponse
    {
        $validated = $this->validateIsprava($request);

        $frontImagePath = $isprava->front_image_path;
        if ($request->hasFile('front_image')) {
            if ($frontImagePath) {
                Storage::disk('public')->delete($frontImagePath);
            }

            $frontImagePath = $request->file('front_image')->store('isprave', 'public');
        }

        $backImagePath = $isprava->back_image_path;
        if ($request->hasFile('back_image')) {
            if ($backImagePath) {
                Storage::disk('public')->delete($backImagePath);
            }

            $backImagePath = $request->file('back_image')->store('isprave', 'public');
        }

        $isprava->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'document_number' => $validated['document_number'] ?? null,
            'issuer' => $validated['issuer'] ?? null,
            'issued_at' => $validated['issued_at'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'reminder_enabled' => $validated['reminder_enabled'] ?? true,
            'reminder_days' => $validated['reminder_days'] ?? 90,
            'note' => $validated['note'] ?? null,
            'front_image_path' => $frontImagePath,
            'back_image_path' => $backImagePath,
        ]);

        return to_route('isprave.show', $isprava)->with('status', 'Isprava je ažurirana.');
    }

    private function presentIsprava(Isprava $isprava): object
    {
        $category = $isprava->category;
        $categoryLabel = config('docupocket.isprave.categories.' . $category, ucfirst($category));
        $imageCount = collect([$isprava->front_image_path, $isprava->back_image_path])->filter()->count();
        $expiresAt = $isprava->expires_at;
        $status = $this->resolveStatus($expiresAt);

        return (object) [
            'id' => $isprava->id,
            'name' => $isprava->name,
            'category' => $category,
            'category_label' => $categoryLabel,
            'preview_class' => $this->previewClassForCategory($category),
            'preview_chip' => $this->previewChipForCategory($categoryLabel, $category),
            'code_label' => $this->codeLabelForCategory($categoryLabel),
            'code_value' => $isprava->document_number ?: 'Nije uneseno',
            'image_count' => $imageCount,
            'document_number' => $isprava->document_number ?: 'Nije uneseno',
            'issuer' => $isprava->issuer ?: 'Nije uneseno',
            'issued_at_label' => $isprava->issued_at ? $this->formatCroatianDate($isprava->issued_at) : 'Nije postavljeno',
            'expires_at' => $expiresAt,
            'expires_label' => $expiresAt ? $this->formatCroatianDate($expiresAt) : 'Nije postavljeno',
            'reminder_enabled' => (bool) $isprava->reminder_enabled,
            'reminder_days' => $isprava->reminder_days ?: 0,
            'note' => $isprava->note ?: 'Bez napomene',
            'front_image_path' => $isprava->front_image_path,
            'back_image_path' => $isprava->back_image_path,
            'status_class' => $status['class'],
            'status_label' => $status['label'],
            'search' => trim(implode(' ', array_filter([
                $isprava->name,
                $categoryLabel,
                $isprava->document_number,
                $isprava->issuer,
                $isprava->note,
            ]))),
        ];
    }

    private function presentIspravaDetail(Isprava $isprava): array
    {
        $presented = $this->presentIsprava($isprava);

        return [
            'summary' => $presented,
            'reminder_label' => $presented->reminder_enabled
                ? 'Uključen, ' . $presented->reminder_days . ' dana prije isteka'
                : 'Isključen',
        ];
    }

    private function validateIsprava(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(array_keys(config('docupocket.isprave.categories', [])))],
            'document_number' => ['nullable', 'string', 'max:255'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'issued_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
            'reminder_enabled' => ['nullable', 'boolean'],
            'reminder_days' => ['nullable', 'integer', 'min:1', 'max:3650'],
            'note' => ['nullable', 'string', 'max:65535'],
            'front_image' => ['nullable', 'image', 'max:5120'],
            'back_image' => ['nullable', 'image', 'max:5120'],
        ], [
            'name.required' => 'Naziv isprave je obavezan.',
            'name.max' => 'Naziv isprave može imati najviše 255 znakova.',
            'category.required' => 'Kategorija je obavezna.',
            'category.in' => 'Odabrana kategorija nije valjana.',
            'document_number.max' => 'Broj isprave može imati najviše 255 znakova.',
            'issuer.max' => 'Izdavatelj može imati najviše 255 znakova.',
            'issued_at.date' => 'Datum izdavanja nije valjan.',
            'expires_at.date' => 'Datum isteka nije valjan.',
            'reminder_days.integer' => 'Broj dana prije isteka mora biti cijeli broj.',
            'reminder_days.min' => 'Broj dana prije isteka mora biti veći od nule.',
            'note.max' => 'Napomena može imati najviše 65.535 znakova.',
            'front_image.image' => 'Prednja strana mora biti slika.',
            'front_image.max' => 'Prednja slika može biti najveća 5 MB.',
            'back_image.image' => 'Stražnja strana mora biti slika.',
            'back_image.max' => 'Stražnja slika može biti najveća 5 MB.',
        ]);
    }

    private function resolveStatus($expiresAt): array
    {
        if (! $expiresAt) {
            return [
                'class' => 'valid',
                'label' => 'Aktivna',
            ];
        }

        if ($expiresAt->isPast()) {
            return [
                'class' => 'expired',
                'label' => 'Istekla',
            ];
        }

        if ($expiresAt->lte(now()->addDays(90))) {
            return [
                'class' => 'warning',
                'label' => 'Istječe uskoro',
            ];
        }

        return [
            'class' => 'valid',
            'label' => 'Važeća',
        ];
    }

    private function previewClassForCategory(string $category): string
    {
        return match ($category) {
            'vozilo' => 'license',
            'putovanje' => 'passport',
            'zdravstvo' => 'health',
            'ostalo' => 'eu',
            default => '',
        };
    }

    private function previewChipForCategory(string $label, string $category): string
    {
        return match ($category) {
            'identitet' => '🇭🇷 Republika Hrvatska',
            'vozilo' => 'Vozačka dozvola',
            'zdravstvo' => 'HZZO',
            'putovanje' => 'Europska unija',
            default => $label,
        };
    }

    private function codeLabelForCategory(string $label): string
    {
        return match ($label) {
            'Vozačka dozvola' => 'Broj dozvole',
            'Europska unija' => 'Broj putovnice',
            'HZZO' => 'Broj iskaznice',
            default => 'Broj isprave',
        };
    }

    private function formatCroatianDate($date): string
    {
        $months = [
            1 => 'siječnja',
            2 => 'veljače',
            3 => 'ožujka',
            4 => 'travnja',
            5 => 'svibnja',
            6 => 'lipnja',
            7 => 'srpnja',
            8 => 'kolovoza',
            9 => 'rujna',
            10 => 'listopada',
            11 => 'studenoga',
            12 => 'prosinca',
        ];

        $day = (int) $date->format('j');
        $month = $months[(int) $date->format('n')] ?? $date->format('F');
        $year = $date->format('Y');

        return sprintf('%d. %s %s.', $day, $month, $year);
    }
}
