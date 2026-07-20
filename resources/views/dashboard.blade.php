@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — Osobni dokumenti')
@section('body_class', 'dashboard-page')

@section('content')
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

    <section class="summary-grid">
        <article class="summary-card">
            <span>Podaci</span>
            <strong>{{ $summary['podaci'] ?? 0 }}</strong>
            <small>Spremljene vrijednosti</small>
        </article>

        <article class="summary-card">
            <span>Isprave</span>
            <strong>{{ $summary['isprave'] ?? 0 }}</strong>
            <small>Dokumenti s fotografijama</small>
        </article>

        <article class="summary-card">
            <span>Dokumenti</span>
            <strong>{{ $summary['dokumenti'] ?? 0 }}</strong>
            <small>Datoteke u trezoru</small>
        </article>

        <article class="summary-card">
            <span>Uskoro istječe</span>
            <strong>{{ $summary['uskoro_istek'] ?? 0 }}</strong>
            <small>Isprave za nadzor</small>
        </article>
    </section>

    <section class="section" id="podaci">
        <div class="section-heading">
            <div class="section-title">
                <h2>Osnovni podaci</h2>
                <p>Kopiraj vrijednost jednim dodirom.</p>
            </div>
            <a class="text-button" href="{{ route('podaci') }}">Uredi</a>
        </div>

        <div class="data-list data-card">
            @forelse ($podaci as $podatak)
                <div class="data-row">
                    <div class="data-meta">
                        <span>{{ $podatak->label }}</span>
                        <strong>{{ $podatak->value }}</strong>
                    </div>
                    <button class="copy-button" type="button" data-copy="{{ $podatak->value }}" aria-label="Kopiraj {{ $podatak->label }}">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="11" height="11" rx="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </button>
                </div>
            @empty
                <div class="empty-state" style="display: block;">
                    Nema spremljenih osnovnih podataka.
                </div>
            @endforelse
        </div>
    </section>

    <section class="section" id="isprave">
        <div class="section-heading">
            <div class="section-title">
                <h2>Moje isprave</h2>
                <p>Prednja i stražnja strana na jednom mjestu.</p>
            </div>
            <a class="text-button" href="{{ route('isprave') }}">Prikaži sve</a>
        </div>

        <div class="cards-scroll">
            @forelse ($isprave as $isprava)
                <article class="document-card">
                    <div class="document-preview {{ $isprava->preview_class }}">
                        <span class="document-chip">{{ $isprava->preview_chip }}</span>
                        <div class="document-number">
                            <span>{{ $isprava->code_label }}</span>
                            <strong>{{ $isprava->document_number }}</strong>
                        </div>
                    </div>
                    <div class="document-body">
                    <div class="document-topline">
                        <h3>{{ $isprava->name }}</h3>
                        <span class="status-badge {{ $isprava->status_class }}">{{ $isprava->status_label }}</span>
                    </div>
                        <p>Kategorija {{ $isprava->category_label }} · vrijedi do {{ $isprava->expires_label }}</p>
                        <div class="document-actions">
                            <a class="primary-button" href="{{ route('isprave.show', $isprava->id) }}">Otvori</a>
                            <button class="icon-button share-trigger" type="button" data-item="{{ $isprava->name }}" aria-label="Podijeli {{ $isprava->name }}">
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
            @empty
                <div class="empty-state" style="display: block;">
                    Nema spremljenih isprava.
                </div>
            @endforelse
        </div>
    </section>

    <section class="section" id="dokumenti">
        <div class="section-heading">
            <div class="section-title">
                <h2>Dokumenti</h2>
                <p>Nedavno dodane datoteke iz baze.</p>
            </div>
            <a class="text-button" href="{{ route('dokumenti') }}">Prikaži sve</a>
        </div>

        <div class="files-list">
            @forelse ($dokumenti as $document)
                <article class="file-card">
                    <div class="file-icon {{ $document->type_key }}">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    <div class="file-meta">
                        <strong>{{ $document->original_name }}</strong>
                        <span>{{ $document->type_label }} · {{ $document->file_size_label }} · dodano {{ $document->date_label }}</span>
                    </div>
                    <button class="icon-button share-trigger" type="button" data-item="{{ $document->share_label }}" aria-label="Podijeli dokument">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"/>
                            <circle cx="6" cy="12" r="3"/>
                            <circle cx="18" cy="19" r="3"/>
                            <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                        </svg>
                    </button>
                </article>
            @empty
                <div class="empty-state" style="display: block;">
                    Nema spremljenih dokumenata.
                </div>
            @endforelse
        </div>
    </section>
@endsection

@section('after_main')
    <button class="fab" type="button" onclick="showToast('Odaberi želiš li dodati podatak, ispravu ili dokument.')" aria-label="Dodaj novi sadržaj">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
            <path d="M12 5v14M5 12h14"/>
        </svg>
    </button>

    @include('layouts.partials.sidebar-mobile', ['active' => 'home'])
    @include('layouts.partials.user-menu-modal')
    @include('layouts.partials.share-modal')

    <div class="toast" id="toast" data-status="{{ session('status') }}"></div>
@endsection

@push('scripts')
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
@endpush
