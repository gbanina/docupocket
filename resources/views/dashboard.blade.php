<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f5f7fb">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('img/site.webmanifest') }}">

    <title>{{ config('app.name', 'DocuPocket') }} — Osobni dokumenti</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
@php
    $userName = auth()->user()?->name ?? 'User';
    $initials = collect(preg_split('/\s+/', trim($userName)))
        ->filter()
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
    $initials = $initials ?: 'DP';
@endphp
<div class="app-shell">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M7 3h7l4 4v14H7z"/>
                    <path d="M14 3v5h5"/>
                    <path d="M10 13h5M10 17h5"/>
                </svg>
            </div>
            DocuPocket
        </div>

        <nav class="sidebar-nav">
            <a class="sidebar-link active" href="#">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="2"/>
                    <rect x="14" y="3" width="7" height="7" rx="2"/>
                    <rect x="3" y="14" width="7" height="7" rx="2"/>
                    <rect x="14" y="14" width="7" height="7" rx="2"/>
                </svg>
                Dashboard
            </a>

            <a class="sidebar-link" href="#podaci">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21a8 8 0 0 1 16 0"/>
                </svg>
                Osnovni podaci
            </a>

            <a class="sidebar-link" href="#isprave">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="5" width="18" height="14" rx="3"/>
                    <path d="M7 9h4M7 13h7M16 10h1"/>
                </svg>
                Isprave
            </a>

            <a class="sidebar-link" href="#dokumenti">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M7 3h7l4 4v14H7z"/>
                    <path d="M14 3v5h5"/>
                </svg>
                Dokumenti
            </a>

            <div class="sidebar-user-menu">
                <a class="sidebar-link sidebar-user-trigger" href="{{ route('profile.edit') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>
                    {{ $userName }}
                    <svg class="sidebar-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </a>

                <div class="sidebar-submenu">
                    <div class="sidebar-submenu-header">
                        <strong>{{ $userName }}</strong>
                        <span>{{ auth()->user()?->email }}</span>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="sidebar-submenu-link">Profil</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-submenu-link sidebar-submenu-danger">Odjava</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="sidebar-footer">
            <strong>Privatni trezor</strong>
            <span>Dokumenti su dostupni samo tebi i osobama kojima ih izričito podijeliš.</span>
        </div>
    </aside>

    <main class="main">
        <section class="page-heading">
            <span class="eyebrow">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
                Tvoj privatni digitalni trezor
            </span>
            <h1>Tvoji podaci uvijek pri ruci.</h1>
        </section>

        <section class="section">
            <div class="section-heading">
                <div class="section-title">
                    <h2>Brze akcije</h2>
                    <p>Dodaj novi sadržaj u nekoliko sekundi.</p>
                </div>
            </div>

            <div class="quick-actions">
                <button class="quick-action" type="button" onclick="showToast('Otvorena forma za unos novog podatka.')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    <span>Dodaj podatak</span>
                </button>

                <button class="quick-action" type="button" onclick="showToast('Otvorena kamera za fotografiranje isprave.')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.5 4 16 7h3a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h3l1.5-3z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                    <span>Skeniraj ispravu</span>
                </button>

                <button class="quick-action" type="button" onclick="showToast('Otvoren odabir datoteke za prijenos.')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 3v12"/>
                        <path d="m7 8 5-5 5 5"/>
                        <path d="M5 21h14a2 2 0 0 0 2-2v-4M3 15v4a2 2 0 0 0 2 2"/>
                    </svg>
                    <span>Učitaj dokument</span>
                </button>
            </div>
        </section>

        <section class="section" id="podaci">
            <div class="section-heading">
                <div class="section-title">
                    <h2>Osnovni podaci</h2>
                    <p>Kopiraj vrijednost jednim dodirom.</p>
                </div>
                <button class="text-button" type="button">Uredi</button>
            </div>

            <div class="data-list data-card">
                <div class="data-row">
                    <div class="data-meta">
                        <span>OIB</span>
                        <strong>12345678901</strong>
                    </div>
                    <button class="copy-button" type="button" data-copy="12345678901" aria-label="Kopiraj OIB">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="11" height="11" rx="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>

                <div class="data-row">
                    <div class="data-meta">
                        <span>MBO zdravstvenog osiguranja</span>
                        <strong>908172635</strong>
                    </div>
                    <button class="copy-button" type="button" data-copy="908172635" aria-label="Kopiraj MBO">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="11" height="11" rx="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>

                <div class="data-row">
                    <div class="data-meta">
                        <span>Broj zdravstvene iskaznice</span>
                        <strong>HR-2026-817265</strong>
                    </div>
                    <button class="copy-button" type="button" data-copy="HR-2026-817265" aria-label="Kopiraj broj iskaznice">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="11" height="11" rx="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>

                <div class="data-row">
                    <div class="data-meta">
                        <span>IBAN</span>
                        <strong>HR1223600001234567890</strong>
                    </div>
                    <button class="copy-button" type="button" data-copy="HR1223600001234567890" aria-label="Kopiraj IBAN">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="11" height="11" rx="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <section class="section" id="isprave">
            <div class="section-heading">
                <div class="section-title">
                    <h2>Moje isprave</h2>
                    <p>Prednja i stražnja strana na jednom mjestu.</p>
                </div>
                <button class="text-button" type="button">Prikaži sve</button>
            </div>

            <div class="cards-scroll">
                <article class="document-card">
                    <div class="document-preview">
                        <span class="document-chip">🇭🇷 Republika Hrvatska</span>
                        <div class="document-number">
                            <span>Broj osobne iskaznice</span>
                            <strong>123456789</strong>
                        </div>
                    </div>
                    <div class="document-body">
                        <h3>Osobna iskaznica</h3>
                        <p>Vrijedi do 12. kolovoza 2031.</p>
                        <div class="document-actions">
                            <button class="primary-button" type="button">Otvori</button>
                            <button class="icon-button share-trigger" type="button" data-item="Osobna iskaznica" aria-label="Podijeli osobnu iskaznicu">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="18" cy="5" r="3"/>
                                    <circle cx="6" cy="12" r="3"/>
                                    <circle cx="18" cy="19" r="3"/>
                                    <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <article class="document-card">
                    <div class="document-preview license">
                        <span class="document-chip">Vozačka dozvola</span>
                        <div class="document-number">
                            <span>Broj dozvole</span>
                            <strong>HR-9087342</strong>
                        </div>
                    </div>
                    <div class="document-body">
                        <h3>Vozačka dozvola</h3>
                        <p>Vrijedi do 4. ožujka 2030.</p>
                        <div class="document-actions">
                            <button class="primary-button" type="button">Otvori</button>
                            <button class="icon-button share-trigger" type="button" data-item="Vozačka dozvola" aria-label="Podijeli vozačku dozvolu">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="18" cy="5" r="3"/>
                                    <circle cx="6" cy="12" r="3"/>
                                    <circle cx="18" cy="19" r="3"/>
                                    <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <article class="document-card">
                    <div class="document-preview passport">
                        <span class="document-chip">Europska unija</span>
                        <div class="document-number">
                            <span>Broj putovnice</span>
                            <strong>PA0827341</strong>
                        </div>
                    </div>
                    <div class="document-body">
                        <h3>Putovnica</h3>
                        <p>Vrijedi do 19. svibnja 2029.</p>
                        <div class="document-actions">
                            <button class="primary-button" type="button">Otvori</button>
                            <button class="icon-button share-trigger" type="button" data-item="Putovnica" aria-label="Podijeli putovnicu">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="18" cy="5" r="3"/>
                                    <circle cx="6" cy="12" r="3"/>
                                    <circle cx="18" cy="19" r="3"/>
                                    <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="section" id="dokumenti">
            <div class="section-heading">
                <div class="section-title">
                    <h2>Dokumenti</h2>
                    <p>Nedavno dodane PDF i DOC datoteke.</p>
                </div>
                <button class="text-button" type="button">Prikaži sve</button>
            </div>

            <div class="files-list">
                <article class="file-card">
                    <div class="file-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 3h7l4 4v14H7z"/>
                            <path d="M14 3v5h5"/>
                        </svg>
                    </div>
                    <div class="file-meta">
                        <strong>Polica putnog osiguranja.pdf</strong>
                        <span>PDF · 1,8 MB · dodano prije 2 dana</span>
                        <div class="shared-badge">Podijeljeno s 1 osobom</div>
                    </div>
                    <button class="icon-button share-trigger" type="button" data-item="Polica putnog osiguranja.pdf" aria-label="Podijeli dokument">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                        </svg>
                    </button>
                </article>

                <article class="file-card">
                    <div class="file-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 3h7l4 4v14H7z"/>
                            <path d="M14 3v5h5"/>
                        </svg>
                    </div>
                    <div class="file-meta">
                        <strong>Potvrda o prebivalištu.pdf</strong>
                        <span>PDF · 620 KB · dodano 8. srpnja 2026.</span>
                    </div>
                    <button class="icon-button share-trigger" type="button" data-item="Potvrda o prebivalištu.pdf" aria-label="Podijeli dokument">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                        </svg>
                    </button>
                </article>

                <article class="file-card">
                    <div class="file-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 3h7l4 4v14H7z"/>
                            <path d="M14 3v5h5"/>
                        </svg>
                    </div>
                    <div class="file-meta">
                        <strong>Ugovor o najmu.docx</strong>
                        <span>DOCX · 84 KB · dodano 1. srpnja 2026.</span>
                    </div>
                    <button class="icon-button share-trigger" type="button" data-item="Ugovor o najmu.docx" aria-label="Podijeli dokument">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                        </svg>
                    </button>
                </article>
            </div>
        </section>
    </main>
</div>

<button class="fab" type="button" onclick="showToast('Odaberi želiš li dodati podatak, ispravu ili dokument.')" aria-label="Dodaj novi sadržaj">
    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <path d="M12 5v14M5 12h14"/>
    </svg>
</button>

<nav class="bottom-nav">
    <button class="nav-item active" type="button">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="2"/>
            <rect x="14" y="3" width="7" height="7" rx="2"/>
            <rect x="3" y="14" width="7" height="7" rx="2"/>
            <rect x="14" y="14" width="7" height="7" rx="2"/>
        </svg>
        Početna
    </button>
    <button class="nav-item" type="button" onclick="document.querySelector('#isprave').scrollIntoView({behavior: 'smooth'})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="5" width="18" height="14" rx="3"/>
            <path d="M7 9h4M7 13h7"/>
        </svg>
        Isprave
    </button>
    <button class="nav-item" type="button" onclick="document.querySelector('#dokumenti').scrollIntoView({behavior: 'smooth'})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 3h7l4 4v14H7z"/>
            <path d="M14 3v5h5"/>
        </svg>
        Dokumenti
    </button>
    <button class="nav-item" type="button" id="mobileUserTrigger">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21a8 8 0 0 1 16 0"/>
        </svg>
        Korisnik
    </button>
</nav>

<div class="modal-backdrop" id="shareModal" role="dialog" aria-modal="true" aria-labelledby="shareTitle">
    <div class="modal">
        <h3 id="shareTitle">Podijeli dokument</h3>
        <p id="shareDescription">Upiši email osobe kojoj želiš omogućiti pristup.</p>

        <div class="field">
            <label for="recipientEmail">Email primatelja</label>
            <input id="recipientEmail" type="email" placeholder="ime@primjer.hr">
        </div>

        <div class="field">
            <label for="shareDuration">Trajanje pristupa</label>
            <input id="shareDuration" type="text" value="7 dana">
        </div>

        <div class="modal-actions">
            <button class="secondary-button" id="closeModal" type="button">Odustani</button>
            <button class="primary-button" id="confirmShare" type="button">Podijeli</button>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="userMenuModal" role="dialog" aria-modal="true" aria-labelledby="userMenuTitle">
    <div class="modal user-menu-modal">
        <div class="user-menu-header">
            <div>
                <h3 id="userMenuTitle">{{ $userName }}</h3>
                <p>{{ auth()->user()?->email }}</p>
            </div>
            <button class="icon-button user-menu-close" type="button" id="closeUserMenu" aria-label="Zatvori izbornik">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6 6 18"/>
                    <path d="M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="user-menu-actions">
            <a href="{{ route('profile.edit') }}" class="primary-button user-menu-link">Profil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="secondary-button user-menu-link">Odjava</button>
            </form>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
    const shareModal = document.getElementById('shareModal');
    const shareTitle = document.getElementById('shareTitle');
    const shareDescription = document.getElementById('shareDescription');
    const recipientEmail = document.getElementById('recipientEmail');
    const closeModal = document.getElementById('closeModal');
    const confirmShare = document.getElementById('confirmShare');
    const toast = document.getElementById('toast');
    const mobileUserTrigger = document.getElementById('mobileUserTrigger');
    const userMenuModal = document.getElementById('userMenuModal');
    const closeUserMenu = document.getElementById('closeUserMenu');
    let selectedItem = '';

    document.querySelectorAll('.share-trigger').forEach(button => {
        button.addEventListener('click', () => {
            selectedItem = button.dataset.item;
            shareTitle.textContent = 'Podijeli: ' + selectedItem;
            shareDescription.textContent = 'Primatelj će emailom dobiti sigurnu poveznicu za pregled.';
            recipientEmail.value = '';
            shareModal.classList.add('open');
            setTimeout(() => recipientEmail.focus(), 100);
        });
    });

    document.querySelectorAll('.copy-button').forEach(button => {
        button.addEventListener('click', async () => {
            const value = button.dataset.copy;

            try {
                await navigator.clipboard.writeText(value);
                showToast('Vrijednost je kopirana.');
            } catch {
                showToast('Kopiranje nije dostupno u ovom pregledniku.');
            }
        });
    });

    closeModal.addEventListener('click', () => {
        shareModal.classList.remove('open');
    });

    shareModal.addEventListener('click', event => {
        if (event.target === shareModal) {
            shareModal.classList.remove('open');
        }
    });

    confirmShare.addEventListener('click', () => {
        const email = recipientEmail.value.trim();

        if (!email || !email.includes('@')) {
            showToast('Upiši ispravnu email adresu.');
            recipientEmail.focus();
            return;
        }

        shareModal.classList.remove('open');
        showToast(selectedItem + ' je podijeljen s ' + email + '.');
    });

    mobileUserTrigger.addEventListener('click', () => {
        userMenuModal.classList.add('open');
    });

    closeUserMenu.addEventListener('click', () => {
        userMenuModal.classList.remove('open');
    });

    userMenuModal.addEventListener('click', event => {
        if (event.target === userMenuModal) {
            userMenuModal.classList.remove('open');
        }
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
</body>
</html>
