@extends('layouts.admin')

@section('title', 'Messages')
@section('eyebrow', 'Inbox')

@section('content')
    <x-admin.page-head title="Contact Messages" eyebrow="Inbox" subtitle="Notes sent through your public contact form.">
        <x-slot:actions>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('admin.contact-messages.read-all') }}">
                    @csrf
                    @method('PATCH')
                    <x-admin.btn type="submit" variant="secondary" icon="check">Mark all read</x-admin.btn>
                </form>
            @endif
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @include('admin.partials.filters', ['search' => $search, 'categories' => null, 'statusParam' => 'filter', 'statusOptions' => ['unread' => 'Unread only']])

        @if($messages->total() === 0)
            @if(request()->hasAny(['q', 'filter']))
                <x-admin.empty title="No messages match your filters" text="Try a different search term or clear the filters." icon="search" />
            @else
                <x-admin.empty title="No messages yet" text="Messages from your contact form will land here — you will also see unread counts in the sidebar." icon="inbox" :action-href="route('home')" action-label="View your website" />
            @endif
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Subject</th>
                            <th>Received</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        <span class="avatar-fallback">{{ strtoupper(substr($message->name, 0, 1)) }}</span>
                                        <span>
                                            <strong>{{ $message->name }}</strong>
                                            <span class="sub">{{ $message->email }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($message->subject ?: 'No subject', 60) }}</td>
                                <td class="mono-cell">{{ $message->created_at->format('M j, Y H:i') }}</td>
                                <td><x-admin.badge :tone="$message->isUnread() ? 'unread' : 'draft'" :label="$message->isUnread() ? 'Unread' : 'Read'" /></td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.contact-messages.show', $message) }}" title="View"><x-admin.icon name="eye" /></a>
                                        <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" data-confirm="This message from {{ $message->name }} will be permanently deleted.">
                                            @csrf
                                            @method('DELETE')
                                            <button class="row-btn is-danger" type="submit" title="Delete"><x-admin.icon name="trash" /></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $messages->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
