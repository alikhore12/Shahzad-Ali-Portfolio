<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\PortfolioSkill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = PortfolioSkill::query()->orderBy('category')->latest();

        $search = trim((string) $request->query('q'));
        if ($search !== '') {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%"));
        }

        if (in_array($request->query('status'), ['published', 'draft'], true)) {
            $query->where('published', $request->query('status') === 'published');
        }

        $skills = $query->paginate(10)->withQueryString();
        $categories = PortfolioSkill::query()->select('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.skills.index', compact('skills', 'categories', 'search'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = PortfolioSkill::makeSlug(($data['slug'] ?? '') ?: $data['name']);

        PortfolioSkill::create($data);

        return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
    }

    public function edit(PortfolioSkill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, PortfolioSkill $skill)
    {
        $data = $this->validated($request, $skill);
        $data['slug'] = PortfolioSkill::makeSlug(($data['slug'] ?? '') ?: $data['name'], $skill->id);

        $skill->update($data);

        return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
    }

    public function destroy(PortfolioSkill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted.');
    }

    private function validated(Request $request, ?PortfolioSkill $skill = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['nullable', 'string', 'max:140', 'alpha_dash', 'unique:portfolio_skills,slug'.($skill ? ','.$skill->id : '')],
            'category' => ['required', 'string', 'max:80'],
            'intro' => ['required', 'string', 'max:300'],
            'details' => ['nullable', 'string', 'max:10000'],
            'points' => ['nullable', 'string', 'max:4000'],
            'published' => ['sometimes', 'boolean'],
        ]);

        $data['published'] = ! empty($data['published']);
        $data['points'] = $this->lines($data['points'] ?? null);

        return $data;
    }
}
