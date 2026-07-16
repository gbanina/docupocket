@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Isprave')
@section('body_class', 'isprave-page')

@section('content')
    <section class="page-heading">
        <div class="page-heading-copy">
            <span class="eyebrow">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="5" width="18" height="14" rx="3"/>
                    <path d="M7 9h4M7 13h7"/>
                </svg>
                Digitalne kopije
            </span>

            <h1>Isprave</h1>
            <p>Spremi prednju i stražnju stranu osobnih isprava, prati datume valjanosti i sigurno ih podijeli kada je potrebno.</p>
        </div>

        <a class="primary-button" id="addDocumentButton" href="{{ route('isprave.create') }}">+ Dodaj ispravu</a>
    </section>

    <section class="search-card">
        <div class="search-wrap">
            <svg class="search-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>
            <input id="searchInput" type="search" placeholder="Pretraži isprave...">
        </div>

        <div class="filter-row">
            <button class="filter-chip active" type="button" data-filter="all">Sve</button>
            <button class="filter-chip" type="button" data-filter="identitet">Identitet</button>
            <button class="filter-chip" type="button" data-filter="vozilo">Vožnja</button>
            <button class="filter-chip" type="button" data-filter="zdravstvo">Zdravstvo</button>
            <button class="filter-chip" type="button" data-filter="putovanje">Putovanje</button>
        </div>
    </section>

    <section class="summary-grid">
        <article class="summary-card">
            <span>Ukupno isprava</span>
            <strong>5</strong>
        </article>

        <article class="summary-card">
            <span>Važeće</span>
            <strong>4</strong>
        </article>

        <article class="summary-card">
            <span>Uskoro istječu</span>
            <strong>1</strong>
        </article>

        <article class="summary-card">
            <span>Podijeljene</span>
            <strong>2</strong>
        </article>
    </section>

    <section id="isprave">
        <div class="section-heading">
            <div>
                <h2>Moje isprave</h2>
                <p>Prednja i stražnja strana dostupne su iz detaljnog pregleda.</p>
            </div>
        </div>

        <div class="documents-grid" id="dokumenti">
            <article class="document-card" data-category="identitet" data-search="osobna iskaznica hrvatska 123456789">
                <div class="document-preview">
                    <span class="document-chip">🇭🇷 Republika Hrvatska</span>
                    <div class="document-code">
                        <span>Broj isprave</span>
                        <strong>123456789</strong>
                    </div>
                    <div class="side-count">2 slike</div>
                </div>

                <div class="document-body">
                    <div class="document-topline">
                        <h3>Osobna iskaznica</h3>
                        <span class="status-badge valid">Važeća</span>
                    </div>

                    <div class="document-meta">
                        <div class="meta-item">
                            <span>Vrijedi do</span>
                            <strong>12. 8. 2031.</strong>
                        </div>
                        <div class="meta-item">
                            <span>Podijeljeno</span>
                            <strong>1 osoba</strong>
                        </div>
                    </div>

                    <div class="document-actions document-actions-three">
                        <button class="primary-button" type="button">Otvori</button>

                        <button class="icon-button share-trigger" type="button" data-item="Osobna iskaznica" aria-label="Podijeli osobnu iskaznicu">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/>
                                <circle cx="6" cy="12" r="3"/>
                                <circle cx="18" cy="19" r="3"/>
                                <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                            </svg>
                        </button>

                        <button class="icon-button" type="button" onclick="showToast('Otvoreno uređivanje osobne iskaznice.')" aria-label="Uredi osobnu iskaznicu">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </article>

            <article class="document-card" data-category="vozilo" data-search="vozačka dozvola HR-9087342">
                <div class="document-preview license">
                    <span class="document-chip">Vozačka dozvola</span>
                    <div class="document-code">
                        <span>Broj dozvole</span>
                        <strong>HR-9087342</strong>
                    </div>
                    <div class="side-count">2 slike</div>
                </div>

                <div class="document-body">
                    <div class="document-topline">
                        <h3>Vozačka dozvola</h3>
                        <span class="status-badge valid">Važeća</span>
                    </div>

                    <div class="document-meta">
                        <div class="meta-item">
                            <span>Vrijedi do</span>
                            <strong>4. 3. 2030.</strong>
                        </div>
                        <div class="meta-item">
                            <span>Podijeljeno</span>
                            <strong>Nije podijeljeno</strong>
                        </div>
                    </div>

                    <div class="document-actions document-actions-three">
                        <button class="primary-button" type="button">Otvori</button>

                        <button class="icon-button share-trigger" type="button" data-item="Vozačka dozvola" aria-label="Podijeli vozačku dozvolu">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/>
                                <circle cx="6" cy="12" r="3"/>
                                <circle cx="18" cy="19" r="3"/>
                                <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                            </svg>
                        </button>

                        <button class="icon-button" type="button" onclick="showToast('Otvoreno uređivanje vozačke dozvole.')" aria-label="Uredi vozačku dozvolu">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </article>

            <article class="document-card" data-category="putovanje" data-search="putovnica europska unija PA0827341">
                <div class="document-preview passport">
                    <span class="document-chip">Europska unija</span>
                    <div class="document-code">
                        <span>Broj putovnice</span>
                        <strong>PA0827341</strong>
                    </div>
                    <div class="side-count">2 slike</div>
                </div>

                <div class="document-body">
                    <div class="document-topline">
                        <h3>Putovnica</h3>
                        <span class="status-badge warning">Istječe uskoro</span>
                    </div>

                    <div class="document-meta">
                        <div class="meta-item">
                            <span>Vrijedi do</span>
                            <strong>19. 5. 2027.</strong>
                        </div>
                        <div class="meta-item">
                            <span>Podijeljeno</span>
                            <strong>1 osoba</strong>
                        </div>
                    </div>

                    <div class="document-actions document-actions-three">
                        <button class="primary-button" type="button">Otvori</button>

                        <button class="icon-button share-trigger" type="button" data-item="Putovnica" aria-label="Podijeli putovnicu">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/>
                                <circle cx="6" cy="12" r="3"/>
                                <circle cx="18" cy="19" r="3"/>
                                <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                            </svg>
                        </button>

                        <button class="icon-button" type="button" onclick="showToast('Otvoreno uređivanje putovnice.')" aria-label="Uredi putovnicu">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </article>

            <article class="document-card" data-category="zdravstvo" data-search="zdravstvena iskaznica hzzo HR-2026-817265">
                <div class="document-preview health">
                    <span class="document-chip">HZZO</span>
                    <div class="document-code">
                        <span>Broj iskaznice</span>
                        <strong>HR-2026-817265</strong>
                    </div>
                    <div class="side-count">2 slike</div>
                </div>

                <div class="document-body">
                    <div class="document-topline">
                        <h3>Zdravstvena iskaznica</h3>
                        <span class="status-badge valid">Aktivna</span>
                    </div>

                    <div class="document-meta">
                        <div class="meta-item">
                            <span>MBO</span>
                            <strong>908172635</strong>
                        </div>
                        <div class="meta-item">
                            <span>Podijeljeno</span>
                            <strong>Nije podijeljeno</strong>
                        </div>
                    </div>

                    <div class="document-actions document-actions-three">
                        <button class="primary-button" type="button">Otvori</button>

                        <button class="icon-button share-trigger" type="button" data-item="Zdravstvena iskaznica" aria-label="Podijeli zdravstvenu iskaznicu">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/>
                                <circle cx="6" cy="12" r="3"/>
                                <circle cx="18" cy="19" r="3"/>
                                <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                            </svg>
                        </button>

                        <button class="icon-button" type="button" onclick="showToast('Otvoreno uređivanje zdravstvene iskaznice.')" aria-label="Uredi zdravstvenu iskaznicu">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </article>

            <article class="document-card" data-category="putovanje" data-search="europska kartica zdravstvenog osiguranja ekzo">
                <div class="document-preview eu">
                    <span class="document-chip">European Health Insurance Card</span>
                    <div class="document-code">
                        <span>Broj kartice</span>
                        <strong>EHIC-9081726</strong>
                    </div>
                    <div class="side-count">2 slike</div>
                </div>

                <div class="document-body">
                    <div class="document-topline">
                        <h3>Europska zdravstvena kartica</h3>
                        <span class="status-badge valid">Važeća</span>
                    </div>

                    <div class="document-meta">
                        <div class="meta-item">
                            <span>Vrijedi do</span>
                            <strong>30. 6. 2029.</strong>
                        </div>
                        <div class="meta-item">
                            <span>Podijeljeno</span>
                            <strong>Nije podijeljeno</strong>
                        </div>
                    </div>

                    <div class="document-actions document-actions-three">
                        <button class="primary-button" type="button">Otvori</button>

                        <button class="icon-button share-trigger" type="button" data-item="Europska zdravstvena kartica" aria-label="Podijeli europsku zdravstvenu karticu">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/>
                                <circle cx="6" cy="12" r="3"/>
                                <circle cx="18" cy="19" r="3"/>
                                <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                            </svg>
                        </button>

                        <button class="icon-button" type="button" onclick="showToast('Otvoreno uređivanje europske zdravstvene kartice.')" aria-label="Uredi europsku zdravstvenu karticu">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </article>
        </div>

        <div class="empty-state" id="emptyState">
            Nema isprava koje odgovaraju pretrazi ili odabranom filtru.
        </div>
    </section>
@endsection

@section('after_main')
    <button class="fab" id="mobileAddButton" type="button" aria-label="Dodaj ispravu">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <path d="M12 5v14M5 12h14"/>
        </svg>
    </button>

    @include('layouts.partials.sidebar-mobile', ['active' => 'isprave'])
    @include('layouts.partials.user-menu-modal')
    @include('layouts.partials.share-modal')

    <div class="toast" id="toast"></div>
@endsection

@push('scripts')
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterButtons = document.querySelectorAll('.filter-chip');
        const documentCards = document.querySelectorAll('.document-card');
        const emptyState = document.getElementById('emptyState');
        const shareModal = document.getElementById('shareModal');
        const shareTitle = document.getElementById('shareTitle');
        const recipientEmail = document.getElementById('recipientEmail');
        const toast = document.getElementById('toast');
        const mobileUserTrigger = document.getElementById('mobileUserTrigger');
        const userMenuModal = document.getElementById('userMenuModal');
        const closeUserMenu = document.getElementById('closeUserMenu');

        let activeFilter = 'all';
        let selectedItem = '';

        function filterDocuments() {
            const search = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            documentCards.forEach(card => {
                const matchesSearch = card.dataset.search.toLowerCase().includes(search);
                const matchesFilter = activeFilter === 'all' || card.dataset.category === activeFilter;
                const visible = matchesSearch && matchesFilter;

                card.classList.toggle('hidden', !visible);

                if (visible) {
                    visibleCount++;
                }
            });

            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', filterDocuments);

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                activeFilter = button.dataset.filter;
                filterDocuments();
            });
        });

        document.querySelectorAll('.share-trigger').forEach(button => {
            button.addEventListener('click', () => {
                selectedItem = button.dataset.item;
                shareTitle.textContent = 'Podijeli: ' + selectedItem;
                recipientEmail.value = '';
                shareModal.classList.add('open');
                setTimeout(() => recipientEmail.focus(), 100);
            });
        });

        document.getElementById('closeModal').addEventListener('click', () => {
            shareModal.classList.remove('open');
        });

        shareModal.addEventListener('click', event => {
            if (event.target === shareModal) {
                shareModal.classList.remove('open');
            }
        });

        document.getElementById('confirmShare').addEventListener('click', () => {
            const email = recipientEmail.value.trim();

            if (!email || !email.includes('@')) {
                showToast('Upiši ispravnu email adresu.');
                recipientEmail.focus();
                return;
            }

            shareModal.classList.remove('open');
            showToast(selectedItem + ' je podijeljena s ' + email + '.');
        });

        document.getElementById('addDocumentButton').addEventListener('click', () => {
            showToast('Otvorena stranica za dodavanje nove isprave.');
        });

        document.getElementById('mobileAddButton').addEventListener('click', () => {
            showToast('Otvorena stranica za dodavanje nove isprave.');
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
@endpush
