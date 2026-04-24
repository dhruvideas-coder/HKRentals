@props([
    'variant' => 'primary',  // primary | outline | ghost
    'size'    => 'md',        // sm | md | lg
    'tag'     => 'button',    // button | a | span
    'type'    => 'button',
    'href'    => null,
    'disabled'=> false,
])

@php
    $variantClass = match($variant) {
        'outline' => 'btn-outline',
        'ghost'   => 'btn-ghost',
        default   => 'btn-primary',
    };
    $sizeClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => '',
    };
    $disabledAttr = $disabled ? 'disabled aria-disabled="true" opacity-60 cursor-not-allowed pointer-events-none' : '';
@endphp

@if ($tag === 'a' && $href)
    <a href="{{ $href }}"
       {{ $attributes->merge(['class' => "btn {$variantClass} {$sizeClass}"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => "btn {$variantClass} {$sizeClass}" . ($disabled ? ' opacity-60 cursor-not-allowed pointer-events-none' : '')]) }}>
        {{ $slot }}
    </button>
@endif
