@extends('layouts.admin')

@section('title', 'Blog')
@section('eyebrow', 'Content')

@section('content')
    <x-admin.page-head title="Blog / Articles" eyebrow="Content" subtitle="Long-form writing published to your site.">
        <x-slot:actions>
            <x-admin.btn href="{{ route('admin.posts.create') }}" icon="plus">New post</x-admin.btn>
        </x-slot:actions>
    </x-admin.page-head>

    <x-admin.card :flush="true">
        @include('admin.partials.filters', ['search' => $search])

        @if($posts->total() === 0)
            @if(request()->hasAny(['q', 'status']))
                <x-admin.empty title="No posts match your filters" text="Try a different search term or clear the filters." icon="search" />
            @else
                <x-admin.empty title="No posts yet" text="Write your first article — it appears on your blog once published." icon="file" :action-href="route('admin.posts.create')" action-label="Write a post" />
            @endif
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <div class="cell-title">
                                        @if($post->cover_image)
                                            <img class="thumb" src="{{ filter_var($post->cover_image, FILTER_VALIDATE_URL) ? $post->cover_image : asset($post->cover_image) }}" alt="{{ $post->title }}">
                                        @else
                                            <span class="thumb-fallback"><x-admin.icon name="file" /></span>
                                        @endif
                                        <span>
                                            <strong>{{ $post->title }}</strong>
                                            <span class="sub">/{{ $post->slug }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $post->category ?: '—' }}</td>
                                <td><x-admin.badge :tone="$post->status === 'published' ? 'live' : 'draft'" :label="$post->status === 'published' ? 'Published' : 'Draft'" /></td>
                                <td class="mono-cell">{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                                <td>
                                    <div class="cell-actions">
                                        <a class="row-btn" href="{{ route('admin.posts.edit', $post) }}" title="Edit"><x-admin.icon name="edit" /></a>
                                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" data-confirm="“{{ $post->title }}” will be permanently removed from your blog.">
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

            {{ $posts->links('admin.pagination') }}
        @endif
    </x-admin.card>
@endsection
