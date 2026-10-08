@extends('portfolio.layout')
@section('content')
@php($skills = \App\Models\PortfolioSkill::where('published', true)->orderBy('id')->get())
<div class="shell page-hero"><a class="back-link" href="{{ route('home') }}">&larr; Back home</a><h1 class="serif">The toolkit behind the work.</h1><p>Open a skill to see how it fits into the way I build.</p></div>
<section class="page-band"><div class="shell skill-list">
@forelse($skills as $skill)
<article class="detail-card"><span class="number">{{ $skill->category }}</span><h3>{{ $skill->name }}</h3><p>{{ $skill->intro }}</p><a class="back-link" href="{{ route('skills.show', $skill->slug) }}">Read skill detail &rarr;</a></article>
@empty
<p>No published skills yet.</p>
@endforelse
</div></section>
@endsection

