<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f5f7fb">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon-16x16.png') }}">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('img/android-chrome-512x512.png') }}">
    <link rel="manifest" href="{{ asset('img/site.webmanifest') }}">

    <title>{{ config('app.name', 'DocuPocket') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        a {
            color: inherit;
            text-decoration: none;
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            align-items: center;
            padding: 18px;
        }

        .auth-shell {
            width: min(100%, 1120px);
            margin: 0 auto;
            display: grid;
            gap: 28px;
        }

        .brand-panel,
        .auth-panel {
            border-radius: 32px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .brand-panel {
            position: relative;
            padding: 0;
            color: var(--text);
        }

        .brand-content {
            display: grid;
            align-content: start;
            gap: 18px;
            padding: 6px 2px 0;
            max-width: 640px;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
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

        .logo-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--primary), #8f7aff);
            box-shadow: 0 12px 30px rgba(101, 71, 255, 0.35);
        }

        .hero-copy {
            display: grid;
            align-content: start;
            gap: 18px;
            max-width: 640px;
        }

        .hero-copy h1 {
            margin: 0;
            max-width: 720px;
            font-size: clamp(38px, 10vw, 66px);
            line-height: 0.98;
            letter-spacing: -0.06em;
        }

        .hero-copy p {
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

        .auth-panel {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(18px);
        }

        .auth-card {
            padding: 28px;
        }

        .auth-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .auth-card-title {
            max-width: 420px;
        }

        .auth-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 800;
        }

        .auth-card h2 {
            margin: 0;
            font-size: 27px;
            line-height: 1.04;
            letter-spacing: -0.04em;
        }

        .auth-card p.auth-lead {
            margin: 10px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.65;
        }

        .auth-badge-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
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

        .auth-slot {
            display: grid;
            gap: 16px;
        }

        .auth-form {
            display: grid;
            gap: 16px;
        }

        .auth-field {
            display: grid;
            gap: 8px;
        }

        .auth-field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .auth-label {
            color: #243042;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.02em;
        }

        .auth-input {
            width: 100%;
            height: 52px;
            padding: 0 15px;
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            outline: none;
            color: var(--text);
            background: #fafbfe;
            transition: 0.18s ease;
            font-size: 14px;
        }

        .auth-input:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .auth-hint {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.55;
        }

        .auth-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 52px;
            padding: 0 18px;
            border: 0;
            border-radius: 15px;
            font-weight: 800;
            transition: 0.18s ease;
        }

        .auth-button-primary {
            color: white;
            background: linear-gradient(145deg, var(--primary), #7b76ff);
            box-shadow: 0 16px 26px rgba(98, 93, 245, 0.28);
        }

        .auth-button-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .auth-button-secondary {
            color: var(--text);
            background: var(--surface-soft);
            border: 1px solid var(--line);
        }

        .auth-button-secondary:hover {
            border-color: rgba(98, 93, 245, 0.25);
            background: #f6f7ff;
        }

        .auth-message {
            padding: 12px 14px;
            border-radius: 14px;
            font-size: 13px;
            line-height: 1.55;
        }

        .auth-message-success {
            background: #e9f8f2;
            color: #166a43;
        }

        .auth-message-error {
            background: #fff1f1;
            color: #a31616;
        }

        .auth-error-list {
            padding: 12px 14px;
            border-radius: 14px;
            background: #fff1f1;
            color: #a31616;
            font-size: 12px;
            line-height: 1.55;
        }

        .auth-error-list ul {
            margin: 0;
            padding-left: 18px;
        }

        .auth-stack {
            display: grid;
            gap: 16px;
        }

        .auth-note {
            padding: 12px 14px;
            border-radius: 14px;
            background: #f7f8ff;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.55;
        }

        .auth-actions-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .auth-link {
            color: var(--primary);
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 999px;
            background: var(--surface-soft);
            font-size: 12px;
            font-weight: 800;
            color: var(--text);
        }

        .auth-back svg {
            color: var(--primary);
        }

        @media (min-width: 920px) {
            .auth-page {
                padding: 42px 32px;
            }

            .auth-shell {
                grid-template-columns: minmax(0, 1.08fr) minmax(360px, 0.92fr);
                align-items: center;
                gap: 56px;
            }

            .auth-card {
                padding: 34px;
            }
        }

        @media (max-width: 919px) {
            .auth-shell {
                gap: 22px;
            }

            .brand-panel {
                padding: 0;
            }

            .hero-copy {
                max-width: 100%;
            }

            .auth-card {
                padding: 20px;
            }
        }

        @media (max-width: 620px) {
            .auth-page {
                padding: 12px;
            }

            .brand-panel,
            .auth-panel {
                border-radius: 28px;
            }

            .auth-card-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .auth-back {
                width: fit-content;
            }

            .hero-chips {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <div class="auth-shell">
            <aside class="brand-panel">
                <div class="brand-content">
                    <a href="{{ url('/') }}" class="logo">
                        <span class="logo-mark" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="23" height="23">
                                <path d="M7 3h7l4 4v14H7z"/>
                                <path d="M14 3v5h5"/>
                                <path d="M10 13h5M10 17h5"/>
                            </svg>
                        </span>
                        <span class="brand-copy">
                            {{ config('app.name', 'DocuPocket') }}
                            <small>Privatni digitalni trezor</small>
                        </span>
                    </a>

                    <div class="hero-copy">
                        <h1>Važni dokumenti. Uvijek uz tebe.</h1>

                        <p>
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
                    </div>
                </div>
            </aside>

            <section class="auth-panel">
                <div class="auth-card">
                    <div class="auth-card-top">
                        <div class="auth-card-title">
                            @isset($heading)
                                <div class="auth-kicker">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4"/>
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    </svg>
                                    {{ $heading }}
                                </div>
                            @endisset

                            @isset($subtitle)
                                <h2>{{ $subtitle }}</h2>
                            @endisset
                        </div>

                        <a class="auth-back" href="{{ url('/') }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m15 18-6-6 6-6"/>
                            </svg>
                            Nazad na početak
                        </a>
                    </div>

                    @if ($status = session('status'))
                        <div class="mini-pill" style="margin-bottom: 14px;">
                            {{ $status }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div style="padding: 12px 14px; border-radius: 14px; background: #fff1f1; color: #a31616; font-size: 12px; line-height: 1.55; margin-bottom: 16px;">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="auth-slot">
                        {{ $slot }}
                    </div>

                    @if (isset($linkText) && isset($linkUrl))
                        <div class="auth-actions-row">
                            @if (isset($linkLabel) && $linkLabel)
                                <span class="auth-note">{{ $linkLabel }}</span>
                            @endif
                            <a class="auth-link" href="{{ $linkUrl }}">{{ $linkText }}</a>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
</body>
</html>
