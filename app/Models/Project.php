<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'description',
        'thumbnail_url',
        'banner_image_url',
        'live_url',
        'client_name',
        'timeline',
        'completed_at',
        'tech_stack',
        'is_featured',
    ];

    protected $casts = [
        'tech_stack' => 'array',
    ];

    protected $appends = [
        'shortTechStack',
    ];

    public function getShortTechStackAttribute()
    {
        $stack = $this->tech_stack ?? [];
        return array_slice($stack, 0, 3);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->latest('completed_at');
    }
}