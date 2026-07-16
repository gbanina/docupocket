@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Dokumenti')
@section('body_class', 'dokumenti-page')

@php
    $documentUserName = auth()->user()?->name ?? 'User';
    $documentUserInitials = collect(preg_split('/\s+/', trim($documentUserName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');
@endphp

@section('content')
    <section class="page-header">
        <div>
            <div class="eyebrow">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M7 3h7l4 4v14H7z"/>
                    <path d="M14 3v5h5"/>
                </svg>
                Privatne datoteke
            </div>

            <h1>Dokumenti</h1>
            <p>Pregledaj, pretraži i organiziraj sve spremljene PDF, DOCX, slike i ostale datoteke.</p>
        </div>

        <button class="primary-button" id="uploadButton" type="button">+ Dodaj dokument</button>
    </section>

    <section class="toolbar">
        <div class="search-wrap">
            <svg class="search-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>
            <input id="searchInput" type="search" placeholder="Pretraži po nazivu, kategoriji ili opisu...">
        </div>

        <div class="toolbar-row">
            <button class="filter-chip active" type="button" data-filter="all">Sve</button>
            <button class="filter-chip" type="button" data-filter="pdf">PDF</button>
            <button class="filter-chip" type="button" data-filter="docx">DOCX</button>
            <button class="filter-chip" type="button" data-filter="image">Slike</button>
            <button class="filter-chip" type="button" data-filter="other">Ostalo</button>

            <select class="sort-select" id="sortSelect" aria-label="Sortiranje">
                <option value="newest">Najnovije</option>
                <option value="oldest">Najstarije</option>
                <option value="name">Naziv A–Ž</option>
                <option value="size">Najveće</option>
            </select>
        </div>
    </section>

    <section id="dokumenti">
        <div class="section-heading">
            <div>
                <h2>Svi dokumenti</h2>
                <p id="resultCount">Prikazano 6 dokumenata.</p>
            </div>

            <div class="view-toggle">
                <button class="active" id="listViewButton" type="button" aria-label="Prikaz liste">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 6h13M8 12h13M8 18h13"/>
                        <circle cx="3" cy="6" r="1"/>
                        <circle cx="3" cy="12" r="1"/>
                        <circle cx="3" cy="18" r="1"/>
                    </svg>
                </button>

                <button id="gridViewButton" type="button" aria-label="Prikaz kartica">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="documents-grid" id="documentsGrid">
            @forelse ($documents as $document)
                <article class="document-card"
                    data-category="{{ $document->type_key }}"
                    data-search="{{ strtolower($document->search) }}"
                    data-name="{{ $document->name }}"
                    data-size="{{ $document->file_size }}"
                    data-date="{{ $document->created_at->format('Ymd') }}">
                    <div class="file-icon {{ $document->type_key }}">
                        <svg width="23" height="23" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 3h7l4 4v14H7z"/>
                            <path d="M14 3v5h5"/>
                            @if ($document->type_key === 'docx')
                                <path d="M9 13h6M9 17h4"/>
                            @elseif ($document->type_key === 'image')
                                <rect x="3" y="5" width="18" height="14" rx="3"/>
                                <circle cx="8.5" cy="10" r="1.5"/>
                                <path d="m6 16 4-4 3 3 2-2 3 3"/>
                            @elseif ($document->type_key === 'other')
                                <path d="M10 8h2M10 11h2M10 14h2M10 17h2"/>
                            @endif
                        </svg>
                    </div>

                    <div class="file-main">
                        <div class="title-row">
                            <strong>{{ $document->original_name }}</strong>
                        </div>
                        <div class="meta">
                            <span>{{ $document->type_label }}</span>
                            <span>{{ $document->file_size_label }}</span>
                            <span>{{ $document->date_label }}</span>
                        </div>
                    </div>

                    <div class="card-actions">
                        <a class="icon-button" href="{{ route('dokumenti.preview', ['document' => $document->id]) }}" target="_blank" rel="noopener" aria-label="Pregled">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </a>
                        <button class="icon-button share-trigger" type="button" data-item="{{ $document->original_name }}" aria-label="Podijeli">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/>
                                <circle cx="6" cy="12" r="3"/>
                                <circle cx="18" cy="19" r="3"/>
                                <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                            </svg>
                        </button>
                        <a class="icon-button" href="{{ route('dokumenti.documents.edit', ['document' => $document->id]) }}" aria-label="Uredi">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @empty
            @endforelse
        </div>

        <div class="empty-state" id="emptyState">
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7 3h7l4 4v14H7z"/>
                <path d="M14 3v5h5"/>
            </svg>
            <strong>Nema pronađenih dokumenata</strong>
            Promijeni pretragu ili odabrani filtar.
        </div>
    </section>
@endsection

@section('after_main')
    <button class="fab" id="mobileUploadButton" type="button" aria-label="Dodaj dokument">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <path d="M12 5v14M5 12h14"/>
        </svg>
    </button>

    @include('layouts.partials.sidebar-mobile', ['active' => 'dokumenti'])
    @include('layouts.partials.user-menu-modal')
    @include('layouts.partials.share-modal')

    <div class="toast" id="toast" data-status="{{ session('status') }}"></div>
@endsection

@push('scripts')
    <script>
        const searchInput = document.getElementById('searchInput');
        const filterButtons = document.querySelectorAll('.filter-chip');
        const sortSelect = document.getElementById('sortSelect');
        const grid = document.getElementById('documentsGrid');
        const cards = Array.from(document.querySelectorAll('.document-card'));
        const emptyState = document.getElementById('emptyState');
        const resultCount = document.getElementById('resultCount');
        const shareModal = document.getElementById('shareModal');
        const shareTitle = document.getElementById('shareTitle');
        const recipientEmail = document.getElementById('recipientEmail');
        const toast = document.getElementById('toast');

        let activeFilter = 'all';
        let selectedItem = '';

        function refreshList() {
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

            resultCount.textContent = 'Prikazano ' + visibleCount + ' dokumenata.';
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        function sortCards() {
            const mode = sortSelect.value;
            const sorted = [...cards].sort((a, b) => {
                if (mode === 'name') {
                    return a.dataset.name.localeCompare(b.dataset.name, 'hr');
                }

                if (mode === 'size') {
                    return Number(b.dataset.size) - Number(a.dataset.size);
                }

                if (mode === 'oldest') {
                    return Number(a.dataset.date) - Number(b.dataset.date);
                }

                return Number(b.dataset.date) - Number(a.dataset.date);
            });

            sorted.forEach(card => grid.appendChild(card));
        }

        searchInput.addEventListener('input', refreshList);

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(item => item.classList.remove('active'));
                button.classList.add('active');
                activeFilter = button.dataset.filter;
                refreshList();
            });
        });

        sortSelect.addEventListener('change', sortCards);

        document.getElementById('listViewButton').addEventListener('click', () => {
            grid.classList.remove('grid-view');
            document.getElementById('listViewButton').classList.add('active');
            document.getElementById('gridViewButton').classList.remove('active');
        });

        document.getElementById('gridViewButton').addEventListener('click', () => {
            grid.classList.add('grid-view');
            document.getElementById('gridViewButton').classList.add('active');
            document.getElementById('listViewButton').classList.remove('active');
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
                return;
            }

            shareModal.classList.remove('open');
            showToast(selectedItem + ' je podijeljen s ' + email + '.');
        });

        document.getElementById('uploadButton').addEventListener('click', () => {
            window.location.href = @json(route('dokumenti.create'));
        });

        document.getElementById('mobileUploadButton').addEventListener('click', () => {
            window.location.href = @json(route('dokumenti.create'));
        });

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');

            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 2600);
        }

        sortCards();
        refreshList();

        if (toast.dataset.status) {
            showToast(toast.dataset.status);
        }
    </script>
@endpush
