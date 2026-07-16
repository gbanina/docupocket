@php
    $active = $active ?? 'home';
@endphp

<nav class="bottom-nav">
    <button class="nav-item {{ $active === 'home' ? 'active' : '' }}" type="button">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7" rx="2"/>
            <rect x="14" y="3" width="7" height="7" rx="2"/>
            <rect x="3" y="14" width="7" height="7" rx="2"/>
            <rect x="14" y="14" width="7" height="7" rx="2"/>
        </svg>
        Početna
    </button>
    <button class="nav-item {{ $active === 'isprave' ? 'active' : '' }}" type="button" onclick="document.querySelector('#isprave').scrollIntoView({behavior: 'smooth'})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="5" width="18" height="14" rx="3"/>
            <path d="M7 9h4M7 13h7"/>
        </svg>
        Isprave
    </button>
    <button class="nav-item {{ $active === 'dokumenti' ? 'active' : '' }}" type="button" onclick="document.querySelector('#dokumenti').scrollIntoView({behavior: 'smooth'})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M7 3h7l4 4v14H7z"/>
            <path d="M14 3v5h5"/>
        </svg>
        Dokumenti
    </button>
    <button class="nav-item {{ $active === 'user' ? 'active' : '' }}" type="button" id="mobileUserTrigger">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="8" r="4"/>
            <path d="M4 21a8 8 0 0 1 16 0"/>
        </svg>
        Korisnik
    </button>
</nav>
