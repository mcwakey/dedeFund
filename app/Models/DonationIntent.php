<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationIntent extends Model
{
    protected $fillable = [
        'donor_name',
        'email',
        'phone',
        'country',
        'donation_method',
        'project_id',
        'amount',
        'currency',
        'message',
        'status',
        'contacted_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'contacted_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
