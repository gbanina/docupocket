<?php

namespace App\Http\Controllers;

use App\Models\Podatak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PodatakController extends Controller
{
    public function index(Request $request): View
    {
        $savedPodaci = $request->user()
            ->podaci()
            ->latest()
            ->get();

        $summary = [
            'total' => $savedPodaci->count(),
            'identitet' => $savedPodaci->where('category', 'identitet')->count(),
            'zdravstvo' => $savedPodaci->where('category', 'zdravstvo')->count(),
            'financije' => $savedPodaci->where('category', 'financije')->count(),
            'kreditne_kartice' => $savedPodaci->where('category', 'kreditna-kartica')->count(),
        ];

        return view('podaci', compact('savedPodaci', 'summary'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePodatak($request);

        $request->user()->podaci()->create($validated);

        return to_route('podaci')->with('status', 'Podatak je spremljen.');
    }

    public function update(Request $request, Podatak $podatak): RedirectResponse
    {
        abort_unless($podatak->user_id === $request->user()->id, 404);

        $validated = $this->validatePodatak($request);

        $podatak->update($validated);

        return to_route('podaci')->with('status', 'Podatak je ažuriran.');
    }

    /**
     * @return array{label: string, value: string, category: string}
     */
    private function validatePodatak(Request $request): array
    {
        $categories = array_keys(config('docupocket.data.categories', []));

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'value' => ['required', 'string', 'max:65535'],
            'category' => ['required', 'string', Rule::in($categories)],
        ]);

        if ($validated['category'] === 'kreditna-kartica') {
            $digits = preg_replace('/\D+/', '', $validated['value']);

            if (strlen($digits) !== 16) {
                throw ValidationException::withMessages([
                    'value' => 'Broj kartice mora imati 16 znamenki.',
                ]);
            }

            $validated['value'] = implode('-', str_split($digits, 4));
        } else {
            $validated['value'] = trim($validated['value']);
        }

        return $validated;
    }
}
