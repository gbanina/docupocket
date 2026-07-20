<x-guest-layout
    heading="Prijava"
    subtitle="Prijavi se samo s potvrđenom email adresom."
    link-label="Nemaš račun?"
    link-text="Kreiraj račun"
    :link-url="route('register')"
>
    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="auth-field">
            <div class="auth-field-row">
                <x-input-label for="password" :value="__('Lozinka')" />
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        {{ __('Zaboravljena lozinka?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span>{{ __('Zapamti me') }}</span>
        </label>

        <x-primary-button>
            {{ __('Prijavi se') }}
        </x-primary-button>
    </form>
</x-guest-layout>
