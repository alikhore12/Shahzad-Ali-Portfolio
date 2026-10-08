@props(['name', 'label', 'checked' => false, 'hint' => null])

<div {{ $attributes->merge(['class' => 'switch-row']) }}>
    <div class="switch-meta">
        <strong>{{ $label }}</strong>
        @if($hint)<span>{{ $hint }}</span>@endif
    </div>
    <label class="switch">
        <input type="checkbox" name="{{ $name }}" value="1" @checked(old($name, $checked)) aria-label="{{ $label }}">
        <span></span>
    </label>
</div>
