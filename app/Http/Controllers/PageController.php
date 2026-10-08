<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Service;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Certification;
use App\Models\SocialLink;
use App\Models\ContactMessage;

class PageController extends Controller
{
    public function home()
    {
        $skills = Skill::take(6)->get();
        $projects = Project::take(6)->get();
        $services = Service::take(6)->get();

        return view('pages.home', [
            'skills' => $skills,
            'projects' => $projects,
            'services' => $services,
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function skills()
    {
        $skills = Skill::all();
        return view('pages.skills', ['skills' => $skills]);
    }

    public function projects()
    {
        $projects = Project::all();
        return view('pages.projects', ['projects' => $projects]);
    }

    public function projectDetail($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('pages.project-detail', ['project' => $project]);
    }

    public function services()
    {
        $services = Service::all();
        return view('pages.services', ['services' => $services]);
    }

    public function experience()
    {
        $experiences = Experience::all();
        return view('pages.experience', ['experiences' => $experiences]);
    }

    public function education()
    {
        $educations = Education::all();
        return view('pages.education', ['educations' => $educations]);
    }

    public function resume()
    {
        return view('pages.resume');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function storeContact()
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Message sent successfully! I will get back to you soon.');
    }
}