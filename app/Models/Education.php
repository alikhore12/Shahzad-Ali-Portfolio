<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = ['institution', 'degree', 'period', 'description', 'sort_order', 'published'];

    protected $casts = ['published' => 'boolean', 'sort_order' => 'integer'];
}
