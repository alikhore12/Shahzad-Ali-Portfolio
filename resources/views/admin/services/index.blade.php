@extends('layouts.admin')

@section('title', 'Services')
@section('eyebrow', 'Portfolio')

@section('content')
    <x-admin.page-head title="Services" eyebrow="Portfolio" subtitle="What you offer, shown on your services page.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.services.create') }}" icon="plus">Add service</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @include('admin.partials.filters', ['search' => $search])

        @if($services->total() === 0)
            @if(request()->hasAny(['q', 'status']))
                <x-admin.empty title="No services match your filters" text="Try a different search term or clear the filters." icon="search" />
            @else
                <x-admin.empty title="No services yet" text="List the services you offer so clients know where you can help." icon="briefcase" :action-href="route('admin.services.create')" action-label="Add a service" />
            @endif
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Added</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        <span>
                                            <strong>{{ $service->name }}</strong>
                                            <span class="sub">{{ \Illuminate\Support\Str::limit($service->intro, 80) }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td><x-admin.badge :tone="$service->published ? 'live' : 'draft'" :label="$service->published ? 'Published' : 'Draft'" /></td>
                                <td class="mono-cell">{{ $service->created_at?->format('M j, Y') ?? '—' }}</td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.services.edit', $service) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" data-confirm="“{{ $service->name }}” will be removed from your services page.">
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

            {{ $services->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
