@extends('layouts.public')
@section('title', $project->title . ' — Shahzad Labs Portfolio')
@section('meta_description', Str::limit($project->description, 150))

@section('content')
    <article class="pt-32 pb-24">
        {{-- Breadcrumb & Back --}}
        <div class="mx-auto max-w-7xl px-6 lg:px-8 mb-8">
            <nav class="flex items-center gap-2 text-xs text-surface-200/50">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('projects.index') }}" class="hover:text-white transition-colors">Projects</a>
                <span>/</span>
                <span class="text-white font-medium truncate">{{ $project->title }}</span>
            </nav>
        </div>

        {{-- Hero Header --}}
        <header class="mx-auto max-w-7xl px-6 lg:px-8 mb-12">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="inline-flex rounded-lg bg-brand-500/15 border border-brand-500/30 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-brand-300">
                    {{ $project->category }}
                </span>
                @if($project->is_featured)
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-accent-500/15 border border-accent-500/30 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-accent-300">
                    ★ Featured Project
                </span>
                @endif
                @if($project->metric)
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/[0.04] border border-white/[0.08] px-3 py-1 text-xs font-medium text-emerald-400">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    {{ $project->metric }}
                </span>
                @endif
            </div>

            <h1 class="font-display text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                {{ $project->title }}
            </h1>

            <div class="mt-6 flex flex-wrap items-center gap-4 pt-6 border-t border-white/[0.08]">
                @if($project->live_url)
                <a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="btn-primary !py-2.5 !px-5 !text-xs flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Launch Live Demo
                </a>
                @endif

                @if($project->github_url)
                <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="btn-outline !py-2.5 !px-5 !text-xs flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                    View Source on GitHub
                </a>
                @endif

                <a href="{{ route('projects.index') }}" class="text-xs text-surface-200/50 hover:text-white transition-colors ml-auto">
                    &larr; Back to all projects
                </a>
            </div>
        </header>

        {{-- Featured Image Showcase --}}
        <div class="mx-auto max-w-7xl px-6 lg:px-8 mb-16">
            <div class="glass-card overflow-hidden p-2 ring-1 ring-white/[0.1] shadow-2xl">
                <div class="aspect-[16/9] w-full rounded-2xl overflow-hidden bg-surface-900 relative">
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        {{-- Case Study Content & Specifications Grid --}}
        <div class="mx-auto max-w-7xl px-6 lg:px-8 grid gap-12 lg:grid-cols-3">
            
            {{-- Main Content (2 cols) --}}
            <div class="lg:col-span-2 space-y-10">
                <section class="glass-card p-8">
                    <h2 class="font-display text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Project Overview
                    </h2>
                    <p class="text-base text-surface-200/70 leading-relaxed whitespace-pre-line">
                        {{ $project->description }}
                    </p>
                </section>

                <section class="glass-card p-8">
                    <h2 class="font-display text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Architecture &amp; Engineering Highlights
                    </h2>
                    <ul class="space-y-3 text-sm text-surface-200/60">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Clean MVC Pattern:</strong> Strict separation of concerns with domain services, form request validation, and lean controllers.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Database Optimization:</strong> Indexed relational queries, eager loading prevention of N+1 bottlenecks, and automated migrations.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Robust Security:</strong> Full CSRF protection, input sanitization, prepared SQL statements, and secure authentication tokens.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-accent-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Responsive Frontend:</strong> Fluid mobile-first user interface with smooth transitions and high Core Web Vitals score.</span>
                        </li>
                    </ul>
                </section>
            </div>

            {{-- Sidebar Specs (1 col) --}}
            <div class="space-y-6">
                <div class="glass-card p-6">
                    <h3 class="font-display text-sm font-bold text-white uppercase tracking-wider mb-4 pb-3 border-b border-white/[0.08]">
                        Technical Specification
                    </h3>

                    <dl class="space-y-4 text-xs">
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Category</dt>
                            <dd class="text-white font-medium capitalize mt-0.5">{{ $project->category }}</dd>
                        </div>
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Primary Architecture</dt>
                            <dd class="text-white font-medium mt-0.5">Laravel MVC &bull; MySQL Relational</dd>
                        </div>
                        @if($project->metric)
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Key Benchmark</dt>
                            <dd class="text-accent-400 font-semibold mt-0.5">{{ $project->metric }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-surface-200/40 uppercase font-semibold">Tech Stack Breakdown</dt>
                            <dd class="mt-2 flex flex-wrap gap-1.5">
                                @foreach($project->tech_stack as $tech)
                                <span class="tech-badge !text-[11px] !px-2.5 !py-1">{{ $tech }}</span>
                                @endforeach
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-8 pt-6 border-t border-white/[0.08]">
                        <a href="{{ route('contact.index') }}" class="btn-primary w-full !text-xs justify-center">
                            Hire Us for Similar Project
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Related Projects --}}
        @if($relatedProjects->isNotEmpty())
        <section class="mx-auto max-w-7xl px-6 lg:px-8 mt-24 pt-16 border-t border-white/[0.08]">
            <h2 class="font-display text-2xl font-bold text-white mb-8">Related Projects</h2>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($relatedProjects as $rel)
                <a href="{{ route('projects.show', $rel->slug) }}" class="glass-card group overflow-hidden block hover:border-brand-500/30 transition-all">
                    <div class="aspect-[16/10] overflow-hidden bg-surface-900">
                        <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h3 class="font-display text-base font-bold text-white group-hover:text-brand-300 transition-colors">{{ $rel->title }}</h3>
                        <p class="mt-1 text-xs text-surface-200/50 line-clamp-2">{{ $rel->description }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    </article>
@endsection
