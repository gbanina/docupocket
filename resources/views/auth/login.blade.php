<x-guest-layout
    heading="Dobrodošao natrag"
    subtitle="Prijavi se kako bi nastavio tamo gdje si stao."
    link-label="Nemaš račun?"
    link-text="Kreiraj račun"
    :link-url="route('register')"
>
    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="auth-field">
            <div class="auth-field-row">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span>{{ __('Remember me') }}</span>
        </label>

        <x-primary-button>
            {{ __('Log in') }}
        </x-primary-button>
    </form>
</x-guest-layout>
