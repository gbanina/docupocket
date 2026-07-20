<footer class="public-footer">
    <div class="public-footer-copy">
        © {{ date('Y') }} {{ config('app.name', 'DocuPocket') }}. Privatni digitalni trezor.
    </div>

    <div class="public-footer-links">
        <a href="{{ route('privacy') }}">Privacy</a>
        <a href="{{ route('legal') }}">Legal</a>
    </div>
</footer>
