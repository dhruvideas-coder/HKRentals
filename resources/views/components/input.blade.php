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
    
    <input 
        type="{{ $type }}" 
        id="{{ $id ?? $name }}" 
        name="{{ $name }}" 
        value="{{ $value }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-input']) }} 
    />
    
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
