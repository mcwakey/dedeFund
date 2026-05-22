<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasLocalizedContent
{
    public function translation(?string $locale = null): ?Model
    {
        $locale ??= app()->getLocale();
        $translations = $this->relationLoaded('translations')
            ? $this->translations
            : $this->translations()->get();

        return $translations->firstWhere('locale', $locale)
            ?? $translations->firstWhere('locale', config('app.fallback_locale', 'fr'))
            ?? $translations->first();
    }

    public function localized(string $attribute, ?string $locale = null, string $fallback = ''): string
    {
        $translation = $this->translation($locale);

        return (string) ($translation?->{$attribute} ?? $fallback);
    }
}
