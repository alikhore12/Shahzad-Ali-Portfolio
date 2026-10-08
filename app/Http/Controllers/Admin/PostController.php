<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = Post::query()->latest('published_at')->latest('id');

        $search = trim((string) $request->query('q'));
        if ($search !== '') {
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%"));
        }

        if (in_array($request->query('status'), ['published', 'draft'], true)) {
            $query->where('status', $request->query('status'));
        }

        $posts = $query->paginate(10)->withQueryString();

        return view('admin.posts.index', compact('posts', 'search'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Post::create([
            'title' => $data['title'],
            'slug' => Post::makeSlug(($data['slug'] ?? '') ?: $data['title']),
            'category' => $data['category'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $data['body'],
            'cover_image' => $request->hasFile('cover_image')
                ? $this->storeUpload($request->file('cover_image'), 'uploads/posts')
                : ($data['cover_image'] ?? null),
            'status' => $data['status'],
            'published_at' => $data['status'] === 'published'
                ? Carbon::parse($data['published_at'] ?? null) ?? now()
                : null,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);

        $coverImage = $post->cover_image;
        if ($request->hasFile('cover_image')) {
            $this->removeUpload($post->cover_image);
            $coverImage = $this->storeUpload($request->file('cover_image'), 'uploads/posts');
        } elseif (array_key_exists('cover_image', $data)) {
            $coverImage = $data['cover_image'];
        }

        $publishedAt = null;
        if ($data['status'] === 'published') {
            $publishedAt = ! empty($data['published_at'])
                ? Carbon::parse($data['published_at'])
                : ($post->published_at ?? now());
        }

        $post->update([
            'title' => $data['title'],
            'slug' => Post::makeSlug(($data['slug'] ?? '') ?: $data['title'], $post->id),
            'category' => $data['category'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $data['body'],
            'cover_image' => $coverImage,
            'status' => $data['status'],
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $this->removeUpload($post->cover_image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Blog post deleted.');
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $coverRule = $request->hasFile('cover_image')
            ? ['nullable', 'image', 'max:4096']
            : ['nullable', 'string', 'max:300'];

        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', 'alpha_dash', 'unique:posts,slug'.($post ? ','.$post->id : '')],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string', 'max:60000'],
            'cover_image' => $coverRule,
            'status' => ['required', 'in:draft,published'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
