@props(['type' => 'neutral'])

@php
    $classes = match ($type) {
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        default => 'badge-neutral',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
