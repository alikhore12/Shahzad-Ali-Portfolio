@extends('portfolio.layout')
@section('content')
@php($experiences = \App\Models\Experience::where('published', true)->orderBy('sort_order')->latest()->get())
<div class="shell page-hero"><a class="back-link" href="{{ route('home') }}">&larr; Back home</a><h1 class="serif">Learning in public, building in practice.</h1><p>Experience entries added from the dashboard appear here automatically.</p></div>
<section><div class="shell timeline">
@forelse($experiences as $experience)
<div class="timeline-item"><small>{{ $experience->period ?: 'Experience' }}{{ $experience->company ? ' · '.$experience->company : '' }}</small><h3>{{ $experience->title }}</h3><p>{{ $experience->description }}</p></div>
@empty
<p>No published experience entries yet.</p>
@endforelse
</div></section>
@endsection

