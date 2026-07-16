<?php

namespace App\Http\Controllers;

use App\Models\Isprava;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IspravaController extends Controller
{
    public function create(): View
    {
        return view('isprave-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(array_keys(config('docupocket.isprave.categories', [])))],
            'note' => ['nullable', 'string', 'max:65535'],
            'front_image' => ['nullable', 'image', 'max:5120'],
            'back_image' => ['nullable', 'image', 'max:5120'],
        ], [
            'name.required' => 'Naziv isprave je obavezan.',
            'name.max' => 'Naziv isprave može imati najviše 255 znakova.',
            'category.required' => 'Kategorija je obavezna.',
            'category.in' => 'Odabrana kategorija nije valjana.',
            'note.max' => 'Napomena može imati najviše 65.535 znakova.',
            'front_image.image' => 'Prednja strana mora biti slika.',
            'front_image.max' => 'Prednja slika može biti najveća 5 MB.',
            'back_image.image' => 'Stražnja strana mora biti slika.',
            'back_image.max' => 'Stražnja slika može biti najveća 5 MB.',
        ]);

        $frontImagePath = $request->file('front_image')
            ? $request->file('front_image')->store('isprave', 'public')
            : null;

        $backImagePath = $request->file('back_image')
            ? $request->file('back_image')->store('isprave', 'public')
            : null;

        $request->user()->isprave()->create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'note' => $validated['note'] ?? null,
            'front_image_path' => $frontImagePath,
            'back_image_path' => $backImagePath,
        ]);

        return to_route('isprave')->with('status', 'Isprava je spremljena.');
    }
}
