<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipApplication extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'country',
        'domain',
        'internship_type',
        'desired_start_date',
        'motivation',
        'documents',
        'status',
        'internal_notes',
    ];

    protected $casts = [
        'desired_start_date' => 'date',
        'documents' => 'array',
    ];
}
