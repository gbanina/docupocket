<section class="profile-section">
    <div class="section-title">
        <h2>Lozinka</h2>
        <p>Postavi novu lozinku i zadrži račun sigurnim.</p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="profile-form">
        @csrf
        @method('put')

        <div class="field-grid">
            <div class="field">
                <label for="update_password_current_password">Trenutna lozinka</label>
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label for="update_password_password">Nova lozinka</label>
                <input id="update_password_password" name="password" type="password" autocomplete="new-password">
                @error('password', 'updatePassword')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label for="update_password_password_confirmation">Potvrdi lozinku</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button class="primary-button" type="submit">Spremi promjene</button>

            @if (session('status') === 'password-updated')
                <p class="save-note">Spremljeno.</p>
            @endif
        </div>
    </form>
</section>
