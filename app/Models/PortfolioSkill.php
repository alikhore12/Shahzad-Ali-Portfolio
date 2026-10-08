<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesSlug;
class PortfolioSkill extends Model
{
    use GeneratesSlug;
    protected $fillable = ['name','slug','category','intro','details','points','published'];
    protected $casts = ['points' => 'array', 'published' => 'boolean'];
}
