@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="font-display text-2xl font-bold text-white tracking-tight">Dashboard Overview</h1>
        <p class="mt-1 text-sm text-surface-200/50">Welcome back to the Shahzad Labs control center. Here's a summary of your portfolio activity.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 mb-8">
        {{-- Total Projects --}}
        <div class="glass-card p-5 group hover:border-brand-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Projects</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500/10 text-brand-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-6A1.125 1.125 0 012.25 11.625v-4.5z"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-white">{{ $stats['total_projects'] }}</p>
            <span class="text-[11px] text-surface-200/40">{{ $stats['featured_projects'] }} featured</span>
        </div>

        {{-- Total Skills --}}
        <div class="glass-card p-5 group hover:border-accent-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Skills</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-accent-500/10 text-accent-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-white">{{ $stats['total_skills'] }}</p>
            <span class="text-[11px] text-accent-400/80">Tech stack active</span>
        </div>

        {{-- Total Inquiries --}}
        <div class="glass-card p-5 group hover:border-purple-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Messages</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-purple-500/10 text-purple-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-white">{{ $stats['total_messages'] }}</p>
            <span class="text-[11px] text-surface-200/40">Inbound leads</span>
        </div>

        {{-- Unread Inquiries --}}
        <div class="glass-card p-5 group hover:border-amber-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Unread</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold {{ $stats['unread_messages'] > 0 ? 'text-amber-400' : 'text-white' }}">{{ $stats['unread_messages'] }}</p>
            <span class="text-[11px] text-surface-200/40">Requires review</span>
        </div>

        {{-- System Health --}}
        <div class="glass-card p-5 group hover:border-emerald-500/40 transition-colors">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-surface-200/50 uppercase tracking-wider">Health</span>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                </div>
            </div>
            <p class="mt-3 text-3xl font-display font-bold text-emerald-400">100%</p>
            <span class="text-[11px] text-surface-200/40">App operational</span>
        </div>
    </div>

    {{-- Content Columns --}}
    <div class="grid gap-6 lg:grid-cols-3">
        
        {{-- Recent Projects (2 Columns on large) --}}
        <div class="glass-card p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/[0.08]">
                <div>
                    <h2 class="font-display text-lg font-bold text-white">Recent Projects</h2>
                    <p class="text-xs text-surface-200/40">Latest additions to your portfolio showcase</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.projects.create') }}" class="btn-primary !py-1.5 !px-3 !text-[11px]">+ Add</a>
                    <a href="{{ route('admin.projects.index') }}" class="text-xs text-brand-400 hover:text-brand-300">View All →</a>
                </div>
            </div>

            <div class="space-y-3">
                @forelse($recentProjects as $proj)
                <div class="flex items-center justify-between p-3 rounded-xl bg-white/[0.02] border border-white/[0.06] hover:border-white/[0.12] transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="h-12 w-16 shrink-0 rounded-lg overflow-hidden bg-surface-900 border border-white/[0.08]">
                            <img src="{{ $proj->image_url }}" alt="{{ $proj->title }}" class="h-full w-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold text-white truncate">{{ $proj->title }}</h3>
                            <div class="flex items-center gap-2 text-xs text-surface-200/40 mt-0.5">
                                <span class="capitalize">{{ $proj->category }}</span>
                                <span>&bull;</span>
                                <span>{{ count($proj->tech_stack) }} tech tags</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($proj->is_featured)
                        <span class="hidden sm:inline-block text-[10px] font-semibold uppercase px-2 py-0.5 rounded-full bg-accent-500/10 text-accent-400 border border-accent-500/20">Featured</span>
                        @endif
                        <a href="{{ route('admin.projects.edit', $proj) }}" class="p-1.5 rounded-lg text-surface-200/50 hover:text-white hover:bg-white/[0.05] transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-sm text-surface-200/40 text-center py-6">No projects created yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Sidebar Column: Skills & Recent Messages --}}
        <div class="space-y-6">
            
            {{-- Skills Summary Widget --}}
            <div class="glass-card p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/[0.08]">
                    <h2 class="font-display text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Top Skills
                    </h2>
                    <a href="{{ route('admin.skills.index') }}" class="text-xs text-brand-400 hover:text-brand-300">Manage →</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentSkills as $sk)
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <span>{{ $sk->icon ?: '⚡' }}</span>
                            <span class="font-medium text-white">{{ $sk->name }}</span>
                        </div>
                        <span class="font-mono text-brand-400 font-semibold">{{ $sk->proficiency }}%</span>
                    </div>
                    <div class="h-1.5 w-full rounded-full bg-surface-900 overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-brand-500 to-accent-400" style="width: {{ $sk->proficiency }}%;"></div>
                    </div>
                    @empty
                    <p class="text-xs text-surface-200/40 text-center py-4">No skills added yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Recent Messages Widget --}}
            <div class="glass-card p-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/[0.08]">
                    <h2 class="font-display text-sm font-bold text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Inquiries Inbox
                    </h2>
                    <a href="{{ route('admin.messages') }}" class="text-xs text-brand-400 hover:text-brand-300">View All →</a>
                </div>

                <div class="space-y-2.5">
                    @forelse($recentMessages as $msg)
                    <a href="{{ route('admin.messages.show', $msg) }}" class="block p-2.5 rounded-xl bg-white/[0.02] border border-white/[0.06] hover:bg-white/[0.04] transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium {{ $msg->is_read ? 'text-surface-200/60' : 'text-white font-semibold' }} truncate">{{ $msg->name }}</span>
                            <span class="text-[10px] text-surface-200/40">{{ $msg->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-xs text-surface-200/50 truncate mt-0.5">{{ $msg->subject }}</div>
                    </a>
                    @empty
                    <p class="text-xs text-surface-200/40 text-center py-4">No messages received yet.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
@endsection
