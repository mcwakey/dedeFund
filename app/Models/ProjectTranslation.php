<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTranslation extends Model
{
    protected $fillable = [
        'project_id',
        'locale',
        'title',
        'slug',
        'summary',
        'description',
        'beneficiaries',
        'general_objective',
        'specific_objectives',
        'expected_impact',
        'meta_title',
        'meta_description',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
