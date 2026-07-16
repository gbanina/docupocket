@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Osobni podaci')

@section('body_class', 'podaci-page')

@php
    $dataCategories = config('docupocket.data.categories', []);
@endphp

@push('head')
    <link rel="stylesheet" href="{{ asset('css/podaci.css') }}">
@endpush

@section('content')
    <div class="podaci-page">
        <section class="page-header">
            <div>
                <div class="eyebrow">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>
                    Privatni podaci
                </div>

                <h1>Osobni podaci</h1>
                <p>
                    Spremi važne brojeve i vrijednosti koje često trebaš. Svaku vrijednost možeš brzo kopirati,
                    sakriti ili urediti.
                </p>
            </div>

            <div class="header-actions">
                <button class="primary-button" id="openAddModal" type="button">
                    + Dodaj podatak
                </button>
            </div>
        </section>

        <section class="search-card">
            <div class="search-wrap">
                <svg class="search-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input id="searchInput" type="search" placeholder="Pretraži po nazivu ili vrijednosti...">
            </div>

            <div class="filter-row">
                <button class="filter-chip active" type="button" data-filter="all">Sve</button>
                <button class="filter-chip" type="button" data-filter="identitet">Identitet</button>
                <button class="filter-chip" type="button" data-filter="zdravstvo">Zdravstvo</button>
                <button class="filter-chip" type="button" data-filter="financije">Financije</button>
                <button class="filter-chip" type="button" data-filter="ostalo">Ostalo</button>
            </div>
        </section>

        <section class="summary-grid">
            <article class="summary-card">
                <span>Ukupno podataka</span>
                <strong id="totalCount">8</strong>
            </article>

            <article class="summary-card">
                <span>Identitet</span>
                <strong>3</strong>
            </article>

            <article class="summary-card">
                <span>Zdravstvo</span>
                <strong>2</strong>
            </article>

            <article class="summary-card">
                <span>Financije</span>
                <strong>2</strong>
            </article>
        </section>

        <section>
            <div class="section-heading">
                <div>
                    <h2>Spremljeni podaci</h2>
                    <p>Klikni na ikonu za kopiranje vrijednosti.</p>
                </div>
            </div>

            <div class="data-list" id="dataList">
                <article class="data-card" data-category="identitet" data-search="oib 12345678901">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            OIB
                        </div>
                        <div class="data-value">
                            <strong>12345678901</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button copy-button" type="button" data-copy="12345678901" aria-label="Kopiraj OIB">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <button class="icon-button edit-button" type="button" data-label="OIB" data-value="12345678901" aria-label="Uredi OIB">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="data-card" data-category="identitet" data-search="broj osobne iskaznice 123456789">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            Broj osobne iskaznice
                        </div>
                        <div class="data-value">
                            <strong>123456789</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button copy-button" type="button" data-copy="123456789" aria-label="Kopiraj broj osobne">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <button class="icon-button edit-button" type="button" data-label="Broj osobne iskaznice" data-value="123456789" aria-label="Uredi broj osobne">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="data-card" data-category="identitet" data-search="broj putovnice PA0827341">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            Broj putovnice
                        </div>
                        <div class="data-value">
                            <strong>PA0827341</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button copy-button" type="button" data-copy="PA0827341" aria-label="Kopiraj broj putovnice">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <button class="icon-button edit-button" type="button" data-label="Broj putovnice" data-value="PA0827341" aria-label="Uredi broj putovnice">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="data-card" data-category="zdravstvo" data-search="mbo zdravstvenog osiguranja 908172635">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            MBO zdravstvenog osiguranja
                        </div>
                        <div class="data-value">
                            <strong>908172635</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button copy-button" type="button" data-copy="908172635" aria-label="Kopiraj MBO">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <button class="icon-button edit-button" type="button" data-label="MBO zdravstvenog osiguranja" data-value="908172635" aria-label="Uredi MBO">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="data-card" data-category="zdravstvo" data-search="broj zdravstvene iskaznice HR-2026-817265">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            Broj zdravstvene iskaznice
                        </div>
                        <div class="data-value">
                            <strong>HR-2026-817265</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button copy-button" type="button" data-copy="HR-2026-817265" aria-label="Kopiraj broj zdravstvene">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <button class="icon-button edit-button" type="button" data-label="Broj zdravstvene iskaznice" data-value="HR-2026-817265" aria-label="Uredi broj zdravstvene">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="data-card" data-category="financije" data-search="iban HR1223600001234567890">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            IBAN
                        </div>
                        <div class="data-value">
                            <strong>HR1223600001234567890</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button copy-button" type="button" data-copy="HR1223600001234567890" aria-label="Kopiraj IBAN">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <button class="icon-button edit-button" type="button" data-label="IBAN" data-value="HR1223600001234567890" aria-label="Uredi IBAN">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="data-card" data-category="financije" data-search="broj kartice 4539 8421 7123 9084">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            Broj kartice
                        </div>
                        <div class="data-value">
                            <strong class="masked" data-real-value="4539842171239084">•••• •••• •••• 9084</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button reveal-button" type="button" aria-label="Prikaži broj kartice">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>

                        <button class="icon-button copy-button" type="button" data-copy="4539842171239084" aria-label="Kopiraj broj kartice">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>
                    </div>
                </article>

                <article class="data-card" data-category="ostalo" data-search="registracija vozila VZ 1234 AB">
                    <div>
                        <div class="data-label">
                            <span class="category-dot"></span>
                            Registracija vozila
                        </div>
                        <div class="data-value">
                            <strong>VŽ 1234 AB</strong>
                        </div>
                    </div>

                    <div class="card-actions">
                        <button class="icon-button copy-button" type="button" data-copy="VŽ 1234 AB" aria-label="Kopiraj registraciju">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="9" y="9" width="11" height="11" rx="2"/>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </button>

                        <button class="icon-button edit-button" type="button" data-label="Registracija vozila" data-value="VŽ 1234 AB" aria-label="Uredi registraciju">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </button>
                    </div>
                </article>
            </div>

            <div class="empty-state" id="emptyState">
                Nema podataka koji odgovaraju pretrazi ili odabranom filtru.
            </div>
        </section>
    </div>
@endsection

@section('after_main')
    @include('layouts.partials.sidebar-mobile', ['active' => 'user'])
    @include('layouts.partials.user-menu-modal')

    <div class="modal-backdrop" id="dataModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="modal">
            <h3 id="modalTitle">Dodaj osobni podatak</h3>
            <p>Unesi naziv i vrijednost podatka koji želiš spremiti.</p>

            <div class="field">
                <label for="dataLabel">Naziv podatka</label>
                <input id="dataLabel" type="text" placeholder="Primjer: OIB">
            </div>

            <div class="field">
                <label for="dataValue">Vrijednost</label>
                <input id="dataValue" type="text" placeholder="Unesi vrijednost">
            </div>

            <div class="field">
                <label for="dataCategory">Kategorija</label>
                <select id="dataCategory">
                    <option value="">Odaberi kategoriju</option>
                    @foreach ($dataCategories as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="modal-actions">
                <button class="secondary-button" id="closeModal" type="button">Odustani</button>
                <button class="primary-button" id="saveData" type="button">Spremi</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast"></div>
@endsection

@push('scripts')
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterButtons = document.querySelectorAll('.filter-chip');
        const cards = document.querySelectorAll('.data-card');
        const emptyState = document.getElementById('emptyState');
        const modal = document.getElementById('dataModal');
        const modalTitle = document.getElementById('modalTitle');
        const labelInput = document.getElementById('dataLabel');
        const valueInput = document.getElementById('dataValue');
        const categoryInput = document.getElementById('dataCategory');
        const toast = document.getElementById('toast');
        const totalCount = document.getElementById('totalCount');
        const mobileUserTrigger = document.getElementById('mobileUserTrigger');
        const userMenuModal = document.getElementById('userMenuModal');
        const closeUserMenu = document.getElementById('closeUserMenu');

        let activeFilter = 'all';
        totalCount.textContent = cards.length;

        function filterCards() {
            const search = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            cards.forEach(card => {
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

        searchInput.addEventListener('input', filterCards);

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                activeFilter = button.dataset.filter;
                filterCards();
            });
        });

        document.querySelectorAll('.copy-button').forEach(button => {
            button.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(button.dataset.copy);
                    showToast('Vrijednost je kopirana.');
                } catch {
                    showToast('Kopiranje nije dostupno u ovom pregledniku.');
                }
            });
        });

        document.querySelectorAll('.reveal-button').forEach(button => {
            button.addEventListener('click', () => {
                const value = button.closest('.data-card').querySelector('.masked');
                const isMasked = value.textContent.includes('•');

                value.textContent = isMasked
                    ? value.dataset.realValue.replace(/(.{4})/g, '$1 ').trim()
                    : '•••• •••• •••• ' + value.dataset.realValue.slice(-4);

                showToast(isMasked ? 'Vrijednost je prikazana.' : 'Vrijednost je skrivena.');
            });
        });

        document.getElementById('openAddModal').addEventListener('click', () => {
            modalTitle.textContent = 'Dodaj osobni podatak';
            labelInput.value = '';
            valueInput.value = '';
            categoryInput.value = '';
            modal.classList.add('open');
            setTimeout(() => labelInput.focus(), 100);
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', () => {
                modalTitle.textContent = 'Uredi osobni podatak';
                labelInput.value = button.dataset.label;
                valueInput.value = button.dataset.value;
                categoryInput.value = '';
                modal.classList.add('open');
                setTimeout(() => labelInput.focus(), 100);
            });
        });

        document.getElementById('closeModal').addEventListener('click', () => {
            modal.classList.remove('open');
        });

        modal.addEventListener('click', event => {
            if (event.target === modal) {
                modal.classList.remove('open');
            }
        });

        document.getElementById('saveData').addEventListener('click', () => {
            if (!labelInput.value.trim() || !valueInput.value.trim()) {
                showToast('Unesi naziv i vrijednost podatka.');
                return;
            }

            modal.classList.remove('open');
            showToast('Podatak je spremljen.');
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
