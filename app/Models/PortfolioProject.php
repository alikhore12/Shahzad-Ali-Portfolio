<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesSlug;
class PortfolioProject extends Model
{
    use GeneratesSlug;
    protected $fillable = ['name','slug','category','description','body','tags','features','accent','year','published','github_url','live_url','image_url','gallery'];
    protected $casts = ['tags' => 'array', 'features' => 'array', 'gallery' => 'array', 'published' => 'boolean'];
}
