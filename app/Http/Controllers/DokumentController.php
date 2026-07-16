<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DokumentController extends Controller
{
    public function create(): View
    {
        return view('dokumenti-create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateDokument($request, requireFile: true);

        $file = $request->file('file');
        $filePath = $file->store($request->user()->id, 'local');

        $request->user()->dokumenti()->create([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'file_path' => $filePath,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType() ?: $file->getMimeType() ?: 'application/octet-stream',
            'file_size' => $file->getSize() ?: 0,
        ]);

        return to_route('dokumenti')->with('status', 'Dokument je spremljen.');
    }

    public function editLatest(Request $request): View
    {
        $document = $request->user()
            ->dokumenti()
            ->latest()
            ->first();

        if (! $document) {
            return $this->create();
        }

        return $this->edit($request, $document);
    }

    public function edit(Request $request, Dokument $document): View
    {
        abort_unless($document->user_id === $request->user()->id, 404);

        return view('dokumenti-edit', [
            'document' => $document,
            'categories' => $this->categories(),
        ]);
    }

    public function update(Request $request, Dokument $document): RedirectResponse
    {
        abort_unless($document->user_id === $request->user()->id, 404);

        $validated = $this->validateDokument($request, requireFile: false);

        $payload = [
            'name' => $validated['name'],
            'category' => $validated['category'],
        ];

        if ($request->hasFile('file')) {
            Storage::disk('local')->delete($document->file_path);

            $file = $request->file('file');
            $filePath = $file->store($request->user()->id, 'local');

            $payload['file_path'] = $filePath;
            $payload['original_name'] = $file->getClientOriginalName();
            $payload['mime_type'] = $file->getClientMimeType() ?: $file->getMimeType() ?: 'application/octet-stream';
            $payload['file_size'] = $file->getSize() ?: 0;
        }

        $document->update($payload);

        return to_route('dokumenti')->with('status', 'Dokument je ažuriran.');
    }

    public function destroy(Request $request, Dokument $document): RedirectResponse
    {
        abort_unless($document->user_id === $request->user()->id, 404);

        Storage::disk('local')->delete($document->file_path);
        $document->delete();

        return to_route('dokumenti')->with('status', 'Dokument je obrisan.');
    }

    /**
     * @return array<int, string>
     */
    private function categories(): array
    {
        return config('docupocket.dokumenti.categories', []);
    }

    /**
     * @return array{name: string, category: string}
     */
    private function validateDokument(Request $request, bool $requireFile): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', Rule::in(array_keys($this->categories()))],
            'file' => array_filter([
                $requireFile ? 'required' : 'nullable',
                'file',
                'max:10240',
                'mimes:pdf,doc,docx,jpg,jpeg,png',
            ]),
        ], [
            'name.required' => 'Naziv dokumenta je obavezan.',
            'name.max' => 'Naziv dokumenta može imati najviše 255 znakova.',
            'category.required' => 'Kategorija je obavezna.',
            'category.in' => 'Odabrana kategorija nije valjana.',
            'file.required' => 'Datoteka je obavezna.',
            'file.file' => 'Datoteka nije valjana.',
            'file.max' => 'Datoteka može biti najveća 10 MB.',
            'file.mimes' => 'Datoteka mora biti PDF, DOC, DOCX, JPG ili PNG.',
        ]);

        return [
            'name' => trim($validated['name']),
            'category' => $validated['category'],
        ];
    }
}
