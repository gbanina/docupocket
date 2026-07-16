@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'auth-message auth-message-success']) }}>
        {{ $status }}
    </div>
@endif
