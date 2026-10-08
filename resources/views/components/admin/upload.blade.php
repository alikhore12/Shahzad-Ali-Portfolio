@props(['name', 'label', 'current' => null, 'hint' => 'PNG, JPG or WEBP up to 4 MB', 'optional' => true])

@php
    $placeholder = 'data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="96" height="70"%3E%3Crect width="96" height="70" fill="%23efe9de"/%3E%3Cpath d="M36 44h24M40 38h16" stroke="%23cc785c" stroke-width="3" stroke-linecap="round"/%3E%3C/svg%3E';
@endphp

<div {{ $attributes->merge(['class' => 'form-field']) }}>
    <label class="form-label" for="{{ $name }}">
        {{ $label }}
        @if($optional)<span class="optional">optional</span>@endif
    </label>

    <div class="upload-box">
        <img class="upload-preview" id="preview-{{ $name }}" src="{{ $current && ! str_starts_with($current, 'http') ? asset($current) : ($current ?: $placeholder) }}" alt="Current {{ $label }}">
        <div class="upload-meta">
            <input type="file" name="{{ $name }}" id="{{ $name }}" data-image-input="#preview-{{ $name }}">
            <p>{{ $hint }}{{ $current ? ' · Replacing the current image' : '' }}</p>
        </div>
    </div>

    @error($name)<p class="form-error">{{ $message }}</p>@enderror
</div>
