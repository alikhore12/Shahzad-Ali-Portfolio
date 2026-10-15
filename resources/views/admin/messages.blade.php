@extends('admin.layout')
@section('title', 'Messages')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-2xl font-bold text-white">Messages Inbox</h1>
            <p class="mt-1 text-sm text-surface-200/50">Contact form inquiries from visitors.</p>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/[0.06]">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">From</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-surface-200/40">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/[0.04]">
                    @forelse($messages as $msg)
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            @if($msg->is_read)
                            <span class="inline-flex h-2 w-2 rounded-full bg-surface-700"></span>
                            @else
                            <span class="inline-flex h-2 w-2 rounded-full bg-brand-500 shadow-sm shadow-brand-500/50"></span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium {{ $msg->is_read ? 'text-surface-200/60' : 'text-white' }}">{{ $msg->name }}</p>
                            <p class="text-xs text-surface-200/40 font-mono">{{ $msg->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.messages.show', $msg) }}" class="text-sm {{ $msg->is_read ? 'text-surface-200/60' : 'text-white font-medium' }} hover:text-brand-400 transition-colors">
                                {{ $msg->subject }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-xs text-surface-200/40">{{ $msg->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="text-xs text-brand-400 hover:text-brand-300 transition-colors">View</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" class="inline" onsubmit="return confirm('Delete this message?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-red-400/60 hover:text-red-400 transition-colors">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-sm text-surface-200/40">No messages received yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
        <div class="border-t border-white/[0.06] px-6 py-4">
            {{ $messages->links() }}
        </div>
        @endif
    </div>
@endsection
