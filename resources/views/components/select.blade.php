@props([
    'id' => null,
    'label' => null,
    'name' => '',
    'options' => [],
    'selected' => null,
    'required' => false,
])

<div class="mb-4">
    @if($label)
        <label for="{{ $id ?? $name }}" class="form-label">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    
    <select 
        id="{{ $id ?? $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-input']) }}
    >
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
        {{ $slot }}
    </select>
    
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
