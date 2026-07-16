<section class="profile-section">
    <div class="section-title">
        <h2>Brisanje računa</h2>
        <p>Brisanjem će se trajno ukloniti račun i svi povezani podaci.</p>
    </div>

    <div class="danger-zone">
        <h3>Trajno brisanje</h3>
        <p>Prije brisanja preuzmi sve podatke koje želiš zadržati. Nakon potvrde nema povratka.</p>

        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >
            Izbriši račun
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="profile-delete-modal">
            @csrf
            @method('delete')

            <h2>Jesi li siguran?</h2>
            <p>Unesi svoju lozinku kako bi potvrdio trajno brisanje računa.</p>

            <div class="field">
                <label for="password">Lozinka</label>
                <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Lozinka">
                @error('password', 'userDeletion')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="modal-actions">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Odustani
                </x-secondary-button>

                <x-danger-button>
                    Izbriši račun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
