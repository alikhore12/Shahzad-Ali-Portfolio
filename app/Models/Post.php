<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use GeneratesSlug;

    protected $fillable = ['title', 'slug', 'category', 'excerpt', 'body', 'cover_image', 'status', 'published_at'];

    protected $casts = ['published_at' => 'datetime'];

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
