@props(['tone' => '', 'label' => null, 'dot' => true])

<span {{ $attributes->merge(['class' => 'badge '.($tone ? 'is-'.$tone : '').($dot ? '' : ' no-dot')]) }}>{{ $label ?? $slot }}</span>
