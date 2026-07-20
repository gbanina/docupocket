<x-guest-layout
    :title="config('app.name', 'DocuPocket') . ' — Privacy'"
    heading="Privacy"
    subtitle="Kako prikupljamo, čuvamo i štitimo tvoje podatke."
    link-label="Natrag na prijavu"
    :link-label-url="route('login')"
    link-text="Prijavi se"
    :link-url="route('login')"
>
    <div class="public-page-content">
        <div class="auth-note">
            Ova stranica opisuje kako DocuPocket postupa s podacima koje korisnik unosi u sustav.
        </div>

        <section class="public-page-section">
            <h3>Koje podatke pohranjujemo</h3>
            <p>Pohranjujemo osnovne podatke, isprave, dokumente i informacije potrebne za rad računa.</p>
        </section>

        <section class="public-page-section">
            <h3>Kako štitimo podatke</h3>
            <ul class="public-page-list">
                <li>osjetljivi podaci se enkriptiraju prije spremanja</li>
                <li>dokumentima pristupa samo njihov vlasnik</li>
                <li>pristup se može dodatno ograničiti kroz dijeljenje i autorizaciju</li>
            </ul>
        </section>

        <section class="public-page-section">
            <h3>Koliko dugo čuvamo podatke</h3>
            <p>Podatke čuvamo dok korisnik ne obriše račun ili dok je to potrebno za pružanje usluge.</p>
        </section>
    </div>
</x-guest-layout>
