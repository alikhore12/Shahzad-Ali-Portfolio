@extends('layouts.admin')

@section('title', 'Testimonials')
@section('eyebrow', 'Content')

@section('content')
    <x-admin.page-head title="Testimonials" eyebrow="Content" subtitle="Kind words from people you have worked with.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.testimonials.create') }}" icon="plus">Add testimonial</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @include('admin.partials.filters', ['showSearch' => false])

        @if($testimonials->total() === 0)
            @if(request()->hasAny(['status']))
                <x-admin.empty title="No testimonials with that status" text="Clear the filter to see all of your testimonials." icon="search" />
            @else
                <x-admin.empty title="No testimonials yet" text="Add a quote from a client, teammate or professor." icon="star" :action-href="route('admin.testimonials.create')" action-label="Add testimonial" />
            @endif
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Person</th>
                            <th>Quote</th>
                            <th>Rating</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testimonial)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        <span>
                                            <strong>{{ $testimonial->name }}</strong>
                                            <span class="sub">{{ $testimonial->role ?: '—' }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td style="max-width: 340px;">{{ \Illuminate\Support\Str::limit($testimonial->quote, 110) }}</td>
                                <td class="mono-cell">{{ str_repeat('★', (int) $testimonial->rating).str_repeat('☆', 5 - (int) $testimonial->rating) }}</td>
                                <td class="mono-cell">{{ $testimonial->sort_order }}</td>
                                <td><x-admin.badge :tone="$testimonial->published ? 'live' : 'draft'" :label="$testimonial->published ? 'Showing' : 'Hidden'" /></td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.testimonials.edit', $testimonial) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" data-confirm="This testimonial will be permanently removed.">
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

            {{ $testimonials->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
