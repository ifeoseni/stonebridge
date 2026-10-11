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
        'is_spam',
        'spam_reason',
        'admin_notes',
    ];

    protected $casts = [
        'is_spam' => 'boolean',
    ];
}
