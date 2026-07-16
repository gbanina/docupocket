<div class="modal-backdrop" id="userMenuModal" role="dialog" aria-modal="true" aria-labelledby="userMenuTitle">
    <div class="modal user-menu-modal">
        <div class="user-menu-header">
            <div>
                <h3 id="userMenuTitle">{{ auth()->user()?->name ?? 'User' }}</h3>
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
