@extends('layouts.admin')

@section('title', 'Certifications')
@section('eyebrow', 'Journey')

@section('content')
    <x-admin.page-head title="Certifications" eyebrow="Journey" subtitle="Certificates and credentials with optional verification links.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.certifications.create') }}" icon="plus">Add certification</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @if($certifications->total() === 0)
            <x-admin.empty title="No certifications yet" text="Add certificates to showcase your verified skills." icon="award" :action-href="route('admin.certifications.create')" action-label="Add certification" />
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Certification</th>
                            <th>Issuer</th>
                            <th>Year</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certifications as $certification)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        <span>
                                            <strong>{{ $certification->name }}</strong>
                                            @if($certification->url)
                                                <span class="sub">{{ \Illuminate\Support\Str::limit($certification->url, 50) }}</span>
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $certification->issuer ?: '—' }}</td>
                                <td class="mono-cell">{{ $certification->year ?: '—' }}</td>
                                <td class="mono-cell">{{ $certification->sort_order }}</td>
                                <td><x-admin.badge :tone="$certification->published ? 'live' : 'draft'" :label="$certification->published ? 'Visible' : 'Hidden'" /></td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.certifications.edit', $certification) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.certifications.destroy', $certification) }}" data-confirm="This certification will be permanently removed.">
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

            {{ $certifications->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
