<section class="profile-section">
    <div class="section-title section-title-row">
        <div>
            <h2>Osnovne informacije</h2>
            <p>Uredi ime i email adresu povezanu s računom.</p>
        </div>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <button class="icon-button" type="submit" form="send-verification" aria-label="Pošalji verifikaciju">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 2 11 13"/>
                    <path d="M22 2 15 22l-4-9-9-4Z"/>
                </svg>
            </button>
        @endif
    </div>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        <div class="field-grid two-cols">
            <div class="field">
                <label for="name">Ime</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="security-card">
                <div class="security-icon">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>

                <div>
                    <strong>Email još nije potvrđen</strong>
                    <span>Ponovno pošalji verifikacijski link ako ga trebaš zatražiti.</span>
                </div>
            </div>
        @endif

        <div class="form-actions">
            <button class="primary-button" type="submit">Spremi promjene</button>

            @if (session('status') === 'profile-updated')
                <p class="save-note">Spremljeno.</p>
            @endif

            @if (session('status') === 'verification-link-sent')
                <p class="save-note">Poslan je novi verifikacijski link.</p>
            @endif
        </div>
    </form>
</section>
