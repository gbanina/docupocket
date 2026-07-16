<x-guest-layout
    heading="Confirm your password"
    subtitle="This protected area needs a quick password confirmation."
    link-label="Need to switch accounts?"
    link-text="Back to login"
    :link-url="route('login')"
>
    <div class="auth-note">
        Please confirm your password before continuing to the secure area of the application.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-primary-button>
            {{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
