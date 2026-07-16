@extends('layouts.main')

@section('title', config('app.name', 'DocuPocket') . ' — ' . $isprava->name)
@section('body_class', 'isprave-create-page isprave-show-page')

@section('content')
    <section class="page-heading">
        <div class="page-heading-copy">
            <span class="eyebrow">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h16M4 17h10"/>
                </svg>
                Detalji isprave
            </span>

            <h1>{{ $isprava->name }}</h1>
            <p>{{ $details['summary']->category_label }} · {{ $details['summary']->status_label }}</p>
        </div>

        <div class="page-heading-actions">
            <a class="secondary-button" href="{{ route('isprave') }}">Natrag</a>
            <a class="primary-button" href="{{ route('isprave.edit', $isprava) }}">Uredi ispravu</a>
        </div>
    </section>

    <div class="form-card">
        <section class="form-section">
            <div class="section-title">
                <h2>Osnovne informacije</h2>
                <p>Vrijednosti spremljene u bazi.</p>
            </div>

            <div class="detail-grid">
                <div class="detail-row">
                    <span>Naziv</span>
                    <strong>{{ $isprava->name }}</strong>
                </div>
                <div class="detail-row">
                    <span>Kategorija</span>
                    <strong>{{ $details['summary']->category_label }}</strong>
                </div>
                <div class="detail-row">
                    <span>Broj isprave</span>
                    <strong>{{ $details['summary']->document_number }}</strong>
                </div>
                <div class="detail-row">
                    <span>Izdavatelj</span>
                    <strong>{{ $details['summary']->issuer }}</strong>
                </div>
                <div class="detail-row">
                    <span>Datum izdavanja</span>
                    <strong>{{ $details['summary']->issued_at_label }}</strong>
                </div>
                <div class="detail-row">
                    <span>Vrijedi do</span>
                    <strong>{{ $details['summary']->expires_label }}</strong>
                </div>
                <div class="detail-row">
                    <span>Podsjetnik</span>
                    <strong>{{ $details['reminder_label'] }}</strong>
                </div>
                <div class="detail-row">
                    <span>Napomena</span>
                    <strong>{{ $details['summary']->note }}</strong>
                </div>
                <div class="detail-row">
                    <span>Status</span>
                    <strong>{{ $details['summary']->status_label }}</strong>
                </div>
            </div>
        </section>

        <section class="form-section">
            <div class="section-title">
                <h2>Fotografije isprave</h2>
                <p>Prikaz spremljenih datoteka iz baze.</p>
            </div>

            <div class="image-grid">
                <article class="image-card">
                    <div class="image-card-header">
                        <strong>Prednja strana</strong>
                        <span>{{ $isprava->front_image_path ? basename($isprava->front_image_path) : 'Nema spremljene slike' }}</span>
                    </div>
                    <div class="image-frame">
                        @if ($isprava->front_image_path)
                            <img src="{{ asset('storage/' . $isprava->front_image_path) }}" alt="Prednja strana isprave {{ $isprava->name }}">
                        @else
                            <span class="empty-image">Prednja slika nije dodana.</span>
                        @endif
                    </div>
                </article>

                <article class="image-card">
                    <div class="image-card-header">
                        <strong>Stražnja strana</strong>
                        <span>{{ $isprava->back_image_path ? basename($isprava->back_image_path) : 'Nema spremljene slike' }}</span>
                    </div>
                    <div class="image-frame">
                        @if ($isprava->back_image_path)
                            <img src="{{ asset('storage/' . $isprava->back_image_path) }}" alt="Stražnja strana isprave {{ $isprava->name }}">
                        @else
                            <span class="empty-image">Stražnja slika nije dodana.</span>
                        @endif
                    </div>
                </article>
            </div>
        </section>
    </div>

    <div class="toast" id="toast" data-status="{{ session('status') }}"></div>
@endsection

@section('after_main')
    @include('layouts.partials.sidebar-mobile', ['active' => 'isprave'])
    @include('layouts.partials.user-menu-modal')
@endsection

@push('scripts')
    <script>
        const toast = document.getElementById('toast');
        const mobileUserTrigger = document.getElementById('mobileUserTrigger');
        const userMenuModal = document.getElementById('userMenuModal');
        const closeUserMenu = document.getElementById('closeUserMenu');

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

        if (toast?.dataset?.status) {
            showToast(toast.dataset.status);
        }

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
