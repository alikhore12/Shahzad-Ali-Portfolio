@extends('layouts.admin')

@section('title', 'Experience')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Experience" eyebrow="Journey" subtitle="Roles and work history shown on your experience timeline.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.experiences.create') }}" icon="plus">Add experience</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @if($experiences->total() === 0)
            <x-admin.empty title="No experience entries yet" text="Add your first role to start building your timeline." icon="activity" :action-href="route('admin.experiences.create')" action-label="Add experience" />
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Company</th>
                            <th>Period</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($experiences as $experience)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        <span>
                                            <strong>{{ $experience->title }}</strong>
                                            <span class="sub">{{ \Illuminate\Support\Str::limit($experience->description, 70) }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $experience->company ?: '—' }}</td>
                                <td class="mono-cell">{{ $experience->period ?: '—' }}</td>
                                <td class="mono-cell">{{ $experience->sort_order }}</td>
                                <td><x-admin.badge :tone="$experience->published ? 'live' : 'draft'" :label="$experience->published ? 'Visible' : 'Hidden'" /></td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.experiences.edit', $experience) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.experiences.destroy', $experience) }}" data-confirm="This experience entry will be permanently removed.">
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

            {{ $experiences->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
