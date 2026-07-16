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
