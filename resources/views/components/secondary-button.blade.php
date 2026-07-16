<button {{ $attributes->merge(['type' => 'button', 'class' => 'auth-button auth-button-secondary']) }}>
    {{ $slot }}
</button>
