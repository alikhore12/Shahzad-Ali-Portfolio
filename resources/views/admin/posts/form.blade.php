@php
    $post = $post ?? null;
@endphp

<form method="POST" action="{{ $action }}" data-loading enctype="multipart/form-data">
    @csrf
    @if($method ?? null)@method($method)@endif

    @if($post)
        <input type="hidden" name="cover_image" value="{{ old('cover_image', $post->cover_image) }}">
    @endif

    <div class="card">
        <div class="card-body">
            <div class="form-grid">
                <x-admin.input name="title" label="Title" :value="$post?->title" placeholder="A better contact form in Laravel" required />

                <x-admin.input name="slug" label="Slug" :value="$post?->slug" placeholder="auto-generated from the title" hint="URL: /blog/your-slug" optional />

                <x-admin.input name="category" label="Category" :value="$post?->category" placeholder="e.g. Tutorials" optional />

                <x-admin.select name="status" label="Status" :value="$post?->status ?? 'draft'" :options="['draft' => 'Draft', 'published' => 'Published']" hint="Published posts need a date" />

                <div class="full">
                    <x-admin.textarea name="excerpt" label="Excerpt" :value="$post?->excerpt" :rows="2" placeholder="Shown in post listings" optional />
                </div>

                <div class="full">
                    <x-admin.textarea name="body" label="Body" :value="$post?->body" :rows="14" placeholder="Write your article — plain paragraphs work best" required tall />
                </div>

                <x-admin.input name="published_at" label="Publish date" type="date" :value="$post?->published_at?->format('Y-m-d')" optional />

                <x-admin.upload name="cover_image" label="Cover image" :current="$post?->cover_image" />

                <div class="full muted">Drafts can be saved without a date — publishing without one uses today.</div>
            </div>

            <div class="form-actions">
                <x-admin.btn type="submit" icon="check">{{ $post ? 'Save changes' : 'Create post' }}</x-admin.btn>
                <x-admin.btn href="{{ route('admin.posts.index') }}" variant="ghost">Cancel</x-admin.btn>
            </div>
        </div>
    </div>
</form>
