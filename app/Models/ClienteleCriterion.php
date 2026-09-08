<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteleCriterion extends Model
{
    protected $table = 'clientele_criteria';

    protected $fillable = [
        'text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
