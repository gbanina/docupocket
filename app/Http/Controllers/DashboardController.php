<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\Isprava;
use App\Models\Podatak;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $podaci = $request->user()
            ->podaci()
            ->latest()
            ->get()
            ->map(fn (Podatak $podatak) => $this->presentPodatak($podatak));

        $isprave = $request->user()
            ->isprave()
            ->latest()
            ->take(3)
            ->get()
            ->map(fn (Isprava $isprava) => $this->presentIsprava($isprava));

        $dokumenti = $request->user()
            ->dokumenti()
            ->latest()
            ->take(3)
            ->get()
            ->map(fn (Dokument $document) => $this->presentDocument($document));

        return view('dashboard', compact('podaci', 'isprave', 'dokumenti'));
    }

    private function presentPodatak(Podatak $podatak): object
    {
        return (object) [
            'id' => $podatak->id,
            'label' => $podatak->label,
            'value' => $podatak->value,
            'category' => $podatak->category,
        ];
    }

    private function presentIsprava(Isprava $isprava): object
    {
        $category = $isprava->category;
        $categoryLabel = config('docupocket.isprave.categories.' . $category, ucfirst($category));
        $expiresAt = $isprava->expires_at;

        return (object) [
            'id' => $isprava->id,
            'name' => $isprava->name,
            'document_number' => $isprava->document_number ?: 'Nije uneseno',
            'code_label' => $this->codeLabelForCategory($categoryLabel),
            'preview_class' => $this->previewClassForCategory($category),
            'preview_chip' => $this->previewChipForCategory($categoryLabel, $category),
            'expires_label' => $expiresAt ? $this->formatCroatianDate($expiresAt) : 'Nije postavljeno',
            'status_label' => $this->resolveStatus($expiresAt)['label'],
            'status_class' => $this->resolveStatus($expiresAt)['class'],
        ];
    }

    private function presentDocument(Dokument $document): object
    {
        $extension = strtolower(pathinfo($document->original_name, PATHINFO_EXTENSION));
        $typeKey = match ($extension) {
            'pdf' => 'pdf',
            'doc', 'docx' => 'docx',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'image',
            default => 'other',
        };

        return (object) [
            'id' => $document->id,
            'name' => $document->name,
            'original_name' => $document->original_name,
            'type_key' => $typeKey,
            'type_label' => strtoupper($extension ?: 'DAT'),
            'file_size_label' => $this->formatFileSize($document->file_size),
            'date_label' => $this->formatCroatianDate($document->created_at),
            'share_label' => $document->original_name,
        ];
    }

    private function resolveStatus($expiresAt): array
    {
        if (! $expiresAt) {
            return ['class' => 'valid', 'label' => 'Aktivna'];
        }

        if ($expiresAt->isPast()) {
            return ['class' => 'expired', 'label' => 'Istekla'];
        }

        if ($expiresAt->lte(now()->addDays(90))) {
            return ['class' => 'warning', 'label' => 'Istječe uskoro'];
        }

        return ['class' => 'valid', 'label' => 'Važeća'];
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

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1024 * 1024) {
            return number_format($bytes / 1024 / 1024, 1, ',', '.') . ' MB';
        }

        return max(1, (int) round($bytes / 1024)) . ' KB';
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
