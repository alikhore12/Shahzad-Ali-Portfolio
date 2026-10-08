@extends('portfolio.layout')
@section('content')
@php
    $aboutTitle = \App\Models\Setting::value('about_title', 'A developer who cares about the details.');
    $aboutIntro = \App\Models\Setting::value('about_intro', 'I am Shahzad Ali, a BS Computer Science student building a practical foundation in full-stack development, design and digital growth.');
    $aboutCards = json_decode(\App\Models\Setting::value('about_cards', '[]'), true);
@endphp
<div class="shell page-hero"><a class="back-link" href="{{ route('home') }}">&larr; Back home</a><h1 class="serif">{{ $aboutTitle }}</h1><p>{{ $aboutIntro }}</p></div>
<section class="cream-band"><div class="shell detail-grid">
@forelse(is_array($aboutCards) ? $aboutCards : [] as $card)
<article class="detail-card"><span class="number">{{ $card['label'] ?? sprintf('%02d', $loop->iteration) }}</span><h3>{{ $card['title'] ?? '' }}</h3><p>{{ $card['text'] ?? '' }}</p></article>
@empty
<p>No about content has been published yet.</p>
@endforelse
</div></section>
@endsection

