<x-guest-layout
    heading="Potvrda lozinke"
    subtitle="Zaštićeni dio aplikacije traži kratku potvrdu lozinke."
    link-label="Želiš drugi račun?"
    link-text="Prijavi se"
    :link-url="route('login')"
>
    <div class="auth-note">
        Potvrdi lozinku prije nastavka u zaštićeni dio aplikacije.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <x-input-label for="password" :value="__('Lozinka')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-primary-button>
            {{ __('Potvrdi') }}
        </x-primary-button>
    </form>
</x-guest-layout>
