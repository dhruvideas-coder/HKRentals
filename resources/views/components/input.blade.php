@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
])

<div class="mb-4">
    @if($label)
        <label for="{{ $id ?? $name }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    
    @if($type === 'tel')
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 gap-1.5 pointer-events-none select-none">
            <img src="{{ asset('images/us-flag.svg') }}" alt="US" class="w-5 h-3.5 rounded-sm object-cover shadow-sm flex-shrink-0" />
            <span class="text-neutral-500 font-semibold text-xs">+1</span>
        </span>
        <input
            type="{{ $type }}"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-input pl-14']) }}
        />
    </div>
    @else
    <input
        type="{{ $type }}"
        id="{{ $id ?? $name }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-input']) }}
    />
    @endif
    
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
