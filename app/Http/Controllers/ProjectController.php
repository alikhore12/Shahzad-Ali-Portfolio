<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Full CRUD resource controller for managing portfolio projects.
 */
class ProjectController extends Controller
{
    /**
     * List all projects (admin view).
     */
    public function index()
    {
        $projects = Project::displayOrder()->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show create project form.
     */
    public function create()
    {
        return view('admin.projects.form', [
            'project' => new Project(),
            'editing' => false,
        ]);
    }

    /**
     * Store a new project.
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['tech_stack'] = array_map('trim', explode(',', $data['tech_stack']));
        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (env('VERCEL') || isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
                $mime = $file->getMimeType() ?: 'image/jpeg';
                $data['image'] = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            } else {
                $data['image'] = $file->store('projects', 'public');
            }
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        unset($data['image_url']);
        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Show edit project form.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.form', [
            'project' => $project,
            'editing' => true,
        ]);
    }

    /**
     * Update an existing project.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['tech_stack'] = array_map('trim', explode(',', $data['tech_stack']));
        $data['slug'] = Str::slug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if (env('VERCEL') || isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
                $mime = $file->getMimeType() ?: 'image/jpeg';
                $data['image'] = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            } else {
                if ($project->image && !str_starts_with($project->image, 'http') && !str_starts_with($project->image, 'data:image')) {
                    Storage::disk('public')->delete($project->image);
                }
                $data['image'] = $file->store('projects', 'public');
            }
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        unset($data['image_url']);
        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Delete a project.
     */
    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
