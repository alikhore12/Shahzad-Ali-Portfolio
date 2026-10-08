<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\PortfolioProject;
use App\Models\PortfolioService;
use App\Models\PortfolioSkill;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PortfolioController extends Controller
{
    private function portfolioProjects(): array
    {
        if (PortfolioProject::query()->exists()) {
            return PortfolioProject::where('published', true)->get()->keyBy('slug')->map(fn ($p) => array_merge($p->toArray(), ['role' => 'Product design & full-stack development']))->all();
        }
        return [
            'portfolio-os' => ['slug' => 'portfolio-os', 'name' => 'Portfolio OS', 'category' => 'Laravel', 'description' => 'A thoughtful portfolio system with a content-first interface and a fast Laravel foundation.', 'tags' => ['Laravel', 'MySQL', 'Blade'], 'accent' => 'coral', 'year' => '2026', 'role' => 'Product design & full-stack development', 'body' => 'Portfolio OS is a focused personal publishing system designed to make work, thinking and contact information easy to explore. The Laravel foundation keeps content structured while the editorial interface gives every case study room to breathe.', 'features' => ['Responsive editorial interface', 'Reusable Blade components', 'SEO-ready page structure', 'Contact messages stored in MySQL']],
            'local-growth-lab' => ['slug' => 'local-growth-lab', 'name' => 'Local Growth Lab', 'category' => 'SEO', 'description' => 'A practical SEO toolkit for turning local search intent into measurable website growth.', 'tags' => ['SEO', 'Analytics', 'PHP'], 'accent' => 'teal', 'year' => '2026', 'role' => 'SEO strategy & interface concept', 'body' => 'Local Growth Lab turns a messy search optimisation process into a calm, repeatable workflow. It brings technical checks, content opportunities and local search signals into one clear working space.', 'features' => ['Technical SEO checklist', 'Local keyword research flow', 'Content opportunity notes', 'Performance-minded output']],
            'commerce-studio' => ['slug' => 'commerce-studio', 'name' => 'Commerce Studio', 'category' => 'JavaScript', 'description' => 'A clean web application concept balancing conversion, performance and a calm shopping experience.', 'tags' => ['JavaScript', 'UX', 'API'], 'accent' => 'amber', 'year' => '2026', 'role' => 'UX direction & front-end build', 'body' => 'Commerce Studio explores how a store can feel useful instead of noisy. Clear hierarchy, lightweight interactions and a flexible component system help customers move from discovery to decision with less friction.', 'features' => ['Product discovery flow', 'Accessible responsive components', 'API-ready data structure', 'Progressive enhancement']],
        ];
    }

    private function servicesData(): array
    {
        if (PortfolioService::query()->exists()) {
            return PortfolioService::where('published', true)->get()->keyBy('slug')->map(fn ($s) => $s->toArray())->all();
        }
        return [
            'full-stack-web-development' => ['name' => 'Full-stack web development', 'intro' => 'Reliable Laravel applications, APIs and database-backed experiences.', 'details' => 'I can help shape a web product from its first routes and data model through to a responsive, accessible interface.', 'points' => ['Laravel and PHP application structure', 'MySQL database-backed features', 'REST API integration', 'Responsive Blade interfaces']],
            'laravel-development' => ['name' => 'Laravel development', 'intro' => 'Structured PHP applications with clean routes, models and Blade views.', 'details' => 'Laravel is the centre of my backend toolkit. I focus on readable architecture, secure forms and interfaces that are easy to maintain.', 'points' => ['MVC architecture', 'Eloquent models and migrations', 'Validation and CSRF protection', 'Reusable Blade components']],
            'responsive-web-design' => ['name' => 'Responsive web design', 'intro' => 'Interfaces that feel considered on phones, tablets and large screens.', 'details' => 'Every layout starts with content hierarchy and continues through accessible HTML, thoughtful spacing and practical responsive behaviour.', 'points' => ['Mobile-first layouts', 'Semantic accessible markup', 'Interaction and visual hierarchy', 'Performance-aware CSS']],
            'wordpress-websites' => ['name' => 'WordPress websites', 'intro' => 'Flexible, maintainable websites for teams who need to move quickly.', 'details' => 'I build clean WordPress experiences that balance editable content with a considered, brand-aware front end.', 'points' => ['Theme customisation', 'Content structure', 'Responsive templates', 'SEO-friendly page setup']],
            'seo-optimisation' => ['name' => 'SEO optimisation', 'intro' => 'Technical, local and on-page SEO foundations that help good work get found.', 'details' => 'SEO works best when it is part of the build. I focus on useful content, crawlable structure and a clear understanding of search intent.', 'points' => ['Technical SEO checks', 'On-page optimisation', 'Local SEO foundations', 'Keyword and content research']],
            'performance-improvements' => ['name' => 'Performance improvements', 'intro' => 'Faster loading, clearer code and a better experience for everyone.', 'details' => 'A fast website is more usable and more discoverable. I look for practical improvements that reduce friction without losing character.', 'points' => ['Asset and image awareness', 'Efficient CSS and JavaScript', 'Core Web Vitals thinking', 'Clean page structure']],
        ];
    }

    private function skillsData(): array
    {
        if (PortfolioSkill::query()->exists()) {
            return PortfolioSkill::where('published', true)->get()->keyBy('slug')->map(fn ($s) => array_merge($s->toArray(), ['group' => $s->category]))->all();
        }
        return [
            'html5' => ['name' => 'HTML5', 'group' => 'Frontend', 'intro' => 'Semantic, accessible structure for the web.', 'details' => 'I use HTML as the meaningful foundation of every interface, with heading hierarchy, labels, landmarks and descriptive content.', 'points' => ['Semantic elements', 'Accessible forms', 'SEO-friendly structure']],
            'css3' => ['name' => 'CSS3', 'group' => 'Frontend', 'intro' => 'Responsive visual systems with clarity and restraint.', 'details' => 'I enjoy translating design systems into layouts that are flexible, responsive and comfortable to use.', 'points' => ['Responsive layouts', 'Design tokens', 'Transitions and states']],
            'javascript' => ['name' => 'JavaScript', 'group' => 'Frontend', 'intro' => 'Lightweight interactions that make interfaces feel alive.', 'details' => 'I use JavaScript where it adds useful feedback or interaction, keeping the page fast and understandable.', 'points' => ['DOM interactions', 'Filtering and navigation', 'Progressive enhancement']],
            'php' => ['name' => 'PHP', 'group' => 'Backend', 'intro' => 'The language behind my server-side foundation.', 'details' => 'PHP gives me a practical way to build dynamic, database-backed experiences and understand what happens behind the interface.', 'points' => ['Object-oriented programming', 'Form handling', 'Server-side logic']],
            'laravel' => ['name' => 'Laravel', 'group' => 'Backend', 'intro' => 'My main framework for structured web applications.', 'details' => 'Laravel helps me build quickly without giving up clarity, security or a strong separation of concerns.', 'points' => ['Routing and controllers', 'Eloquent and migrations', 'Blade and validation']],
            'seo' => ['name' => 'SEO', 'group' => 'Digital marketing', 'intro' => 'Helping useful websites become easier to discover.', 'details' => 'I approach SEO as a mix of technical quality, useful content and understanding what people are really trying to find.', 'points' => ['Technical SEO', 'Keyword research', 'On-page optimisation']],
        ];
    }

    private function page(string $title, string $description, string $view, array $data = [])
    {
        return view('portfolio.' . $view, array_merge(compact('title', 'description'), $data));
    }

    public function home()
    {
        return view('portfolio.home', ['projects' => array_values($this->portfolioProjects())]);
    }

    public function about() { return $this->page('About Shahzad Ali', 'Learn about Shahzad Ali, a BS Computer Science student and full-stack developer.', 'about'); }
    public function skills() { return $this->page('Skills & toolkit', 'Explore Shahzad Ali’s frontend, backend, CMS, SEO and development tools.', 'skills'); }
    public function services() { return $this->page('Services', 'Web development, WordPress, UI/UX and SEO services by Shahzad Ali.', 'services'); }
    public function serviceDetail(string $slug) { abort_unless(isset($this->servicesData()[$slug]), 404); return $this->page($this->servicesData()[$slug]['name'], $this->servicesData()[$slug]['intro'], 'item', ['item' => $this->servicesData()[$slug], 'type' => 'Service']); }
    public function skillDetail(string $slug) { abort_unless(isset($this->skillsData()[$slug]), 404); return $this->page($this->skillsData()[$slug]['name'], $this->skillsData()[$slug]['intro'], 'item', ['item' => $this->skillsData()[$slug], 'type' => $this->skillsData()[$slug]['group'] . ' skill']); }
    public function experience() { return $this->page('Experience & journey', 'An honest overview of Shahzad Ali’s education and development journey.', 'experience'); }
    public function education() { return $this->page('Education', 'Education and current learning path of Shahzad Ali.', 'education'); }
    public function contactPage() { return $this->page('Contact Shahzad Ali', 'Start a conversation about a web project, product idea or SEO challenge.', 'contact'); }
    public function projects()
    {
        return $this->page('Selected projects', 'Explore selected Laravel, JavaScript and SEO projects by Shahzad Ali.', 'projects', ['projects' => array_values($this->portfolioProjects())]);
    }
    public function project(string $slug)
    {
        abort_unless(isset($this->portfolioProjects()[$slug]), 404);
        return $this->page($this->portfolioProjects()[$slug]['name'], $this->portfolioProjects()[$slug]['description'], 'project', ['project' => $this->portfolioProjects()[$slug]]);
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'], 'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:180'], 'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);
        ContactMessage::create($data);
        return back()->with('success', 'Thanks — your message is on its way. I’ll get back to you soon.');
    }

    public function resume()
    {
        return Response::streamDownload(function () {
            echo "SHAHZAD ALI\nFull-Stack Web Developer\n\nLaravel • PHP • JavaScript • WordPress • SEO\n\nProfessional summary\nBS Computer Science student building thoughtful, responsive web products.\n\nContact\nReplace this placeholder with your email and social links.\n";
        }, 'shahzad-ali-cv.txt', ['Content-Type' => 'text/plain']);
    }

    public function sitemap()
    {
        return response()->view('portfolio.sitemap')->header('Content-Type', 'application/xml');
    }
}
