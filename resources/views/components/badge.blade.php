@props([
    'variant' => 'neutral', // gold, neutral, available, unavailable
])

@php
    $variantClass = match($variant) {
        'gold' => 'badge-gold',
        'available' => 'badge-available',
        'unavailable' => 'badge-unavailable',
        default => 'badge-neutral',
    };
@endphp

<span {{ $attributes->merge(['class' => "badge {$variantClass}"]) }}>
    {{ $slot }}
</span>
