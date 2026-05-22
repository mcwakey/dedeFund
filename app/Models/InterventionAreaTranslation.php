<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterventionAreaTranslation extends Model
{
    protected $fillable = [
        'intervention_area_id',
        'locale',
        'name',
        'slug',
        'summary',
        'body',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(InterventionArea::class, 'intervention_area_id');
    }
}
