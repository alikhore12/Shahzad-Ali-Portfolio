@props(['name', 'label', 'value' => null, 'rows' => 6, 'placeholder' => null, 'required' => false, 'optional' => false, 'hint' => null, 'mono' => false, 'tall' => false])

<div {{ $attributes->merge(['class' => 'form-field']) }}>
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if($required)<span class="req">*</span>@elseif($optional)<span class="optional">optional</span>@endif
    </label>

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        @class(['form-control', 'is-invalid' => $errors->has($name), 'mono' => $mono, 'tall' => $tall])
    >{{ old($name, $value) }}</textarea>

    @if($hint)<p class="form-hint">{{ $hint }}</p>@endif
    @error($name)<p class="form-error">{{ $message }}</p>@enderror
</div>
