@props(['href' => null, 'variant' => 'primary', 'icon' => null, 'size' => null])

@php
    $classes = trim('btn btn-'.$variant.($size ? ' btn-'.$size : ''));
    $type = $attributes->get('type', 'button');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->except(['type', 'href'])->merge(['class' => $classes]) }}>
        @if($icon)<x-admin.icon :name="$icon" />@endif{{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->except('type')->merge(['class' => $classes]) }}>
        @if($icon)<x-admin.icon :name="$icon" />@endif{{ $slot }}
    </button>
@endif
