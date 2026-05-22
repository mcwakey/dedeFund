<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterventionArea extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'icon',
        'color',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(InterventionAreaTranslation::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
