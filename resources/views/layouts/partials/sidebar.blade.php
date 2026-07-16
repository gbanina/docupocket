@php
    $currentUser = auth()->user();
    $userName = $currentUser?->name ?? 'User';
    $userEmail = $currentUser?->email ?? '';
    $isDashboard = request()->routeIs('dashboard');
    $isIsprave = request()->routeIs('isprave');
    $isPodaci = request()->routeIs('podaci');
    $isProfile = request()->routeIs('profile.*');
@endphp

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
        <a class="sidebar-link {{ $isDashboard ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="2"/>
                <rect x="14" y="3" width="7" height="7" rx="2"/>
                <rect x="3" y="14" width="7" height="7" rx="2"/>
                <rect x="14" y="14" width="7" height="7" rx="2"/>
            </svg>
            Dashboard
        </a>

        <a class="sidebar-link {{ $isPodaci ? 'active' : '' }}" href="{{ route('podaci') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21a8 8 0 0 1 16 0"/>
            </svg>
            Podaci
        </a>

        <a class="sidebar-link {{ $isIsprave ? 'active' : '' }}" href="{{ route('isprave') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="5" width="18" height="14" rx="3"/>
                <path d="M7 9h4M7 13h7M16 10h1"/>
            </svg>
            Isprave
        </a>

        <a class="sidebar-link" href="{{ route('isprave') }}#dokumenti">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7 3h7l4 4v14H7z"/>
                <path d="M14 3v5h5"/>
            </svg>
            Dokumenti
        </a>

        <div class="sidebar-user-menu">
            <a class="sidebar-link sidebar-user-trigger {{ $isProfile ? 'active' : '' }}" href="{{ route('profile.edit') }}">
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
                    <span>{{ $userEmail }}</span>
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
