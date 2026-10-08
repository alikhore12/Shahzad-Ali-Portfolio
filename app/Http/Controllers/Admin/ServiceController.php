<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\PortfolioService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = PortfolioService::query()->latest();

        $search = trim((string) $request->query('q'));
        if ($search !== '') {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('intro', 'like', "%{$search}%"));
        }

        if (in_array($request->query('status'), ['published', 'draft'], true)) {
            $query->where('published', $request->query('status') === 'published');
        }

        $services = $query->paginate(10)->withQueryString();

        return view('admin.services.index', compact('services', 'search'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = PortfolioService::makeSlug(($data['slug'] ?? '') ?: $data['name']);

        PortfolioService::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(PortfolioService $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, PortfolioService $service)
    {
        $data = $this->validated($request, $service);
        $data['slug'] = PortfolioService::makeSlug(($data['slug'] ?? '') ?: $data['name'], $service->id);

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(PortfolioService $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    private function validated(Request $request, ?PortfolioService $service = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160', 'alpha_dash', 'unique:portfolio_services,slug'.($service ? ','.$service->id : '')],
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
