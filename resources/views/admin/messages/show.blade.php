@extends('layouts.admin')

@section('title', 'Message')
@section('eyebrow', 'Inbox')

@section('content')
    <x-admin.page-head title="Message from {{ $message->name }}" eyebrow="Inbox" subtitle="Received {{ $message->created_at->format('M j, Y \a\t H:i') }}">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.contact-messages.index') }}" variant="secondary" icon="arrow-right">Back to inbox</x-admin.btn>

            @if($message->isUnread())
                <form method="POST" action="{{ route('admin.contact-messages.read', $message) }}">
                    @csrf
                    @method('PATCH')
                    <x-admin.btn type="submit" variant="soft" icon="check">Mark as read</x-admin.btn>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" data-confirm="This message will be permanently deleted.">
                @csrf
                @method('DELETE')
                <x-admin.btn type="submit" variant="danger" icon="trash">Delete</x-admin.btn>
            </form>
        </x-slot:actions>
    </x-admin.page-head>

    <div class="grid-3-2">
        <x-admin.card :flush="true">
            <div class="card-body">
                <div class="message-meta">
                    <span class="avatar-fallback">{{ strtoupper(substr($message->name, 0, 1)) }}</span>
                    <span class="who">
                        <strong>{{ $message->name }}</strong>
                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                    </span>
                    @if($message->isUnread())
                        <x-admin.badge tone="unread" label="Unread" />
                    @else
                        <x-admin.badge tone="draft" label="Read" />
                    @endif
                    <span class="when">{{ $message->created_at->format('M j, Y · H:i') }}</span>
                </div>

                <div class="message-body">{{ $message->message }}</div>
            </div>
        </x-admin.card>

        <div class="stack">
            <x-admin.card title="Details">
                <div class="info-list">
                    <div class="info-item">
                        <span>From</span>
                        <strong>{{ $message->name }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Email</span>
                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                    </div>
                    <div class="info-item">
                        <span>Subject</span>
                        <strong>{{ $message->subject ?: 'No subject' }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Received</span>
                        <strong>{{ $message->created_at->format('M j, Y · H:i') }}</strong>
                    </div>
                    <div class="info-item">
                        <span>Status</span>
                        <strong>{{ $message->isUnread() ? 'Unread' : 'Read'.($message->read_at ? ' · '.$message->read_at->format('M j, Y') : '') }}</strong>
                    </div>
                </div>
            </x-admin.card>

            <x-admin.card title="Reply">
                <p class="muted">Replies are sent from your own inbox — this one opens your mail app with the details filled in.</p>
                <div class="form-actions" style="margin-top: 16px;">
                    <x-admin.btn href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->subject ?: 'Your message')) }}" variant="primary" icon="send">Reply by email</x-admin.btn>
                </div>
            </x-admin.card>
        </div>
    </div>
@endsection
