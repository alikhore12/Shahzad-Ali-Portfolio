<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = PortfolioProject::query()->latest();

        $search = trim((string) $request->query('q'));
        if ($search !== '') {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%"));
        }

        if (in_array($request->query('status'), ['published', 'draft'], true)) {
            $query->where('published', $request->query('status') === 'published');
        }

        $projects = $query->paginate(10)->withQueryString();
        $categories = PortfolioProject::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.projects.index', compact('projects', 'categories', 'search'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = PortfolioProject::makeSlug(($data['slug'] ?? '') ?: $data['name']);
        $data['image_url'] = $this->storeUpload($request->file('image'), 'uploads/projects');

        PortfolioProject::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit(PortfolioProject $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, PortfolioProject $project)
    {
        $data = $this->validated($request, $project);
        $data['slug'] = PortfolioProject::makeSlug(($data['slug'] ?? '') ?: $data['name'], $project->id);

        if ($image = $request->file('image')) {
            $this->removeUpload($project->image_url);
            $data['image_url'] = $this->storeUpload($image, 'uploads/projects');
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(PortfolioProject $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
    }

    private function validated(Request $request, ?PortfolioProject $project = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160', 'alpha_dash', 'unique:portfolio_projects,slug'.($project ? ','.$project->id : '')],
            'category' => ['required', 'string', 'max:80'],
            'year' => ['nullable', 'string', 'regex:/^[0-9]{4}$/'],
            'accent' => ['nullable', 'in:coral,teal,amber'],
            'description' => ['required', 'string', 'max:500'],
            'body' => ['nullable', 'string', 'max:20000'],
            'tags' => ['nullable', 'string', 'max:1000'],
            'features' => ['nullable', 'string', 'max:4000'],
            'github_url' => ['nullable', 'string', 'max:300'],
            'live_url' => ['nullable', 'string', 'max:300'],
            'image' => ['nullable', 'image', 'max:4096'],
            'published' => ['sometimes', 'boolean'],
        ]);

        return $this->present($data);
    }

    private function present(array $data): array
    {
        $data['published'] = ! empty($data['published']);
        $data['tags'] = $this->lines($data['tags'] ?? null);
        $data['features'] = $this->lines($data['features'] ?? null);
        $data['accent'] = ($data['accent'] ?? '') ?: 'coral';
        unset($data['image']);

        return $data;
    }
}
