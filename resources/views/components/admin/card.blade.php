@props(['title' => null, 'subtitle' => null, 'pad' => true, 'flush' => false])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($title)
        <div class="card-head">
            <div>
                <h2>{{ $title }}</h2>
                @if($subtitle)<p class="card-sub">{{ $subtitle }}</p>@endif
            </div>
            @isset($actions)<div class="page-actions">{{ $actions }}</div>@endisset
        </div>
    @endif
    <div @class(['card-body' => $pad, 'card-body tight' => $flush])>
        {{ $slot }}
    </div>
</div>
