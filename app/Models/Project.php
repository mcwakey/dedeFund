<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasLocalizedContent;

    protected $fillable = [
        'intervention_area_id',
        'location',
        'target_amount',
        'raised_amount',
        'currency',
        'start_date',
        'end_date',
        'status',
        'featured_image',
        'documents',
        'is_featured',
        'is_published',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'documents' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'published_at' => 'datetime',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(InterventionArea::class, 'intervention_area_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function fundingPercent(): int
    {
        if ((float) $this->target_amount <= 0) {
            return 0;
        }

        return min(100, (int) round(((float) $this->raised_amount / (float) $this->target_amount) * 100));
    }
}
