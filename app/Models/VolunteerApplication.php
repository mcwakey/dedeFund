<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'country',
        'city',
        'contribution_type',
        'skills',
        'availability',
        'message',
        'documents',
        'status',
        'internal_notes',
    ];

    protected $casts = [
        'documents' => 'array',
    ];
}
