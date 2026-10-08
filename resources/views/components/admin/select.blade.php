@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false, 'hint' => null])

@php($current = old($name, $value))

<div {{ $attributes->merge(['class' => 'form-field']) }}>
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if($required)<span class="req">*</span>@endif
    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if($required) required @endif
        @class(['form-control', 'is-invalid' => $errors->has($name)])
    >
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected((string) $current === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @if($hint)<p class="form-hint">{{ $hint }}</p>@endif
    @error($name)<p class="form-error">{{ $message }}</p>@enderror
</div>
