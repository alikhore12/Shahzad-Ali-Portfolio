@extends('layouts.admin')

@section('title', 'Skills')
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Skills" eyebrow="Portfolio" subtitle="Skills power the dedicated skills page of your site.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.skills.create') }}" icon="plus">Add skill</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @include('admin.partials.filters', ['search' => $search, 'categories' => $categories])

        @if($skills->total() === 0)
            @if(request()->hasAny(['q', 'status', 'category']))
                <x-admin.empty title="No skills match your filters" text="Try a different search term or clear the filters." icon="search" />
            @else
                <x-admin.empty title="No skills yet" text="Add your first skill — categories group them on the public page." icon="code" :action-href="route('admin.skills.create')" action-label="Add a skill" />
            @endif
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Skill</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Added</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skills as $skill)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        <span>
                                            <strong>{{ $skill->name }}</strong>
                                            <span class="sub">{{ \Illuminate\Support\Str::limit($skill->intro, 70) }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $skill->category ?: '—' }}</td>
                                <td><x-admin.badge :tone="$skill->published ? 'live' : 'draft'" :label="$skill->published ? 'Published' : 'Draft'" /></td>
                                <td class="mono-cell">{{ $skill->created_at?->format('M j, Y') ?? '—' }}</td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.skills.edit', $skill) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" data-confirm="“{{ $skill->name }}” will be removed from your skills page.">
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

            {{ $skills->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
