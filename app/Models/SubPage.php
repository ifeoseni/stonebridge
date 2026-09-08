<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubPage extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'content',
        'meta_description',
        'is_published',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
