@php
    $metaTitle = 'Shahzad Ali | Full-Stack Web Developer';
    $metaDescription = 'Portfolio of Shahzad Ali - a Laravel, PHP and JavaScript developer building thoughtful web experiences.';
    $profile = \App\Models\Profile::first();
    $aboutTitle = \App\Models\Setting::value('about_title', 'Good software starts with listening.');
    $aboutIntro = \App\Models\Setting::value('about_intro', 'My work sits at the intersection of engineering, visual clarity and sustainable growth.');
    $aboutCards = json_decode(\App\Models\Setting::value('about_cards', '[]'), true) ?: [];
    $skills = \App\Models\PortfolioSkill::where('published', true)->orderBy('id')->get();
    $services = \App\Models\PortfolioService::where('published', true)->orderBy('id')->get();
    $experiences = \App\Models\Experience::where('published', true)->orderBy('sort_order')->latest()->get();
    $educations = \App\Models\Education::where('published', true)->orderBy('sort_order')->latest()->get();
    $projectCategories = collect($projects)->pluck('category')->filter()->unique()->values();
    $displayName = $profile?->name ?: 'Shahzad Ali';
    $displayTitle = $profile?->title ?: 'Full-Stack Web Developer';
    $displayBio = $profile?->bio ?: 'I build thoughtful, responsive web products with Laravel, PHP, JavaScript and a careful eye for detail.';
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle }}</title><meta name="description" content="{{ $metaDescription }}">
    <link rel="icon" type="image/svg+xml" href="{{ route('profile.favicon') }}">
    <link rel="canonical" href="{{ url('/') }}">
    @if(file_exists(public_path('build/manifest.json'))) @vite(['resources/css/app.css','resources/js/app.js']) @else <link rel="stylesheet" href="{{ route('portfolio.css') }}"> @endif
</head>
<body>
<header class="shell nav">
    <a class="brand" href="#home"><span class="brand-mark"></span>{{ $displayName }}</a>
    <button class="menu" data-menu aria-label="Toggle navigation">☰</button>
    <nav class="nav-links" data-links><a href="#about">About</a><a href="#skills">Skills</a><a href="#projects">Projects</a><a href="#services">Services</a><a href="#journey">Journey</a><a class="nav-cta" href="#contact">Let's talk</a></nav>
</header>
<main>
<section class="shell hero hero-glow" id="home">
    <div class="reveal"><div class="eyebrow">{{ $displayTitle }} · {{ collect([$profile?->location, $profile?->country])->filter()->join(', ') ?: 'Lahore, Pakistan' }}</div><h1 class="serif">I build digital work with a human point of view.</h1><p class="hero-copy">{{ $displayBio }}</p><div class="actions"><a class="btn-pill" href="#projects">View my work ↗</a><a class="btn-outline" href="#contact">Start a conversation</a></div><p class="note"><span class="badge-dot" style="margin-right:8px"></span>{{ $profile?->availability ?: 'Available for selected freelance and collaborative projects.' }}</p></div>
    <div class="hero-card reveal"><div class="portrait" style="--portrait-image: url('{{ $profile?->image_path ? asset($profile->image_path) : asset('images/shahzad-ali.png') }}')" role="img" aria-label="{{ $displayName }}"></div></div>
</section>

<section id="architecture"><div class="shell"><div class="section-head reveal"><div><div class="section-label">00 / Architecture</div><h2 class="serif">Backend pipelines, visualized.</h2></div><p class="section-intro">The orchestration canvas behind the work — queues, workers and databases humming together.</p></div>
<div class="glass-card reveal p-6 overflow-x-auto">
<svg viewBox="0 0 940 320" class="w-full min-w-[720px]" fill="none">
<path class="flow-path" data-link="gw" d="M150 160 C 220 160, 250 80, 330 80"/>
<path class="flow-path" data-link="gw" d="M150 160 C 220 160, 250 240, 330 240"/>
<path class="flow-path" data-link="redis" d="M440 80 C 520 80, 520 150, 560 150"/>
<path class="flow-path" data-link="workers" d="M440 240 C 520 240, 520 170, 560 170"/>
<path class="flow-path" data-link="db" d="M680 150 C 720 150, 715 80, 750 80"/>
<path class="flow-path" data-link="hooks" d="M680 170 C 720 170, 715 240, 750 240"/>
<path class="flow-pulse" data-link="gw" d="M150 160 C 220 160, 250 80, 330 80"/>
<path class="flow-pulse" data-link="gw" d="M150 160 C 220 160, 250 240, 330 240" style="animation-delay:.3s"/>
<path class="flow-pulse" data-link="redis" d="M440 80 C 520 80, 520 150, 560 150" style="animation-delay:.5s"/>
<path class="flow-pulse" data-link="workers" d="M440 240 C 520 240, 520 170, 560 170" style="animation-delay:.7s"/>
<path class="flow-pulse" data-link="db" d="M680 150 C 720 150, 715 80, 750 80" style="animation-delay:.9s"/>
<path class="flow-pulse" data-link="hooks" d="M680 170 C 720 170, 715 240, 750 240" style="animation-delay:1.1s"/>
<g id="node-gw" class="flow-node" data-links="gw" tabindex="0"><rect x="30" y="130" width="120" height="60" rx="12" fill="#18181b" stroke="#3f3f46"/><text x="90" y="165" text-anchor="middle" fill="#e4e4e7" font-size="13">API Gateway</text></g>
<g id="node-redis" class="flow-node" data-links="gw,redis" tabindex="0"><rect x="330" y="50" width="110" height="60" rx="12" fill="#18181b" stroke="#3f3f46"/><text x="385" y="85" text-anchor="middle" fill="#e4e4e7" font-size="13">Redis Queue</text></g>
<g id="node-workers" class="flow-node" data-links="gw,workers" tabindex="0"><rect x="330" y="210" width="110" height="60" rx="12" fill="#18181b" stroke="#3f3f46"/><text x="385" y="245" text-anchor="middle" fill="#e4e4e7" font-size="13">Workers</text></g>
<g id="node-server" class="flow-node" data-links="redis,workers,db,hooks" tabindex="0"><rect x="560" y="130" width="120" height="60" rx="12" fill="#18181b" stroke="#3f3f46"/><text x="620" y="165" text-anchor="middle" fill="#e4e4e7" font-size="13">API Server</text></g>
<g id="node-db" class="flow-node" data-links="db" tabindex="0"><rect x="750" y="50" width="140" height="60" rx="12" fill="#18181b" stroke="#3f3f46"/><text x="820" y="85" text-anchor="middle" fill="#e4e4e7" font-size="13">PostgreSQL</text></g>
<g id="node-hooks" class="flow-node" data-links="hooks" tabindex="0"><rect x="750" y="210" width="140" height="60" rx="12" fill="#18181b" stroke="#3f3f46"/><text x="820" y="245" text-anchor="middle" fill="#e4e4e7" font-size="13">Webhooks</text></g>
</svg>
<div class="flex flex-wrap gap-3 justify-center -mt-2 pb-2 text-sm text-neutral-400">
<span class="glass-card px-4 py-2 flow-node" data-links="gw">API Gateway</span>
<span class="glass-card px-4 py-2 flow-node" data-links="redis">Redis Queue</span>
<span class="glass-card px-4 py-2 flow-node" data-links="workers">Background Workers</span>
<span class="glass-card px-4 py-2 flow-node" data-links="db">PostgreSQL</span>
<span class="glass-card px-4 py-2 flow-node" data-links="hooks">Webhooks</span>
</div>
</div></div></section>

<div class="shell stats reveal"><div class="stat"><strong class="stat-num" data-count="{{ $projects ? count($projects) : 0 }}" data-suffix="+">0</strong><span>Projects completed</span></div><div class="stat"><strong class="stat-num" data-count="{{ $skills->count() }}">0</strong><span>Core skills</span></div><div class="stat"><strong class="stat-num" data-count="99" data-suffix=".9%">0</strong><span>Uptime</span></div><div class="stat"><strong class="stat-num" data-count="40" data-suffix="%">0</strong><span>Latency reduced</span></div></div>

<section class="cream-band" id="about"><div class="shell"><div class="section-head reveal"><div><div class="section-label">01 / About</div><h2 class="serif">{{ $aboutTitle }}</h2></div><p class="section-intro">{{ $aboutIntro }}</p></div><div class="feature-grid">@forelse($aboutCards as $card)<article class="feature reveal spotlight glass-card"><span class="number">{{ $card['label'] ?? sprintf('%02d', $loop->iteration) }}</span><h3>{{ $card['title'] ?? '' }}</h3><p>{{ $card['text'] ?? '' }}</p></article>@empty<p>No about content published yet.</p>@endforelse</div></div></section>

<section class="code-band" id="skills"><div class="shell code-wrap"><div class="reveal"><div class="section-label">02 / Skills</div><h2 class="serif">The stack behind the work.</h2><p style="color:#a09d96;margin-top:24px">Skills managed from the dashboard and used across the work.</p></div><div class="code-window reveal">@forelse($skills as $skill)<span class="teal">{{ $skill->category }}</span>: {{ $skill->name }}<br>@empty No published skills yet.@endforelse</div></div></section>

<section id="projects"><div class="shell"><div class="section-head reveal"><div><div class="section-label">03 / Selected work</div><h2 class="serif">A few things I've been making.</h2></div><p class="section-intro">Projects added from the dashboard appear here automatically.</p></div><div class="filter-bar"><button class="filter active" data-filter="all">All work</button>@foreach($projectCategories as $category)<button class="filter" data-filter="{{ $category }}">{{ $category }}</button>@endforeach</div><div class="projects">@forelse($projects as $project)<article class="project reveal spotlight" role="link" tabindex="0" data-project="{{ $project['category'] }}" data-project-url="{{ route('projects.show', $project['slug']) }}"><div class="project-art {{ $project['accent'] ?? 'coral' }}" style="isolation:isolate">@if(!empty($project['image_url']))<img class="project-art-image" src="{{ filter_var($project['image_url'], FILTER_VALIDATE_URL) ? $project['image_url'] : asset($project['image_url']) }}" alt="{{ $project['name'] }} project preview" loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;z-index:-1">@endif<span>{{ $project['category'] }} / {{ sprintf('%02d', $loop->iteration) }}</span><strong>{{ sprintf('%02d', $loop->iteration) }}</strong></div><div class="project-body"><h3>{{ $project['name'] }}</h3><p>{{ $project['description'] }}</p><div class="tags">@foreach($project['tags'] ?? [] as $tag)<span class="tag">{{ $tag }}</span>@endforeach</div></div></article>@empty<p>No published projects yet.</p>@endforelse</div></div></section>

<section class="cream-band" id="services"><div class="shell"><div class="section-head reveal"><div><div class="section-label">04 / Services</div><h2 class="serif">Useful things I can help with.</h2></div></div><div class="services-grid">@forelse($services as $service)<article class="service reveal spotlight"><div class="service-icon">{{ sprintf('%02d', $loop->iteration) }}</div><h3>{{ $service->name }}</h3><p>{{ $service->intro }}</p></article>@empty<p>No published services yet.</p>@endforelse</div></div></section>

<section id="journey"><div class="shell"><div class="section-head reveal"><div><div class="section-label">05 / The journey</div><h2 class="serif">Learning in public,<br>building in practice.</h2></div><p class="section-intro">Experience and education entries managed from the dashboard.</p></div><div class="timeline">@forelse($experiences as $experience)<div class="timeline-item reveal"><small>{{ $experience->period ?: 'Experience' }}{{ $experience->company ? ' · '.$experience->company : '' }}</small><h3>{{ $experience->title }}</h3><p>{{ $experience->description }}</p></div>@empty<p>No published experience entries yet.</p>@endforelse @foreach($educations as $education)<div class="timeline-item reveal"><small>{{ $education->period ?: 'Education' }}</small><h3>{{ $education->degree }}</h3><p>{{ $education->institution }} - {{ $education->description }}</p></div>@endforeach</div></div></section>

<section class="shell" id="contact"><div class="contact reveal"><div><div class="section-label" style="color:#ffe0d6">06 / Contact</div><h2 class="serif">Have a good idea?<br>Let's give it shape.</h2><p>Tell me a little about what you're building, where you're stuck or what you want to explore next.</p><p style="margin-top:30px;font:13px var(--mono)">{{ config('mail.from.address') }}</p></div><div>@if(session('success'))<div class="success">{{ session('success') }}</div>@endif<form method="POST" action="{{ route('contact.store') }}">@csrf<div class="form-grid"><div class="field"><label for="name">Your name</label><input id="name" name="name" value="{{ old('name') }}" placeholder="Jane Smith" required>@error('name')<span class="error">{{ $message }}</span>@enderror</div><div class="field"><label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="jane@example.com" required>@error('email')<span class="error">{{ $message }}</span>@enderror</div><div class="field full"><label for="subject">What can I help with?</label><input id="subject" name="subject" value="{{ old('subject') }}" placeholder="A new website, an idea, a question..." required>@error('subject')<span class="error">{{ $message }}</span>@enderror</div><div class="field full"><label for="message">A little more detail</label><textarea id="message" name="message" placeholder="Tell me about the project..." required>{{ old('message') }}</textarea>@error('message')<span class="error">{{ $message }}</span>@enderror</div><div class="field full"><button class="btn-light" type="submit">Send message ↗</button></div></div></form></div></div></section>
</main>
<footer class="footer"><div class="shell"><div class="footer-grid"><div><a class="brand" href="#home"><span class="brand-mark"></span>{{ $displayName }}</a><p style="margin-top:18px;max-width:240px">{{ $displayTitle }} building useful digital experiences.</p></div><div><h3>Explore</h3><a href="#about">About</a><a href="#skills">Skills</a><a href="#projects">Projects</a></div><div><h3>Connect</h3><a href="#contact">Contact</a><a href="{{ route('sitemap') }}">Sitemap</a></div><div><h3>Elsewhere</h3><a href="https://github.com" target="_blank" rel="noopener noreferrer">GitHub ↗</a><a href="https://linkedin.com" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a><a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }} ↗</a></div></div><div class="footer-bottom"><span>© {{ date('Y') }} {{ $displayName }}</span><span>Designed with warmth · Built with Laravel</span></div></div></footer>
</body></html>

