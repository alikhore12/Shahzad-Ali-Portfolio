<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = ['platform', 'url', 'sort_order', 'published'];

    protected $casts = ['published' => 'boolean', 'sort_order' => 'integer'];
}
