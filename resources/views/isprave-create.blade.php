@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Dodaj ispravu')
@section('body_class', 'isprave-create-page')

@php
    $createUserName = auth()->user()?->name ?? 'User';
    $createUserInitials = collect(preg_split('/\s+/', trim($createUserName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');
@endphp

@section('content')
    <header class="topbar">
        <a href="{{ route('isprave') }}" class="back-link">
            <span class="back-icon">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
            </span>
            Isprave
        </a>

        <div class="avatar">{{ $createUserInitials ?: 'GB' }}</div>
    </header>

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

    <form id="documentForm">
        <div class="form-card">
            <section class="form-section">
                <div class="section-title">
                    <h2>Osnovni podaci</h2>
                    <p>Podaci koji se prikazuju na kartici isprave i u pretrazi.</p>
                </div>

                <div class="field-grid two-cols">
                    <div class="field">
                        <label for="name">Naziv isprave</label>
                        <input id="name" name="name" type="text" placeholder="Osobna iskaznica" required>
                    </div>

                    <div class="field">
                        <label for="category">Kategorija</label>
                        <select id="category" name="category">
                            <option value="identitet">Identitet</option>
                            <option value="vozilo">Vožnja</option>
                            <option value="zdravstvo">Zdravstvo</option>
                            <option value="putovanje">Putovanje</option>
                            <option value="ostalo" selected>Ostalo</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="documentNumber">Broj isprave</label>
                        <input id="documentNumber" name="document_number" type="text" placeholder="123456789" required>
                    </div>

                    <div class="field">
                        <label for="issuer">Izdavatelj</label>
                        <input id="issuer" name="issuer" type="text" placeholder="Republika Hrvatska">
                    </div>

                    <div class="field">
                        <label for="issuedAt">Datum izdavanja</label>
                        <input id="issuedAt" name="issued_at" type="date">
                    </div>

                    <div class="field">
                        <label for="expiresAt">Vrijedi do</label>
                        <input id="expiresAt" name="expires_at" type="date">
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
                                <strong>Nema slike</strong>
                                <span>Učitaj ili snimi prednju stranu</span>
                            </div>
                        </div>

                        <div class="upload-actions">
                            <button class="secondary-button" type="button" onclick="showToast('Otvoren odabir prednje fotografije.')">Učitaj</button>
                            <button class="secondary-button" type="button" onclick="showToast('Otvorena kamera za prednju stranu.')">Snimi</button>
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
                                <strong>Nema slike</strong>
                                <span>Učitaj ili snimi stražnju stranu</span>
                            </div>
                        </div>

                        <div class="upload-actions">
                            <button class="secondary-button" type="button" onclick="showToast('Otvoren odabir stražnje fotografije.')">Učitaj</button>
                            <button class="secondary-button" type="button" onclick="showToast('Otvorena kamera za stražnju stranu.')">Snimi</button>
                        </div>
                    </article>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title">
                    <h2>Podsjetnik isteka</h2>
                    <p>Pošalji obavijest prije nego što isprava prestane vrijediti.</p>
                </div>

                <div class="reminder-card">
                    <div class="reminder-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                            <path d="M10 21h4"/>
                        </svg>
                    </div>

                    <div>
                        <strong>Podsjetnik prije isteka</strong>
                        <span>Obavijest će biti poslana na email povezan s korisničkim računom.</span>
                    </div>
                </div>

                <div class="switch-row">
                    <div class="switch-copy">
                        <strong>Uključi podsjetnik</strong>
                        <span>Pošalji upozorenje 90 dana prije isteka.</span>
                    </div>

                    <label class="switch">
                        <input id="reminderEnabled" type="checkbox" checked>
                        <span class="switch-slider"></span>
                    </label>
                </div>

                <div class="field" style="margin-top:15px;">
                    <label for="reminderDays">Broj dana prije isteka</label>
                    <select id="reminderDays" name="reminder_days">
                        <option value="30">30 dana</option>
                        <option value="60">60 dana</option>
                        <option value="90" selected>90 dana</option>
                        <option value="180">180 dana</option>
                    </select>
                </div>
            </section>

            <section class="form-section">
                <div class="section-title">
                    <h2>Napomena</h2>
                    <p>Dodatni privatni tekst vidljiv samo vlasniku isprave.</p>
                </div>

                <div class="field">
                    <label for="note">Napomena</label>
                    <textarea id="note" name="note" placeholder="Dodaj napomenu..."></textarea>
                </div>
            </section>
        </div>

        <div class="form-actions">
            <a class="secondary-button" href="{{ route('isprave') }}">Odustani</a>
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
        const form = document.getElementById('documentForm');
        const reminderEnabled = document.getElementById('reminderEnabled');
        const reminderDays = document.getElementById('reminderDays');
        const toast = document.getElementById('toast');

        reminderEnabled.addEventListener('change', () => {
            reminderDays.disabled = !reminderEnabled.checked;
        });

        reminderDays.disabled = !reminderEnabled.checked;

        form.addEventListener('submit', event => {
            event.preventDefault();
            showToast('Isprava je spremljena.');
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
