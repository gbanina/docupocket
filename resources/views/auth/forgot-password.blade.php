<x-guest-layout
    heading="Reset your password"
    subtitle="We will send you a reset link so you can choose a new password."
    link-label="Back to login"
    link-text="Log in"
    :link-url="route('login')"
>
    <div class="auth-note">
        Enter the email address linked to your account and we will send a secure password reset link.
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
            {{ __('Email Password Reset Link') }}
        </x-primary-button>
    </form>
</x-guest-layout>
