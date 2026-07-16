@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Uredi dokument')
@section('body_class', 'dokumenti-edit-page')

@php
    $categories = $categories ?? config('docupocket.dokumenti.categories', []);
    $selectedCategory = old('category', $document->category ?? '');
    $fileSizeMb = $document ? number_format($document->file_size / 1024 / 1024, 1, ',', '.') : null;
@endphp

@section('content')
    <section class="page-heading">
        <div class="page-heading-copy">
            <div class="eyebrow">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                </svg>
                Uređivanje dokumenta
            </div>

            <h1>Uredi dokument</h1>
            <p>Promijeni osnovne podatke dokumenta ili zamijeni datoteku novom verzijom.</p>
        </div>

        <span class="status-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            Spremljeno
        </span>
    </section>

    @if ($errors->any())
        <div class="danger-zone" style="margin-bottom: 18px;">
            <h3>Provjeri unesene podatke</h3>
            <p>Forma se nije mogla spremiti. Ispravi označena polja i pokušaj ponovno.</p>
            <ul style="margin: 0; padding-left: 18px; color: var(--danger); font-size: 12px; line-height: 1.6;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="documentEditForm" method="POST" action="{{ route('dokumenti.update', $document) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card">
            <section class="form-section">
                <div class="section-title section-title-row">
                    <div>
                        <h2>Osnovne informacije</h2>
                        <p>Podaci koji se prikazuju na stranici dokumenata i u pretrazi.</p>
                    </div>

                    <button class="icon-button" type="button" aria-label="Podijeli dokument" onclick="showToast('Otvoren unos adrese za dijeljenje.')">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                        </svg>
                    </button>
                </div>

                <div class="field-grid two-cols">
                    <div class="field">
                        <label for="name">Naziv dokumenta</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $document->name) }}" required>
                    </div>

                    <div class="field">
                        <label for="category">Kategorija</label>
                        <select id="category" name="category" required>
                            <option value="" @selected($selectedCategory === '')>Odaberi kategoriju</option>
                            @foreach ($categories as $value => $label)
                                <option value="{{ $value }}" @selected($selectedCategory === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title">
                    <h2>Datoteka</h2>
                    <p>Pregledaj trenutačnu datoteku ili je zamijeni novom verzijom.</p>
                </div>

                <div class="file-card">
                    <div class="file-main">
                        <div class="file-icon">
                            <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7 3h7l4 4v14H7z"/>
                                <path d="M14 3v5h5"/>
                            </svg>
                        </div>

                        <div class="file-copy">
                            <strong id="fileName">{{ $document->original_name }}</strong>
                            <span id="fileMeta">{{ strtoupper(pathinfo($document->original_name, PATHINFO_EXTENSION)) }} · {{ $fileSizeMb }} MB</span>
                            <span>Učitano {{ $document->created_at->format('d.m.Y. H:i') }}</span>
                        </div>
                    </div>

                    <div class="file-actions">
                    <a class="secondary-button" href="{{ route('dokumenti.preview', ['document' => $document->id]) }}" target="_blank" rel="noopener">Pregled</a>
                    <button class="secondary-button" type="button" id="replaceButton">Zamijeni datoteku</button>
                </div>
            </div>

                <input id="fileInput" name="file" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" hidden>
            </section>

            <section class="form-section">
                <div class="danger-zone">
                    <h3>Izbriši dokument</h3>
                    <p>Brisanjem će se ukloniti datoteka, svi metapodaci i dokument iz baze.</p>
                    <button class="danger-button" id="deleteButton" type="submit" form="deleteDocumentForm">Izbriši dokument</button>
                </div>
            </section>
        </div>

        <div class="form-actions">
            <a class="secondary-button" id="cancelButton" href="{{ route('dokumenti') }}">Odustani</a>
            <button class="primary-button" type="submit">Spremi promjene</button>
        </div>
    </form>
@endsection

@section('after_main')
    @include('layouts.partials.sidebar-mobile', ['active' => 'dokumenti'])
    @include('layouts.partials.user-menu-modal')

    <div class="toast" id="toast"></div>

    <form id="deleteDocumentForm" method="POST" action="{{ route('dokumenti.destroy', $document) }}" hidden>
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        const toast = document.getElementById('toast');
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');
        const fileMeta = document.getElementById('fileMeta');

        document.getElementById('replaceButton').addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files?.[0];

            if (!file) {
                return;
            }

            fileName.textContent = file.name;
            fileMeta.textContent = `${Math.max(1, Math.round(file.size / 1024))} KB`;
            showToast('Nova datoteka je odabrana.');
        });

        document.getElementById('deleteButton').addEventListener('click', (event) => {
            if (!confirm('Želiš li zaista izbrisati ovaj dokument?')) {
                event.preventDefault();
            }
        });

        document.getElementById('cancelButton').addEventListener('click', (event) => {
            event.preventDefault();
            window.location.href = @json(route('dokumenti'));
        });

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');

            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2600);
        }
    </script>
@endpush
