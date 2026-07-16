<section class="auth-panel">
    <div class="auth-card">
        <div class="auth-card-top">
            <div class="auth-card-title">
                @isset($heading)
                    <div class="auth-kicker">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        {{ $heading }}
                    </div>
                @endisset

                @isset($subtitle)
                    <h2>{{ $subtitle }}</h2>
                @endisset
            </div>
        </div>

        <div class="auth-badge-row" aria-hidden="true">
            <span class="mini-pill">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                Privatna sesija
            </span>
            <span class="mini-pill">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4"/>
                </svg>
                Brz pristup
            </span>
        </div>

        @if ($status = session('status'))
            <div class="mini-pill" style="margin: 14px 0 0;">
                {{ $status }}
            </div>
        @endif

        @if ($errors->any())
            <div class="auth-error-list" style="margin-top: 16px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="auth-slot">
            {{ $slot }}
        </div>

        @if (isset($linkText) && isset($linkUrl))
            <div class="auth-actions-row">
                @if (isset($linkLabel) && $linkLabel)
                    @if (isset($linkLabelUrl) && $linkLabelUrl)
                        <a class="auth-note auth-back" href="{{ $linkLabelUrl }}">{{ $linkLabel }}</a>
                    @else
                        <span class="auth-note">{{ $linkLabel }}</span>
                    @endif
                @endif
                <a class="auth-link" href="{{ $linkUrl }}">{{ $linkText }}</a>
            </div>
        @endif
    </div>
</section>
