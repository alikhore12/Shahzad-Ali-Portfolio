@extends('portfolio.layout')
@section('content')
@php($services = \App\Models\PortfolioService::where('published', true)->orderBy('id')->get())
<div class="shell page-hero"><a class="back-link" href="{{ route('home') }}">&larr; Back home</a><h1 class="serif">Useful things I can help with.</h1><p>Explore each service to see the kind of work and outcomes it is designed around.</p></div>
<section class="cream-band"><div class="shell detail-grid">
@forelse($services as $service)
<article class="detail-card"><span class="number">0{{ $loop->iteration }}</span><h3>{{ $service->name }}</h3><p>{{ $service->intro }}</p><a class="back-link" href="{{ route('services.show', $service->slug) }}">Read service detail &rarr;</a></article>
@empty
<p>No published services yet.</p>
@endforelse
</div></section>
@endsection

