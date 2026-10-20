@extends('admin.layout')
@section('title', 'Messages')

@section('content')
    <div class="flex items-center justify-between mb-8"
         x-data="{
            modalOpen: false,
            replyId: null,
            replyName: '',
            replyEmail: '',
            replySubject: '',
            replyOriginal: '',
            replyBody: '',
            replyAction: '',
            openReply(msg) {
                this.replyId = msg.id;
                this.replyName = msg.name;
                this.replyEmail = msg.email;
                this.replySubject = 'Re: ' + msg.subject;
                this.replyOriginal = msg.message;
                this.replyBody = 'Hi ' + msg.name + ',\n\nThank you for reaching out to Shahzad Labs regarding \"' + msg.subject + '\".\n\n';
                this.replyAction = '/admin/messages/' + msg.id + '/reply';
                this.modalOpen = true;
            }
         }"
         @keydown.escape.window="modalOpen = false">

        <div>
            <h1 class="font-display text-2xl font-bold text-white">Messages Inbox</h1>
            <p class="mt-1 text-sm text-surface-200/50">Contact form inquiries from visitors with direct reply capabilities.</p>
        </div>

        {{-- Top Summary Badges --}}
        <div class="flex items-center gap-2">
            <span class="text-xs px-3 py-1 rounded-full bg-white/[0.04] border border-white/[0.08] text-surface-200/60">
                Total: {{ $messages->total() }}
            </span>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             MESSAGES TABLE
        ═══════════════════════════════════════════════════════════ --}}
        <div class="glass-card overflow-hidden w-full mt-6 col-span-full">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/[0.06] bg-white/[0.01]">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">From</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">Subject &amp; Inquiry</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-surface-200/40">Date</th>
                            <th class="px-6 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-surface-200/40">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04]">
                        @forelse($messages as $msg)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            {{-- Status Badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($msg->is_replied)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Replied
                                </span>
                                @elseif(!$msg->is_read)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-ping"></span>
                                    New
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-medium bg-white/[0.04] text-surface-200/60 border border-white/[0.08]">
                                    Read
                                </span>
                                @endif
                            </td>

                            {{-- Sender --}}
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold {{ $msg->is_read ? 'text-surface-200/70' : 'text-white' }}">{{ $msg->name }}</p>
                                <a href="mailto:{{ $msg->email }}" class="text-xs text-brand-400/80 hover:text-brand-300 font-mono">{{ $msg->email }}</a>
                            </td>

                            {{-- Subject & Snippet --}}
                            <td class="px-6 py-4 max-w-md">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="text-sm font-medium {{ $msg->is_read ? 'text-surface-200/80' : 'text-white font-semibold' }} hover:text-brand-300 transition-colors block truncate">
                                    {{ $msg->subject }}
                                </a>
                                <p class="text-xs text-surface-200/40 truncate mt-0.5">{{ Str::limit($msg->message, 80) }}</p>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 text-xs text-surface-200/40 whitespace-nowrap">
                                <div>{{ $msg->created_at->format('M d, Y') }}</div>
                                <div class="text-[10px] text-surface-200/30">{{ $msg->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Direct Reply Button --}}
                                    <a href="{{ route('admin.messages.show', $msg) }}#reply-box"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-500 hover:bg-brand-600 text-white transition-all shadow-sm shadow-brand-500/20"
                                       title="Reply to message">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        <span>Reply</span>
                                    </a>

                                    {{-- 1-Click Gmail --}}
                                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($msg->email) }}&su={{ urlencode('Re: ' . $msg->subject) }}"
                                       target="_blank" rel="noopener"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-400 hover:text-red-300 border border-red-500/20 hover:bg-red-500/10 transition-colors"
                                       title="Open in Gmail Web">
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                        <span>Gmail</span>
                                    </a>

                                    <a href="{{ route('admin.messages.show', $msg) }}"
                                       class="px-2.5 py-1.5 text-xs text-surface-200/50 hover:text-white transition-colors"
                                       title="View Full Thread">
                                        View
                                    </a>

                                    <form method="POST" action="{{ route('admin.messages.destroy', $msg) }}" class="inline" onsubmit="return confirm('Delete this message?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-2 py-1.5 text-xs text-red-400/50 hover:text-red-400 transition-colors" title="Delete">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
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

        {{-- ═══════════════════════════════════════════════════════════
             QUICK REPLY POPUP MODAL (ALPINE.JS)
        ═══════════════════════════════════════════════════════════ --}}
        <div x-show="modalOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
             style="display: none;">
            
            <div class="glass-card w-full max-w-xl p-6 sm:p-7 border border-white/[0.12] shadow-2xl relative"
                 @click.outside="modalOpen = false">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/[0.08]">
                    <div class="flex items-center gap-2.5">
                        <div class="h-8 w-8 rounded-lg bg-brand-500/15 flex items-center justify-center text-brand-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-base font-bold text-white">Direct Reply</h3>
                            <p class="text-xs text-surface-200/50">Replying to <span class="text-white font-medium" x-text="replyName"></span> (<span x-text="replyEmail" class="font-mono text-brand-400"></span>)</p>
                        </div>
                    </div>
                    <button type="button" @click="modalOpen = false" class="text-surface-200/50 hover:text-white p-1 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Original Message Preview Snippet --}}
                <div class="mb-4 p-3 rounded-xl bg-surface-950/70 border border-white/[0.04]">
                    <span class="text-[10px] uppercase tracking-wider font-semibold text-surface-200/40 block mb-1">Inquiry Snippet:</span>
                    <p class="text-xs text-surface-200/70 italic line-clamp-3" x-text="replyOriginal"></p>
                </div>

                {{-- Direct Reply Form --}}
                <form :action="replyAction" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-surface-200/70 mb-1">Subject *</label>
                        <input type="text" name="subject" required x-model="replySubject"
                               class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-3.5 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-surface-200/70 mb-1">Response Message *</label>
                        <textarea name="reply_body" required rows="6" x-model="replyBody"
                                  class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-3.5 py-2.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20 resize-none"
                                  placeholder="Type your official reply message here..."></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="modalOpen = false" class="px-4 py-2 text-xs text-surface-200/60 hover:text-white">Cancel</button>
                        <button type="submit" class="btn-primary !text-xs !py-2.5 !px-5 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                            </svg>
                            <span>Send Email Reply</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
