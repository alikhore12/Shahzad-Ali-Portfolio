<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::query()->latest();

        if ($request->query('filter') === 'unread') {
            $query->whereNull('read_at');
        }

        $search = trim((string) $request->query('q'));
        if ($search !== '') {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('subject', 'like', "%{$search}%"));
        }

        $messages = $query->paginate(10)->withQueryString();
        $unreadCount = ContactMessage::whereNull('read_at')->count();

        return view('admin.messages.index', compact('messages', 'unreadCount', 'search'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->read_at === null) {
            $message->update(['read_at' => now()]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['read_at' => now()]);

        return back()->with('success', 'Message marked as read.');
    }

    public function markAllRead()
    {
        ContactMessage::whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('success', 'All messages marked as read.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted.');
    }
}
