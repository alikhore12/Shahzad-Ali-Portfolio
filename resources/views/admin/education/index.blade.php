@extends('layouts.admin')

@section('title', 'Education')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Education" eyebrow="Journey" subtitle="School and degrees shown on your education section.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.education.create') }}" icon="plus">Add education</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @if($educations->total() === 0)
            <x-admin.empty title="No education entries yet" text="Add your first degree or course to start your education section." icon="graduation" :action-href="route('admin.education.create')" action-label="Add education" />
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Institution</th>
                            <th>Degree</th>
                            <th>Period</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($educations as $education)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        <span>
                                            <strong>{{ $education->institution }}</strong>
                                            <span class="sub">{{ \Illuminate\Support\Str::limit($education->description, 70) }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $education->degree }}</td>
                                <td class="mono-cell">{{ $education->period ?: '—' }}</td>
                                <td class="mono-cell">{{ $education->sort_order }}</td>
                                <td><x-admin.badge :tone="$education->published ? 'live' : 'draft'" :label="$education->published ? 'Visible' : 'Hidden'" /></td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.education.edit', $education) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.education.destroy', $education) }}" data-confirm="This education entry will be permanently removed.">
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

            {{ $educations->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
