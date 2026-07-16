<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7fb">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('img/site.webmanifest') }}">
    <title>{{ config('app.name', 'DocuPocket') }} — Prijava</title>

    <style>
        :root {
            --bg: #f5f7fb;
            --surface: #ffffff;
            --surface-soft: #eef2f8;
            --text: #172033;
            --muted: #6f7b91;
            --line: #e3e8f1;
            --primary: #625df5;
            --primary-dark: #4d48d8;
            --primary-soft: #efeeff;
            --success: #1fa971;
            --shadow: 0 22px 60px rgba(31, 43, 71, 0.12);
            --radius-xl: 30px;
            --radius-lg: 20px;
            --radius-md: 14px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-width: 320px;
            background: var(--bg);
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            font-family: Inter, ui-sans-serif, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            overflow-x: hidden;
            background:
                radial-gradient(circle at 10% 5%, rgba(98, 93, 245, 0.12), transparent 24rem),
                radial-gradient(circle at 95% 90%, rgba(114, 191, 255, 0.14), transparent 26rem),
                var(--bg);
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            z-index: -1;
            border-radius: 999px;
            filter: blur(20px);
            pointer-events: none;
        }

        body::before {
            top: 8vh;
            right: -8rem;
            width: 22rem;
            height: 22rem;
            background: rgba(98, 93, 245, 0.1);
        }

        body::after {
            bottom: -7rem;
            left: -4rem;
            width: 18rem;
            height: 18rem;
            background: rgba(31, 169, 113, 0.08);
        }

        button,
        input {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        .page {
            min-height: 100vh;
            display: grid;
            align-items: center;
            padding: 22px 16px 28px;
        }

        .shell {
            width: min(100%, 1120px);
            margin: auto;
            position: relative;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 26px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .brand-copy {
            display: grid;
            gap: 2px;
        }

        .brand-copy small {
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0;
        }

        .logo {
            display: grid;
            place-items: center;
            width: 44px;
            height: 44px;
            border-radius: 14px;
            color: white;
            background: linear-gradient(145deg, var(--primary), #8b87ff);
            box-shadow: 0 12px 26px rgba(98, 93, 245, 0.28);
        }

        .logo svg {
            width: 23px;
            height: 23px;
        }

        .content {
            display: grid;
            gap: 28px;
        }

        .intro {
            display: grid;
            align-content: start;
            gap: 18px;
            max-width: 640px;
        }

        h1 {
            margin: 0;
            max-width: 720px;
            font-size: clamp(38px, 10vw, 66px);
            line-height: 0.98;
            letter-spacing: -0.06em;
        }

        .lead {
            margin: 0;
            max-width: 570px;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.7;
        }

        .hero-chips {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .hero-chip {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 13px 14px;
            border: 1px solid rgba(228, 233, 241, 0.9);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.74);
            box-shadow: 0 14px 30px rgba(31, 43, 71, 0.06);
            backdrop-filter: blur(14px);
        }

        .hero-chip-icon {
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 11px;
            color: var(--primary);
            background: var(--primary-soft);
        }

        .hero-chip strong {
            display: block;
            margin-bottom: 3px;
            font-size: 14px;
        }

        .hero-chip span {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .login-card {
            width: 100%;
            padding: 28px;
            border: 1px solid rgba(227, 232, 241, 0.92);
            border-radius: 32px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.94), rgba(255,255,255,0.86)),
                rgba(255, 255, 255, 0.9);
            box-shadow: 0 24px 70px rgba(31, 43, 71, 0.12);
            backdrop-filter: blur(20px);
        }

        .login-card-header {
            display: grid;
            gap: 8px;
            margin-bottom: 22px;
        }

        .login-card h2 {
            margin: 0;
            font-size: 27px;
            letter-spacing: -0.04em;
        }

        .login-card > p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.55;
        }

        .card-metadata {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 2px;
        }

        .mini-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 999px;
            background: var(--surface-soft);
            color: var(--muted);
            font-size: 11px;
            font-weight: 800;
        }

        .mini-pill svg {
            color: var(--primary);
        }

        .field {
            display: grid;
            gap: 8px;
            margin-bottom: 15px;
        }

        .field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        label {
            font-size: 12px;
            font-weight: 800;
        }

        .field a,
        .register a {
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        .field a:hover,
        .register a:hover {
            text-decoration: underline;
        }

        .input-wrap {
            position: relative;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 52px;
            padding: 0 46px 0 15px;
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            outline: none;
            color: var(--text);
            background: #fafbfe;
            transition: 0.18s ease;
        }

        input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .input-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            width: 19px;
            height: 19px;
            color: #929bae;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 10px;
            color: #929bae;
            background: transparent;
            transform: translateY(-50%);
        }

        .password-toggle:hover {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 2px 0 19px;
            color: var(--muted);
            font-size: 12px;
        }

        .remember input {
            width: 17px;
            height: 17px;
            accent-color: var(--primary);
        }

        .submit-button {
            width: 100%;
            min-height: 52px;
            border: 0;
            border-radius: 15px;
            color: white;
            background: linear-gradient(145deg, var(--primary), #7b76ff);
            font-weight: 800;
            box-shadow: 0 16px 26px rgba(98, 93, 245, 0.28);
            transition: 0.18s ease;
        }

        .submit-button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0 18px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--line);
        }

        .biometric-button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            min-height: 50px;
            border: 1px solid var(--line);
            border-radius: 15px;
            color: var(--text);
            background: var(--surface-soft);
            font-weight: 800;
            transition: 0.18s ease;
        }

        .biometric-button svg {
            width: 20px;
            height: 20px;
            color: var(--primary);
        }

        .biometric-button:hover {
            border-color: rgba(98, 93, 245, 0.25);
            background: #f6f7ff;
        }

        .register {
            margin: 20px 0 0;
            color: var(--muted);
            font-size: 12px;
            text-align: center;
        }

        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 18px;
            color: var(--muted);
            font-size: 10px;
            text-align: center;
        }

        .security-note svg {
            flex: 0 0 auto;
            color: var(--success);
        }

        .toast {
            position: fixed;
            z-index: 50;
            right: 16px;
            bottom: 18px;
            left: 16px;
            display: none;
            max-width: 430px;
            margin: auto;
            padding: 13px 16px;
            border-radius: 14px;
            color: white;
            background: #182033;
            box-shadow: var(--shadow);
            font-size: 13px;
            text-align: center;
        }

        .toast.show {
            display: block;
            animation: fadeIn 0.18s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (min-width: 860px) {
            .page {
                padding: 42px 32px;
            }

            .content {
                grid-template-columns: minmax(0, 1.08fr) minmax(360px, 0.92fr);
                align-items: center;
                gap: 56px;
            }

            .hero-chips {
                margin-top: 6px;
            }

            .login-card {
                padding: 34px;
            }

            .login-card h2 {
                font-size: 28px;
            }
        }

        @media (min-width: 1100px) {
            .content {
                gap: 88px;
            }
        }

        @media (max-width: 900px) {
            .hero-chips {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 540px) {
            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .login-card {
                padding: 22px;
                border-radius: 28px;
            }
        }
    </style>
</head>

<body>
<main class="page">
    <div class="shell">
        <div class="topbar">
            <div class="brand">
                <div class="logo" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 3h7l4 4v14H7z"/>
                        <path d="M14 3v5h5"/>
                        <path d="M10 13h5M10 17h5"/>
                    </svg>
                </div>
                <div class="brand-copy">
                    {{ config('app.name', 'DocuPocket') }}
                    <small>Privatni digitalni trezor</small>
                </div>
            </div>

        </div>

        <div class="content">
            <section class="intro">
                <h1>Važni dokumenti. Uvijek uz tebe.</h1>

                <p class="lead">
                    Spremi osnovne podatke, fotografije osobnih isprava i važne dokumente na jedno sigurno mjesto.
                    Pronađi OIB, broj putovnice ili PDF dokument u nekoliko sekundi i podijeli ga samo kada ti to želiš.
                </p>

                <div class="hero-chips">
                    <div class="hero-chip">
                        <div class="hero-chip-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="5" width="18" height="14" rx="3"/>
                                <path d="M7 9h4M7 13h7"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Sve na jednom mjestu</strong>
                            <span>Osobna, vozačka, putovnica i ostale isprave.</span>
                        </div>
                    </div>

                    <div class="hero-chip">
                        <div class="hero-chip-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="18" cy="5" r="3"/>
                                <circle cx="6" cy="12" r="3"/>
                                <circle cx="18" cy="19" r="3"/>
                                <path d="M8.6 10.5 15.4 6.5M8.6 13.5l6.8 4"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Jednostavno dijeljenje</strong>
                            <span>Podijeli dokument s članom obitelji putem emaila.</span>
                        </div>
                    </div>

                    <div class="hero-chip">
                        <div class="hero-chip-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="5" y="10" width="14" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Privatno i zaštićeno</strong>
                            <span>Pristup sadržaju imaju samo ti i osobe koje odabereš.</span>
                        </div>
                    </div>

                    <div class="hero-chip">
                        <div class="hero-chip-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 3v12"/>
                                <path d="m7 8 5-5 5 5"/>
                                <path d="M5 21h14a2 2 0 0 0 2-2v-4M3 15v4a2 2 0 0 0 2 2"/>
                            </svg>
                        </div>
                        <div>
                            <strong>Brzi unos s mobitela</strong>
                            <span>Fotografiraj ispravu ili učitaj dokument izravno s uređaja.</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="login-card">
                <div class="login-card-header">
                    <h2>Dobrodošao natrag</h2>
                    <p>Prijavi se kako bi pristupio svojim osobnim podacima i dokumentima.</p>
                    <div class="card-metadata" aria-hidden="true">
                        <span class="mini-pill">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            Privatna sesija
                        </span>
                        <span class="mini-pill">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 12l2 2 4-4"/>
                            </svg>
                            Brz pristup
                        </span>
                    </div>
                </div>

                @if (session('status'))
                    <div class="mini-pill" style="margin-bottom: 14px;">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="margin-bottom: 14px; padding: 12px 14px; border-radius: 14px; background: #fff1f1; color: #a31616; font-size: 12px; line-height: 1.5;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Email adresa</label>
                        <div class="input-wrap">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                placeholder="ime@primjer.hr"
                                value="{{ old('email') }}"
                                required
                            >
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="m3 7 9 6 9-6"/>
                            </svg>
                        </div>
                    </div>

                    <div class="field">
                        <div class="field-row">
                            <label for="password">Lozinka</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" id="forgotPasswordLink">Zaboravljena lozinka?</a>
                            @endif
                        </div>

                        <div class="input-wrap">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                placeholder="Unesi lozinku"
                                required
                            >
                            <button class="password-toggle" type="button" id="passwordToggle" aria-label="Prikaži lozinku">
                                <svg id="eyeIcon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <label class="remember">
                        <input type="checkbox" name="remember">
                        Zapamti me na ovom uređaju
                    </label>

                    <button class="submit-button" type="submit">Prijavi se</button>
                </form>

                <div class="divider">ili</div>

                <button class="biometric-button" type="button" id="biometricButton">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 3H6a3 3 0 0 0-3 3v2M16 3h2a3 3 0 0 1 3 3v2M8 21H6a3 3 0 0 1-3-3v-2M16 21h2a3 3 0 0 0 3-3v-2"/>
                        <path d="M9 9h.01M15 9h.01M9 15c1.5 1 4.5 1 6 0"/>
                    </svg>
                    Prijava biometrijom
                </button>

                <p class="register">
                    Još nemaš račun?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" id="createAccountLink">Kreiraj račun</a>
                    @endif
                </p>

                <div class="security-note">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="5" y="10" width="14" height="11" rx="2"/>
                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>
                    Prijava je zaštićena sigurnom vezom.
                </div>
            </section>
        </div>
    </div>
</main>

<div class="toast" id="toast"></div>

<script>
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.getElementById('passwordToggle');
    const loginForm = document.getElementById('loginForm');
    const toast = document.getElementById('toast');
    const biometricButton = document.getElementById('biometricButton');
    const createAccountLink = document.getElementById('createAccountLink');
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');

    passwordToggle.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        passwordToggle.setAttribute(
            'aria-label',
            isPassword ? 'Sakrij lozinku' : 'Prikaži lozinku'
        );
    });

    biometricButton.addEventListener('click', () => {
        showToast('Biometrijska prijava dostupna je nakon povezivanja s autentikacijskim providerom.');
    });

    if (createAccountLink) {
        createAccountLink.addEventListener('click', () => {
            showToast('Otvara se registracija.');
        });
    }

    if (forgotPasswordLink) {
        forgotPasswordLink.addEventListener('click', () => {
            showToast('Otvara se reset lozinke.');
        });
    }

    function showToast(message) {
        toast.textContent = message;
        toast.classList.add('show');

        clearTimeout(window.toastTimer);
        window.toastTimer = setTimeout(() => {
            toast.classList.remove('show');
        }, 2800);
    }
</script>
</body>
</html>
