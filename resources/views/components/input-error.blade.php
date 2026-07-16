@props(['messages'])

@if ($messages)
    <div {{ $attributes->merge(['class' => 'auth-error-list']) }}>
        <ul>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
