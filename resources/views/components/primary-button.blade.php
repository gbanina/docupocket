<button {{ $attributes->merge(['type' => 'submit', 'class' => 'auth-button auth-button-primary']) }}>
    {{ $slot }}
</button>
