<x-guest-layout
    heading="Verify your email"
    subtitle="We sent a verification link to your inbox."
    link-label="Need a different account?"
    link-text="Log in"
    :link-url="route('login')"
>
    <div class="auth-note">
        Thanks for signing up. Please verify your email address before continuing. If you did not receive the email, you can request a new link below.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-message auth-message-success">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="auth-form">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-secondary-button>
                {{ __('Log Out') }}
            </x-secondary-button>
        </form>
    </div>
</x-guest-layout>
