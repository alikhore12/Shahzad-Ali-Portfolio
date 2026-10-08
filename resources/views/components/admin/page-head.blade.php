@props(['title', 'eyebrow' => null, 'subtitle' => null])

<div class="page-head">
    <div>
        @if($eyebrow)<div class="eyebrow">{{ $eyebrow }}</div>@endif
        <h1>{{ $title }}</h1>
        @if($subtitle)<p class="page-sub">{{ $subtitle }}</p>@endif
    </div>
    @isset($actions)
        <div class="page-actions">{{ $actions }}</div>
    @endisset
</div>
