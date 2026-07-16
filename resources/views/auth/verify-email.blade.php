<x-guest-layout
    heading="Potvrdi email"
    subtitle="Poslali smo ti poveznicu za potvrdu email adrese."
    link-label="Trebaš drugi račun?"
    link-text="Prijavi se"
    :link-url="route('login')"
>
    <div class="auth-note">
        Hvala na registraciji. Potvrdi email adresu prije nastavka. Ako poruka nije stigla, možeš zatražiti novu poveznicu.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-message auth-message-success">
            Nova poveznica za potvrdu poslana je na tvoj email.
        </div>
    @endif

    <div class="auth-form">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Pošalji novu poveznicu') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-secondary-button>
                {{ __('Odjavi se') }}
            </x-secondary-button>
        </form>
    </div>
</x-guest-layout>
