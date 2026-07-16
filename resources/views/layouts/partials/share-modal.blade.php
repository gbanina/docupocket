<div class="modal-backdrop" id="shareModal" role="dialog" aria-modal="true" aria-labelledby="shareTitle">
    <div class="modal">
        <h3 id="shareTitle">Podijeli dokument</h3>
        <p id="shareDescription">Upiši email osobe kojoj želiš omogućiti pristup.</p>

        <div class="field">
            <label for="recipientEmail">Email primatelja</label>
            <input id="recipientEmail" type="email" placeholder="ime@primjer.hr">
        </div>

        <div class="field">
            <label for="shareDuration">Trajanje pristupa</label>
            <input id="shareDuration" type="text" value="7 dana">
        </div>

        <div class="modal-actions">
            <button class="secondary-button" id="closeModal" type="button">Odustani</button>
            <button class="primary-button" id="confirmShare" type="button">Podijeli</button>
        </div>
    </div>
</div>
