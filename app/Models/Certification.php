<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = ['name', 'issuer', 'year', 'url', 'sort_order', 'published'];

    protected $casts = ['published' => 'boolean', 'sort_order' => 'integer'];
}
