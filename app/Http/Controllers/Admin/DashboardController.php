<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\PortfolioProject;
use App\Models\PortfolioService;
use App\Models\PortfolioSkill;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            ['key' => 'projects', 'label' => 'Total Projects', 'value' => PortfolioProject::count(), 'detail' => PortfolioProject::where('published', true)->count().' published', 'route' => 'admin.projects.index', 'icon' => 'folder', 'tone' => 'coral'],
            ['key' => 'skills', 'label' => 'Total Skills', 'value' => PortfolioSkill::count(), 'detail' => PortfolioSkill::where('published', true)->count().' published', 'route' => 'admin.skills.index', 'icon' => 'code', 'tone' => 'teal'],
            ['key' => 'services', 'label' => 'Services', 'value' => PortfolioService::count(), 'detail' => PortfolioService::where('published', true)->count().' live on site', 'route' => 'admin.services.index', 'icon' => 'briefcase', 'tone' => 'amber'],
            ['key' => 'posts', 'label' => 'Blog Posts', 'value' => Post::count(), 'detail' => Post::where('status', 'published')->count().' published', 'route' => 'admin.posts.index', 'icon' => 'file', 'tone' => 'coral'],
            ['key' => 'testimonials', 'label' => 'Testimonials', 'value' => Testimonial::count(), 'detail' => Testimonial::where('published', true)->count().' showing', 'route' => 'admin.testimonials.index', 'icon' => 'star', 'tone' => 'teal'],
            ['key' => 'messages', 'label' => 'Contact Messages', 'value' => ContactMessage::count(), 'detail' => ContactMessage::whereNull('read_at')->count().' unread', 'route' => 'admin.contact-messages.index', 'icon' => 'mail', 'tone' => 'amber'],
        ];

        $recentProjects = PortfolioProject::latest()->take(5)->get();

        $recentMessages = ContactMessage::latest()->take(5)->get();

        $unreadMessages = ContactMessage::whereNull('read_at')->count();

        $messagesByMonth = $this->messagesByMonth();

        $breakdownCounts = [
            ['label' => 'Projects', 'value' => PortfolioProject::count(), 'route' => 'admin.projects.index'],
            ['label' => 'Skills', 'value' => PortfolioSkill::count(), 'route' => 'admin.skills.index'],
            ['label' => 'Services', 'value' => PortfolioService::count(), 'route' => 'admin.services.index'],
            ['label' => 'Blog posts', 'value' => Post::count(), 'route' => 'admin.posts.index'],
            ['label' => 'Testimonials', 'value' => Testimonial::count(), 'route' => 'admin.testimonials.index'],
        ];

        $breakdownMax = max(1, max(array_column($breakdownCounts, 'value')));
        $tones = ['coral', 'teal', 'amber', 'coral', 'teal'];

        $contentBreakdown = collect($breakdownCounts)->map(function ($item, $index) use ($breakdownMax, $tones) {
            return [
                'label' => $item['label'],
                'value' => $item['value'],
                'route' => $item['route'],
                'percent' => (int) round($item['value'] / $breakdownMax * 100),
                'tone' => $tones[$index % count($tones)],
            ];
        })->all();

        $hasContent = PortfolioProject::exists() || PortfolioSkill::exists() || PortfolioService::exists();

        return view('admin.dashboard', compact(
            'stats',
            'recentProjects',
            'recentMessages',
            'unreadMessages',
            'messagesByMonth',
            'contentBreakdown',
            'hasContent'
        ));
    }

    private function messagesByMonth(): array
    {
        $months = collect(range(5, 0))->map(fn ($offset) => Carbon::now()->subMonths($offset));

        return $months->map(function ($month) {
            return [
                'label' => $month->format('M'),
                'value' => ContactMessage::whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])->count(),
            ];
        })->all();
    }
}
