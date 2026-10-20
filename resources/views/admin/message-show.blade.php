@extends('admin.layout')
@section('title', 'Inquiry: ' . $message->subject)

@section('content')
    {{-- Top Navigation & Status Bar --}}
    <div class="mb-6 flex items-center justify-between max-w-3xl mx-auto">
        <a href="{{ route('admin.messages') }}" class="inline-flex items-center gap-1.5 text-sm text-surface-200/50 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to All Messages
        </a>

        @if($message->is_replied)
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-400 border border-emerald-500/20">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Replied {{ $message->replied_at ? $message->replied_at->diffForHumans() : '' }}
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-400 border border-amber-500/20">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                Awaiting Reply
            </span>
        @endif
    </div>

    {{-- Main Inquiry Card (Single Centered Column matching current live layout) --}}
    <div class="glass-card p-6 sm:p-8 max-w-3xl mx-auto space-y-6"
         x-data="{
             formOpen: false,
             replySubject: 'Re: {{ addslashes($message->subject) }}',
             replyText: '',
             submitting: false,
             openForm() {
                 this.formOpen = true;
                 this.$nextTick(() => {
                     const textarea = document.getElementById('reply-body-input');
                     if (textarea) textarea.focus();
                     const formBox = document.getElementById('reply-composer-form');
                     if (formBox) formBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                 });
             },
             toggleForm() {
                 this.formOpen = !this.formOpen;
                 if (this.formOpen) {
                     this.openForm();
                 }
             },
             setTemplate(type) {
                 if (type === 'thanks') {
                     this.replyText = 'Hi {{ addslashes($message->name) }},\n\nThank you for reaching out to Shahzad Labs! We have received your inquiry regarding \"{{ addslashes($message->subject) }}\".\n\nOur team would love to discuss your project requirements in detail. What is your preferred time for a quick discovery chat?';
                 } else if (type === 'quote') {
                     this.replyText = 'Hi {{ addslashes($message->name) }},\n\nThanks for contacting us! To provide you with an accurate scope and quotation for your project, could you please share a few more details regarding your target timeline and specific feature requirements?\n\nLooking forward to collaborating with you.';
                 } else if (type === 'whatsapp') {
                     this.replyText = 'Hi {{ addslashes($message->name) }},\n\nThank you for your message! You can also connect with me directly on WhatsApp at +92 310 5447307 for instant project coordination and discussions.\n\nBest regards,\nShahzad Ali';
                 }
             }
         }">

        {{-- Header: Subject & Actions --}}
        <div class="flex items-start justify-between pb-6 border-b border-white/[0.08]">
            <div>
                <span class="text-[11px] font-semibold uppercase tracking-wider text-brand-400">Inbound Inquiry #{{ $message->id }}</span>
                <h1 class="font-display text-xl sm:text-2xl font-bold text-white mt-1">{{ $message->subject }}</h1>
                <p class="mt-1 text-xs text-surface-200/40">Received {{ $message->created_at->format('M d, Y \a\t h:i A') }} ({{ $message->created_at->diffForHumans() }})</p>
            </div>

            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Permanently delete this inquiry?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-red-400/60 hover:text-red-400 transition-colors border border-red-500/20 rounded-lg px-3 py-1.5 hover:bg-red-500/10" title="Delete Message">
                    Delete
                </button>
            </form>
        </div>

        {{-- Sender Information Badge --}}
        <div class="flex items-center justify-between rounded-xl bg-white/[0.03] border border-white/[0.06] p-4">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr from-brand-500/20 to-accent-400/20 text-sm font-bold text-brand-300 border border-brand-500/30">
                    {{ strtoupper(substr($message->name, 0, 2)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ $message->name }}</p>
                    <a href="mailto:{{ $message->email }}" class="text-xs font-mono text-brand-400 hover:text-brand-300 transition-colors">{{ $message->email }}</a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($message->email) }}&su={{ urlencode('Re: ' . $message->subject) }}"
                   target="_blank" rel="noopener"
                   class="text-xs text-red-400/80 hover:text-red-300 transition-colors flex items-center gap-1 rounded-lg px-2.5 py-1 bg-red-500/10 border border-red-500/20"
                   title="Open in Gmail">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    <span>Gmail</span>
                </a>
            </div>
        </div>

        {{-- Message Content Body --}}
        <div class="pt-2">
            <h3 class="text-xs font-semibold uppercase tracking-wider text-surface-200/40 mb-2">Message Content:</h3>
            <div class="rounded-xl bg-surface-950/60 border border-white/[0.04] p-5 text-sm text-surface-200/90 leading-relaxed whitespace-pre-wrap font-sans select-text">
                {{ $message->message }}
            </div>
        </div>

        {{-- Action Bar: Prominent "Reply via Email" Button (Exact button requested by user) --}}
        <div class="pt-6 border-t border-white/[0.08] flex flex-wrap items-center justify-between gap-3">
            <button type="button"
                    id="btn-reply-toggle"
                    @click="toggleForm()"
                    class="btn-primary !text-xs !py-2.5 !px-5 inline-flex items-center gap-2 shadow-lg shadow-brand-500/20 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                <span x-text="formOpen ? 'Hide Reply Form' : 'Reply via Email'">Reply via Email</span>
            </button>

            <a href="https://wa.me/923105447307?text={{ urlencode('Hi ' . $message->name . ', regarding your message on Shahzad Labs: ' . $message->subject) }}"
               target="_blank" rel="noopener"
               class="text-xs text-emerald-400 hover:text-emerald-300 inline-flex items-center gap-1.5 transition-colors font-medium rounded-lg px-3 py-2 bg-emerald-500/10 border border-emerald-500/20">
                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>WhatsApp Message</span>
            </a>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             EXPANDABLE REPLY COMPOSER FORM (Opens when button is clicked)
        ═══════════════════════════════════════════════════════════ --}}
        <div id="reply-composer-form"
             x-show="formOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2 scale-98"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-2 scale-98"
             class="rounded-2xl border border-brand-500/30 bg-surface-900/90 p-5 sm:p-7 shadow-2xl space-y-5"
             style="display: none;">

            <div class="flex items-center justify-between pb-3 border-b border-white/[0.08]">
                <div class="flex items-center gap-2">
                    <span class="flex h-2 w-2 rounded-full bg-brand-400 animate-ping"></span>
                    <h2 class="font-display text-sm font-bold text-white uppercase tracking-wider">
                        Compose Direct Reply
                    </h2>
                </div>
                <button type="button" @click="formOpen = false" class="text-xs text-surface-200/50 hover:text-white transition-colors">
                    ✕ Close
                </button>
            </div>

            {{-- Quick Templates --}}
            <div>
                <span class="block text-[11px] font-semibold text-surface-200/50 uppercase tracking-wider mb-2">Quick Insert Templates:</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="setTemplate('thanks')" class="text-xs rounded-lg px-2.5 py-1 bg-white/[0.04] hover:bg-brand-500/20 hover:text-brand-300 text-surface-200/70 border border-white/[0.06] transition-colors">
                        + Thank You & Call
                    </button>
                    <button type="button" @click="setTemplate('quote')" class="text-xs rounded-lg px-2.5 py-1 bg-white/[0.04] hover:bg-brand-500/20 hover:text-brand-300 text-surface-200/70 border border-white/[0.06] transition-colors">
                        + Scope & Quote
                    </button>
                    <button type="button" @click="setTemplate('whatsapp')" class="text-xs rounded-lg px-2.5 py-1 bg-white/[0.04] hover:bg-emerald-500/20 hover:text-emerald-300 text-surface-200/70 border border-white/[0.06] transition-colors">
                        + WhatsApp Invite
                    </button>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.messages.reply', $message) }}" @submit="submitting = true" class="space-y-4">
                @csrf

                {{-- Recipient info display --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-surface-200/60 mb-1">To (Recipient)</label>
                        <div class="rounded-xl border border-white/[0.08] bg-white/[0.02] px-3.5 py-2 text-xs text-white/90 font-mono truncate">
                            {{ $message->name }} &lt;{{ $message->email }}&gt;
                        </div>
                    </div>

                    <div>
                        <label for="reply-subject-input" class="block text-xs font-medium text-surface-200/60 mb-1">Email Subject *</label>
                        <input type="text" id="reply-subject-input" name="subject" required
                               x-model="replySubject"
                               class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] px-3.5 py-2 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                        @if(!empty($errors) && $errors->has('subject')) <p class="mt-1 text-[11px] text-red-400">{{ $errors->first('subject') }}</p> @endif
                    </div>
                </div>

                {{-- Reply Message Body --}}
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="reply-body-input" class="block text-xs font-medium text-surface-200/60">Your Reply Message *</label>
                        <span class="text-[11px] text-surface-200/40" x-text="replyText.length + ' characters'"></span>
                    </div>
                    <textarea id="reply-body-input" name="reply_body" required rows="8"
                              x-model="replyText"
                              class="w-full rounded-xl border border-white/[0.08] bg-white/[0.03] p-3.5 text-xs text-white placeholder-surface-200/30 focus:border-brand-500/50 focus:outline-none focus:ring-2 focus:ring-brand-500/20 font-sans leading-relaxed"
                              placeholder="Assalam-o-Alaikum / Hi {{ $message->name }},&#10;&#10;Type your reply message here..."></textarea>
                    @if(!empty($errors) && $errors->has('reply_body')) <p class="mt-1 text-[11px] text-red-400">{{ $errors->first('reply_body') }}</p> @endif
                </div>

                {{-- Action Buttons --}}
                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <button type="submit" :disabled="submitting"
                            class="btn-primary !text-xs !py-2.5 !px-6 justify-center flex items-center gap-2 shadow-lg shadow-brand-500/25">
                        <template x-if="!submitting">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                                </svg>
                                <span>Send Reply via Email</span>
                            </span>
                        </template>
                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Sending Reply...</span>
                            </span>
                        </template>
                    </button>

                    <div class="flex items-center gap-2">
                        {{-- 1-Click Open In Gmail --}}
                        <a :href="'https://mail.google.com/mail/?view=cm&fs=1&to=' + encodeURIComponent('{{ $message->email }}') + '&su=' + encodeURIComponent(replySubject) + '&body=' + encodeURIComponent(replyText)"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 border border-red-500/25 px-4 py-2.5 text-xs font-semibold transition-all">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            <span>Open in Gmail</span>
                        </a>

                        <button type="button" @click="formOpen = false" class="btn-outline !text-xs !py-2.5 !px-4">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>

    {{-- Sent Replies History Thread (If any replies were sent) --}}
    @if($message->replies && $message->replies->isNotEmpty())
    <div class="glass-card p-6 sm:p-8 max-w-3xl mx-auto mt-6">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/[0.08]">
            <h2 class="font-display text-sm font-bold text-white flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                Sent Replies History ({{ $message->replies->count() }})
            </h2>
            <span class="text-[11px] text-surface-200/40">Delivered to {{ $message->email }}</span>
        </div>

        <div class="space-y-4">
            @foreach($message->replies as $reply)
            <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/5 p-4.5 space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="font-semibold text-white flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Sent by {{ $reply->user?->name ?? 'Admin' }}
                    </span>
                    <span class="text-surface-200/40 text-[11px]">{{ $reply->created_at->format('M d, Y \a\t h:i A') }}</span>
                </div>
                <div class="text-xs font-medium text-emerald-300">
                    Subject: {{ $reply->subject }}
                </div>
                <div class="text-xs text-surface-200/80 whitespace-pre-wrap leading-relaxed pt-2 border-t border-white/[0.04] font-sans">
                    {{ $reply->reply_body }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Fallback Vanilla JS Script to guarantee form opens on click even if Alpine is delayed --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnToggle = document.getElementById('btn-reply-toggle');
            const formBox = document.getElementById('reply-composer-form');
            const textarea = document.getElementById('reply-body-input');

            if (btnToggle && formBox) {
                btnToggle.addEventListener('click', function () {
                    // Check if Alpine didn't already handle it
                    setTimeout(function() {
                        if (formBox.style.display === 'none' || getComputedStyle(formBox).display === 'none') {
                            formBox.style.display = 'block';
                            if (textarea) textarea.focus();
                            formBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                        }
                    }, 50);
                });
            }
        });
    </script>
@endsection
