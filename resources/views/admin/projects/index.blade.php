@extends('layouts.admin')

@section('title', 'Projects')
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Projects" eyebrow="Portfolio" subtitle="The case studies that power your public portfolio.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.projects.create') }}" icon="plus">New project</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @include('admin.partials.filters', ['search' => $search, 'categories' => $categories])

        @if($projects->total() === 0)
            @if(request()->hasAny(['q', 'status', 'category']))
                <x-admin.empty
                    title="No projects match your filters"
                    text="Try a different search term or clear the filters to see everything again."
                    icon="search"
                />
            @else
                <x-admin.empty
                    title="No projects yet"
                    text="Create your first case study and it will appear on your portfolio."
                    icon="folder"
                    :action-href="route('admin.projects.create')"
                    action-label="Create a project"
                />
            @endif
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Added</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        @if($project->image_url)
                                            <img class="thumb" src="{{ filter_var($project->image_url, FILTER_VALIDATE_URL) ? $project->image_url : asset($project->image_url) }}" alt="{{ $project->name }}">
                                        @else
                                            <span class="thumb-fallback"><x-admin.icon name="image" /></span>
                                        @endif
                                        <span>
                                            <strong>{{ $project->name }}</strong>
                                            <span class="sub">/{{ $project->slug }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $project->category ?: '—' }}</td>
                                <td><x-admin.badge :tone="$project->published ? 'live' : 'draft'" :label="$project->published ? 'Published' : 'Draft'" /></td>
                                <td class="mono-cell">{{ $project->created_at?->format('M j, Y') ?? '—' }}</td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.projects.edit', $project) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" data-confirm="“{{ $project->name }}” and its public page will be permanently removed.">
                                            @csrf
                                            @method('DELETE')
                                            <button class="row-btn is-danger" type="submit" title="Delete"><x-admin.icon name="trash" /></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $projects->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
