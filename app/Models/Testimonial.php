<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'role', 'quote', 'rating', 'sort_order', 'published'];

    protected $casts = ['published' => 'boolean', 'rating' => 'integer', 'sort_order' => 'integer'];
}
