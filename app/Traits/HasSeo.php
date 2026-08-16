<?php

namespace App\Traits;

use App\Models\SeoMetadata;

trait HasSeo
{
    /**
     * Get the model's SEO metadata.
     */
    public function seoMetadata()
    {
        return $this->morphOne(SeoMetadata::class, 'model');
    }

    /**
     * Get the SEO title or fallback.
     */
    public function getSeoTitleAttribute()
    {
        return $this->seoMetadata?->meta_title ?? $this->title ?? $this->name ?? null;
    }

    /**
     * Get the SEO description or fallback.
     */
    public function getSeoDescriptionAttribute()
    {
        return $this->seoMetadata?->meta_description ?? $this->excerpt ?? null;
    }

    /**
     * Sync SEO metadata with the model.
     */
    public function syncSeo(array $data)
    {
        if (isset($data['custom_schema']) && is_string($data['custom_schema'])) {
            $data['custom_schema'] = json_decode($data['custom_schema'], true);
        }

        if ($this->seoMetadata) {
            $this->seoMetadata->update($data);
        } else {
            $this->seoMetadata()->create($data);
        }
    }
}
