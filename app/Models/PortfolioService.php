<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\GeneratesSlug;
class PortfolioService extends Model
{
    use GeneratesSlug;
    protected $fillable = ['name','slug','intro','details','points','documents','published'];
    protected $casts = ['points' => 'array', 'documents' => 'array', 'published' => 'boolean'];
}
