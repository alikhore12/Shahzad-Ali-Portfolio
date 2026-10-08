<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\PortfolioProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        $query = Project::ordered();

        if ($category) {
            $query->byCategory($category);
        }

        $projects = $query->paginate(12);

        // Invalidate cache when projects change
        Cache::forever('projects_index_data', $projects->items());

        return view('projects.index', [
            'projects' => $projects,
            'currentCategory' => $category,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            // Prefer projects from the same category, then fill remaining slots.
            $relatedProjects = Project::where('category', $project->category)
                ->where('id', '!=', $project->id)
                ->latest('completed_at')
                ->take(3)
                ->get();

            if ($relatedProjects->count() < 3) {
                $relatedProjects = $relatedProjects
                    ->concat(Project::where('id', '!=', $project->id)
                        ->whereNotIn('id', $relatedProjects->pluck('id'))
                        ->latest('completed_at')
                        ->take(3 - $relatedProjects->count())
                        ->get())
                    ->values();
            }
        } else {
            // The homepage uses portfolio_projects (CV Builder, Think Code, MCMS).
            // Adapt those records to the detail view so their slugs also resolve.
            $source = PortfolioProject::where('slug', $slug)->where('published', true)->firstOrFail();
            $project = (object) [
                'title' => $source->name,
                'slug' => $source->slug,
                'category' => $source->category,
                'excerpt' => $source->description,
                'description' => $source->body ?: $source->description,
                'thumbnail_url' => $source->image_url,
                'banner_image_url' => $source->image_url,
                'live_url' => $source->live_url,
                'github_url' => $source->github_url,
                'client_name' => null,
                'timeline' => null,
                'completed_at' => $source->year,
                'tech_stack' => $source->tags ?? [],
                'gallery' => $source->gallery ?? [],
            ];

            $relatedProjects = PortfolioProject::where('published', true)
                ->where('slug', '!=', $slug)
                ->latest()
                ->take(3)
                ->get()
                ->map(fn ($related) => (object) [
                    'title' => $related->name,
                    'slug' => $related->slug,
                    'excerpt' => $related->description,
                    'thumbnail_url' => $related->image_url,
                    'banner_image_url' => $related->image_url,
                ]);
        }

        return view('projects.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }
}
