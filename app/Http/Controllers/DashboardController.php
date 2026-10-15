<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;

/**
 * Admin dashboard: overview metrics and inquiry management.
 */
class DashboardController extends Controller
{
    /**
     * Dashboard overview with key metrics.
     */
    public function index()
    {
        $stats = [
            'total_projects'     => Project::count(),
            'featured_projects'  => Project::featured()->count(),
            'total_skills'        => Skill::count(),
            'total_messages'     => Message::count(),
            'unread_messages'    => Message::unread()->count(),
        ];

        $recentMessages = Message::latest()->take(5)->get();
        $recentProjects = Project::latest()->take(5)->get();
        $recentSkills   = Skill::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentProjects', 'recentSkills'));
    }

    /**
     * View all contact messages / inquiries inbox.
     */
    public function messages()
    {
        $messages = Message::latest()->paginate(20);

        return view('admin.messages', compact('messages'));
    }

    /**
     * Show a single message and mark as read.
     */
    public function showMessage(Message $message)
    {
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.message-show', compact('message'));
    }

    /**
     * Delete a message.
     */
    public function destroyMessage(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages')
            ->with('success', 'Message deleted successfully.');
    }
}
