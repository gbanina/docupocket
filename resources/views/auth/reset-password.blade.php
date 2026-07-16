<x-guest-layout
    heading="Postavi novu lozinku"
    subtitle="Odaberi novu lozinku za svoj DocuPocket račun."
    link-label="Natrag na prijavu"
    :link-label-url="url('/')"
    link-text="Prijavi se"
    :link-url="route('login')"
>
    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="auth-field">
            <x-input-label for="password" :value="__('Lozinka')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="auth-field">
            <x-input-label for="password_confirmation" :value="__('Potvrdi lozinku')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button>
            {{ __('Spremi lozinku') }}
        </x-primary-button>
    </form>
</x-guest-layout>
