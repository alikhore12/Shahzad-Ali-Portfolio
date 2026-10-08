@extends('portfolio.layout')
@section('content')
@php($educations = \App\Models\Education::where('published', true)->orderBy('sort_order')->latest()->get())
<div class="shell page-hero"><a class="back-link" href="{{ route('home') }}">&larr; Back home</a><h1 class="serif">Education that keeps the curiosity switched on.</h1><p>Education entries added from the dashboard appear here automatically.</p></div>
<section class="cream-band"><div class="shell detail-grid">
@forelse($educations as $education)
<article class="detail-card"><span class="number">{{ $education->period ?: 'EDUCATION' }}</span><h3>{{ $education->degree }}</h3><p><strong>{{ $education->institution }}</strong></p><p>{{ $education->description }}</p></article>
@empty
<p>No published education entries yet.</p>
@endforelse
</div></section>
@endsection

