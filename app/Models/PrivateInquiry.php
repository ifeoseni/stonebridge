<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateInquiry extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'circumstances',
        'motivation',
        'status',
        'admin_notes',
    ];
}
