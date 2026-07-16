<x-guest-layout
    heading="Zaboravljena lozinka"
    subtitle="Poslat ćemo ti poveznicu za postavljanje nove lozinke."
    link-label="Natrag na prijavu"
    :link-label-url="url('/')"
    link-text="Prijavi se"
    :link-url="route('login')"
>
    <div class="auth-note">
        Upiši email adresu povezanu s računom i poslat ćemo ti sigurnu poveznicu za reset.
    </div>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <x-primary-button>
            {{ __('Pošalji poveznicu') }}
        </x-primary-button>
    </form>
</x-guest-layout>
