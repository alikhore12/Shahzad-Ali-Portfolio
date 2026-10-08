@props(['name', 'label', 'type' => 'text', 'value' => null, 'placeholder' => null, 'required' => false, 'optional' => false, 'hint' => null, 'autocomplete' => null])

<div {{ $attributes->merge(['class' => 'form-field']) }}>
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if($required)<span class="req">*</span>@elseif($optional)<span class="optional">optional</span>@endif
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        @if($type !== 'file') value="{{ old($name, $value) }}" @endif
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($required) required @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if($type === 'file') accept="image/*" @endif
        class="form-control @error($name) is-invalid @enderror"
    >

    @if($hint)<p class="form-hint">{{ $hint }}</p>@endif
    @error($name)<p class="form-error">{{ $message }}</p>@enderror
</div>
