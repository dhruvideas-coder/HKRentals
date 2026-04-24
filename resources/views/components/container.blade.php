@props([
    'size' => 'default',  // sm | default | lg | full
])

@php
    $maxW = match($size) {
        'sm'   => 'max-w-3xl',
        'lg'   => 'max-w-screen-xl',
        'full' => 'max-w-full',
        default => 'max-w-6xl',
    };
@endphp

<div {{ $attributes->merge(['class' => "container-sk {$maxW}"]) }}>
    {{ $slot }}
</div>
