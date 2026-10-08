<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['title', 'company', 'period', 'description', 'sort_order', 'published'];

    protected $casts = ['published' => 'boolean', 'sort_order' => 'integer'];
}
