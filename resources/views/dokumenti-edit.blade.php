@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Uredi dokument')
@section('body_class', 'dokumenti-edit-page')

@php
    $documentUserName = auth()->user()?->name ?? 'User';
    $documentUserInitials = collect(preg_split('/\s+/', trim($documentUserName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');
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
            <p>Promijeni osnovne podatke dokumenta, zamijeni datoteku ili upravljaj aktivnim dijeljenjima.</p>
        </div>

        <span class="status-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9"/>
                <path d="m9 12 2 2 4-4"/>
            </svg>
            Podijeljeno s 1 osobom
        </span>
    </section>

    <form id="documentEditForm" method="POST">
        @csrf

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
                        <input id="name" name="name" type="text" value="Polica putnog osiguranja" required>
                    </div>

                    <div class="field">
                        <label for="category">Kategorija</label>
                        <select id="category" name="category">
                            <option selected>Putovanje</option>
                            <option>Osobno</option>
                            <option>Zdravstvo</option>
                            <option>Financije</option>
                            <option>Ugovori</option>
                            <option>Ostalo</option>
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
                            <strong id="fileName">polica-putnog-osiguranja.pdf</strong>
                            <span id="fileMeta">PDF · 1,8 MB</span>
                            <span>Učitano 14. srpnja 2026. u 18:42</span>
                        </div>
                    </div>

                    <div class="file-actions">
                        <button class="secondary-button" type="button" id="previewButton">Pregled</button>
                        <button class="secondary-button" type="button" id="replaceButton">Zamijeni datoteku</button>
                    </div>
                </div>

                <input id="fileInput" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" hidden>
            </section>

            <section class="form-section">
                <div class="danger-zone">
                    <h3>Izbriši dokument</h3>
                    <p>Brisanjem će se ukloniti datoteka, svi metapodaci i aktivna dijeljenja ovog dokumenta.</p>
                    <button class="danger-button" id="deleteButton" type="button">Izbriši dokument</button>
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
@endsection

@push('scripts')
    <script>
        const toast = document.getElementById('toast');
        const form = document.getElementById('documentEditForm');
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');
        const fileMeta = document.getElementById('fileMeta');

        document.getElementById('previewButton').addEventListener('click', () => {
            showToast('Otvoren pregled dokumenta.');
        });

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

        document.getElementById('deleteButton').addEventListener('click', () => {
            if (confirm('Želiš li zaista izbrisati ovaj dokument?')) {
                showToast('Dokument je označen za brisanje.');
            }
        });

        document.getElementById('cancelButton').addEventListener('click', (event) => {
            event.preventDefault();
            showToast('Promjene nisu spremljene.');
            window.setTimeout(() => {
                window.location.href = @json(route('dokumenti'));
            }, 180);
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            if (!document.getElementById('name').value.trim()) {
                showToast('Unesi naziv dokumenta.');
                return;
            }

            showToast('Promjene su uspješno spremljene.');
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
