@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Uredi ispravu')
@section('body_class', 'isprave-create-page isprave-edit-page')

@php
    $selectedCategory = old('category', $isprava->category);
@endphp

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

            <h1>Uredi ispravu</h1>
            <p>Promijeni podatke, zamijeni fotografije i ažuriraj podsjetnik po potrebi.</p>
        </div>

        <span class="status-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m9 12 2 2 4-4"/>
                <circle cx="12" cy="12" r="9"/>
            </svg>
            Spremljena isprava
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

    <form id="documentForm" method="POST" action="{{ route('isprave.update', $isprava) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card">
            <section class="form-section">
                <div class="section-title">
                    <h2>Osnovni podaci</h2>
                    <p>Polja prikazana na kartici isprave.</p>
                </div>

                <div class="field-grid two-cols">
                    <div class="field">
                        <label for="name">Naziv isprave</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $isprava->name) }}" placeholder="Osobna iskaznica" required>
                    </div>

                    <div class="field">
                        <label for="category">Kategorija</label>
                        <select id="category" name="category">
                            @foreach ($filters as $value => $label)
                                <option value="{{ $value }}" @selected($selectedCategory === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label for="document_number">Broj isprave</label>
                        <input id="document_number" name="document_number" type="text" value="{{ old('document_number', $isprava->document_number) }}" placeholder="123456789">
                    </div>

                    <div class="field">
                        <label for="issuer">Izdavatelj</label>
                        <input id="issuer" name="issuer" type="text" value="{{ old('issuer', $isprava->issuer) }}" placeholder="Republika Hrvatska">
                    </div>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title">
                    <h2>Datumi i podsjetnik</h2>
                    <p>Postavi datume i automatsko upozorenje prije isteka.</p>
                </div>

                <div class="field-grid two-cols">
                    <div class="field">
                        <label for="issued_at">Datum izdavanja</label>
                        <input id="issued_at" name="issued_at" type="date" value="{{ old('issued_at', optional($isprava->issued_at)->format('Y-m-d')) }}">
                    </div>

                    <div class="field">
                        <label for="expires_at">Vrijedi do</label>
                        <input id="expires_at" name="expires_at" type="date" value="{{ old('expires_at', optional($isprava->expires_at)->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="reminder-card">
                    <div class="reminder-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 8v4l3 3"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                    </div>

                    <div style="flex: 1 1 auto;">
                        <strong>Podsjetnik prije isteka</strong>
                        <span>Obavijest će biti poslana na email povezan s korisničkim računom.</span>

                        <div class="switch-row">
                            <div class="switch-copy">
                                <strong>Uključi podsjetnik</strong>
                                <span>Pošalji upozorenje prije isteka.</span>
                            </div>

                            <label class="switch" for="reminder_enabled">
                                <input type="hidden" name="reminder_enabled" value="0">
                                <input id="reminder_enabled" name="reminder_enabled" type="checkbox" value="1" @checked(old('reminder_enabled', $isprava->reminder_enabled))>
                                <span class="switch-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="field" style="margin-top: 16px;">
                    <label for="reminder_days">Broj dana prije isteka</label>
                    <input id="reminder_days" name="reminder_days" type="number" min="1" max="3650" value="{{ old('reminder_days', $isprava->reminder_days) }}" placeholder="90">
                    <small>Odredi koliko dana prije isteka želiš dobiti obavijest.</small>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title">
                    <h2>Fotografije isprave</h2>
                    <p>Zamijeni prednju i stražnju stranu po potrebi.</p>
                </div>

                <div class="image-grid">
                    <article class="upload-card">
                        <div class="upload-preview">
                            <span class="image-label">Prednja strana</span>
                            <div class="image-placeholder">
                                @if ($isprava->front_image_path)
                                    <img src="{{ asset('storage/' . $isprava->front_image_path) }}" alt="Trenutna prednja strana" style="max-width:100%; max-height:140px; border-radius:14px; object-fit:contain; margin-bottom:10px;">
                                    <strong id="frontImageName">{{ basename($isprava->front_image_path) }}</strong>
                                    <span id="frontImageMeta">Trenutno spremljena slika</span>
                                @else
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="14" rx="3"/>
                                        <circle cx="8.5" cy="10" r="1.5"/>
                                        <path d="m6 16 4-4 3 3 2-2 3 3"/>
                                    </svg>
                                    <strong id="frontImageName">Nema slike</strong>
                                    <span id="frontImageMeta">Učitaj ili snimi prednju stranu</span>
                                @endif
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
                                @if ($isprava->back_image_path)
                                    <img src="{{ asset('storage/' . $isprava->back_image_path) }}" alt="Trenutna stražnja strana" style="max-width:100%; max-height:140px; border-radius:14px; object-fit:contain; margin-bottom:10px;">
                                    <strong id="backImageName">{{ basename($isprava->back_image_path) }}</strong>
                                    <span id="backImageMeta">Trenutno spremljena slika</span>
                                @else
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="14" rx="3"/>
                                        <path d="M7 9h10M7 13h7M7 16h5"/>
                                    </svg>
                                    <strong id="backImageName">Nema slike</strong>
                                    <span id="backImageMeta">Učitaj ili snimi stražnju stranu</span>
                                @endif
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
                    <textarea id="note" name="note" placeholder="Dodaj napomenu...">{{ old('note', $isprava->note) }}</textarea>
                </div>
            </section>
        </div>

        <div class="form-actions">
            <a class="secondary-button" id="cancelButton" href="{{ route('isprave.show', $isprava) }}">Odustani</a>
            <button class="primary-button" type="submit">Spremi promjene</button>
        </div>
    </form>

    <div class="toast" id="toast" data-status="{{ session('status') }}"></div>
@endsection

@section('after_main')
    @include('layouts.partials.sidebar-mobile', ['active' => 'isprave'])
    @include('layouts.partials.user-menu-modal')
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
                    label.name.textContent = key === 'frontImageInput' ? 'Nema slike' : 'Nema slike';
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
            window.location.href = @json(route('isprave.show', $isprava));
        });

        function showToast(message) {
            if (!toast) {
                return;
            }

            toast.textContent = message;
            toast.classList.add('show');

            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2600);
        }

        const initialStatus = toast?.dataset?.status;
        if (initialStatus) {
            showToast(initialStatus);
        }

        const mobileUserTrigger = document.getElementById('mobileUserTrigger');
        const userMenuModal = document.getElementById('userMenuModal');
        const closeUserMenu = document.getElementById('closeUserMenu');

        mobileUserTrigger?.addEventListener('click', () => {
            userMenuModal?.classList.add('open');
        });

        closeUserMenu?.addEventListener('click', () => {
            userMenuModal?.classList.remove('open');
        });

        userMenuModal?.addEventListener('click', event => {
            if (event.target === userMenuModal) {
                userMenuModal.classList.remove('open');
            }
        });
    </script>
@endpush
