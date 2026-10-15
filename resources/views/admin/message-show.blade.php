@extends('admin.layout')
@section('title', $message->subject)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.messages') }}" class="inline-flex items-center gap-1.5 text-sm text-surface-200/50 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Messages
        </a>
    </div>

    <div class="glass-card p-8 max-w-3xl">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="font-display text-xl font-bold text-white">{{ $message->subject }}</h1>
                <p class="mt-1 text-sm text-surface-200/40">{{ $message->created_at->format('M d, Y \a\t h:i A') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-400/60 hover:text-red-400 transition-colors border border-red-500/20 rounded-lg px-3 py-1.5 hover:bg-red-500/10">
                    Delete
                </button>
            </form>
        </div>

        <div class="mt-6 flex items-center gap-4 rounded-xl bg-white/[0.03] border border-white/[0.06] p-4">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-500/15 text-sm font-bold text-brand-400">
                {{ strtoupper(substr($message->name, 0, 2)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-white">{{ $message->name }}</p>
                <a href="mailto:{{ $message->email }}" class="text-xs font-mono text-brand-400 hover:text-brand-300">{{ $message->email }}</a>
            </div>
        </div>

        <div class="mt-6 prose prose-invert prose-sm max-w-none">
            <div class="whitespace-pre-wrap text-sm text-surface-200/70 leading-relaxed">{{ $message->message }}</div>
        </div>

        <div class="mt-8 pt-6 border-t border-white/[0.06]">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="btn-primary !text-xs">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                Reply via Email
            </a>
        </div>
    </div>
@endsection
