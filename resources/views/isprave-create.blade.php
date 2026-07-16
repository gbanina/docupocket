@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Dodaj ispravu')
@section('body_class', 'isprave-create-page')

@section('content')
    <section class="page-heading">
        <div>
            <span class="eyebrow">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                </svg>
                Uređivanje
            </span>

            <h1>Dodaj ispravu</h1>
            <p>Unesi osnovne podatke, dodaj fotografije prednje i stražnje strane te po potrebi postavi podsjetnik prije isteka.</p>
        </div>

        <span class="status-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m9 12 2 2 4-4"/>
                <circle cx="12" cy="12" r="9"/>
            </svg>
            Spremno za unos
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

    <form id="documentForm" method="POST" action="{{ route('isprave.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-card">
            <section class="form-section">
                <div class="section-title">
                    <h2>Osnovni podaci</h2>
                    <p>Podaci koji se prikazuju na kartici isprave i u pretrazi.</p>
                </div>

                <div class="field-grid two-cols">
                    <div class="field">
                        <label for="name">Naziv isprave</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Osobna iskaznica" required>
                    </div>

                    <div class="field">
                        <label for="category">Kategorija</label>
                        <select id="category" name="category">
                            <option value="identitet" @selected(old('category') === 'identitet')>Identitet</option>
                            <option value="vozilo" @selected(old('category') === 'vozilo')>Vožnja</option>
                            <option value="zdravstvo" @selected(old('category') === 'zdravstvo')>Zdravstvo</option>
                            <option value="putovanje" @selected(old('category') === 'putovanje')>Putovanje</option>
                            <option value="ostalo" @selected(old('category', 'ostalo') === 'ostalo')>Ostalo</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title">
                    <h2>Fotografije isprave</h2>
                    <p>Dodaj prednju i stražnju stranu isprave.</p>
                </div>

                <div class="image-grid">
                    <article class="upload-card">
                        <div class="upload-preview">
                            <span class="image-label">Prednja strana</span>
                            <div class="image-placeholder">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="14" rx="3"/>
                                    <circle cx="8.5" cy="10" r="1.5"/>
                                    <path d="m6 16 4-4 3 3 2-2 3 3"/>
                                </svg>
                                <strong id="frontImageName">Nema slike</strong>
                                <span id="frontImageMeta">Učitaj ili snimi prednju stranu</span>
                            </div>
                        </div>

                        <input id="frontImageInput" name="front_image" type="file" accept="image/*" capture="environment" hidden>
                        <div class="upload-actions">
                            <button class="secondary-button" type="button" data-target="frontImageInput">Učitaj</button>
                            <button class="secondary-button" type="button" data-target="frontImageInput">Snimi</button>
                        </div>
                    </article>

                    <article class="upload-card">
                        <div class="upload-preview back">
                            <span class="image-label">Stražnja strana</span>
                            <div class="image-placeholder">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="14" rx="3"/>
                                    <path d="M7 9h10M7 13h7M7 16h5"/>
                                </svg>
                                <strong id="backImageName">Nema slike</strong>
                                <span id="backImageMeta">Učitaj ili snimi stražnju stranu</span>
                            </div>
                        </div>

                        <input id="backImageInput" name="back_image" type="file" accept="image/*" capture="environment" hidden>
                        <div class="upload-actions">
                            <button class="secondary-button" type="button" data-target="backImageInput">Učitaj</button>
                            <button class="secondary-button" type="button" data-target="backImageInput">Snimi</button>
                        </div>
                    </article>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title">
                    <h2>Napomena</h2>
                    <p>Dodatni privatni tekst vidljiv samo vlasniku isprave.</p>
                </div>

                <div class="field">
                    <label for="note">Napomena</label>
                    <textarea id="note" name="note" placeholder="Dodaj napomenu...">{{ old('note') }}</textarea>
                </div>
            </section>
        </div>

        <div class="form-actions">
            <a class="secondary-button" id="cancelButton" href="{{ route('isprave') }}">Odustani</a>
            <button class="primary-button" type="submit">Spremi ispravu</button>
        </div>
    </form>
@endsection

@section('after_main')
    @include('layouts.partials.sidebar-mobile', ['active' => 'isprave'])
    @include('layouts.partials.user-menu-modal')

    <div class="toast" id="toast"></div>
@endsection

@push('scripts')
    <script>
        const toast = document.getElementById('toast');
        const fileButtons = document.querySelectorAll('[data-target]');
        const fileInputs = {
            frontImageInput: document.getElementById('frontImageInput'),
            backImageInput: document.getElementById('backImageInput'),
        };
        const fileLabels = {
            frontImageInput: {
                name: document.getElementById('frontImageName'),
                meta: document.getElementById('frontImageMeta'),
            },
            backImageInput: {
                name: document.getElementById('backImageName'),
                meta: document.getElementById('backImageMeta'),
            },
        };

        fileButtons.forEach(button => {
            button.addEventListener('click', () => {
                const input = fileInputs[button.dataset.target];

                if (input) {
                    input.click();
                }
            });
        });

        Object.entries(fileInputs).forEach(([key, input]) => {
            input.addEventListener('change', () => {
                const file = input.files?.[0];
                const label = fileLabels[key];

                if (!label) {
                    return;
                }

                if (!file) {
                    label.name.textContent = 'Nema slike';
                    label.meta.textContent = key === 'frontImageInput'
                        ? 'Učitaj ili snimi prednju stranu'
                        : 'Učitaj ili snimi stražnju stranu';
                    return;
                }

                label.name.textContent = file.name;
                label.meta.textContent = `${Math.round(file.size / 1024)} KB`;
            });
        });

        document.getElementById('cancelButton').addEventListener('click', () => {
            window.location.href = @json(route('isprave'));
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
