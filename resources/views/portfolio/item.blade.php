@extends('portfolio.layout')

@section('content')
<div class="shell page-hero">
    <a class="back-link" href="{{ $type === 'Service' ? route('services') : route('skills') }}">&larr; All {{ strtolower($type) }}s</a>
    <h1 class="serif">{{ $item['name'] }}</h1>
    <p>{{ $item['intro'] }}</p>
</div>

<section>
    <div class="shell project-detail">
        <div class="project-visual coral"><span>{{ strtoupper($type) }}</span><strong>&rarr;</strong></div>
        <div class="project-copy">
            <div class="project-meta">{{ strtoupper($type) }} DETAIL</div>
            <h2 class="serif">A clear path to useful work.</h2>
            <p>{{ $item['details'] }}</p>
            <ul class="project-features">
                @foreach($item['points'] ?? [] as $point)
                    <li>{{ $point }}</li>
                @endforeach
            </ul>
            <a class="btn-coral" href="{{ route('contact') }}">Start a conversation &rarr;</a>
        </div>
    </div>
</section>

@if($type === 'Service' && !empty($item['documents']))
    <section class="documents-section">
        <div class="shell">
            <div class="section-label">Attached documents</div>
            <h2 class="serif">Professional CVs</h2>
            <p class="documents-intro">Download the CV versions attached to this service.</p>
            <div class="documents-grid">
                @foreach($item['documents'] as $document)
                    <a class="document-card" href="{{ asset($document['path']) }}" target="_blank" rel="noopener" download>
                        <iframe class="document-preview" src="{{ asset($document['path']) }}#page=1&view=FitH&zoom=page-fit&toolbar=0&navpanes=0&scrollbar=0" title="{{ $document['title'] }} preview" loading="lazy"></iframe>
                        <span class="document-type">PDF</span>
                        <span class="document-title">{{ $document['title'] }}</span>
                        <span class="document-action">Open / download &rarr;</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
