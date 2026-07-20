<x-guest-layout
    :title="config('app.name', 'DocuPocket') . ' — Legal'"
    heading="Legal"
    subtitle="Uvjeti korištenja i osnovna pravila korištenja DocuPocketa."
    link-label="Natrag na prijavu"
    :link-label-url="route('login')"
    link-text="Prijavi se"
    :link-url="route('login')"
>
    <div class="public-page-content">
        <div class="auth-note">
            Ovi uvjeti opisuju osnovna pravila korištenja aplikacije. Prije produkcijskog lansiranja preporučujemo pravni pregled sadržaja.
        </div>

        <section class="public-page-section">
            <h3>Korištenje usluge</h3>
            <p>Korisnik je odgovoran za točnost podataka koje unosi i za čuvanje pristupnih podataka računu.</p>
        </section>

        <section class="public-page-section">
            <h3>Odgovornost</h3>
            <p>DocuPocket pruža alat za pohranu i organizaciju podataka. Ne jamčimo dostupnost usluge bez prekida niti potpunu ispravnost korisničkih unosa.</p>
        </section>

        <section class="public-page-section">
            <h3>Prekid računa</h3>
            <p>Korisnik može obrisati račun u bilo kojem trenutku, a podaci se tada uklanjaju sukladno pravilima platforme i tehničkim ograničenjima backup sustava.</p>
        </section>
    </div>
</x-guest-layout>
