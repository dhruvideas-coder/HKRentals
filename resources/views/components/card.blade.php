@props([
    'padding' => 'default',  // none | sm | default | lg
    'hover'   => false,
    'class'   => '',
])

@php
    $paddingClass = match($padding) {
        'none'  => '',
        'sm'    => 'p-4',
        'lg'    => 'p-8',
        default => 'p-6',
    };
    $hoverClass = $hover ? 'hover:shadow-elevated hover:-translate-y-0.5 transition-all duration-200 cursor-pointer' : '';
@endphp

<div {{ $attributes->merge(['class' => "card {$paddingClass} {$hoverClass}"]) }}>
    {{ $slot }}
</div>
