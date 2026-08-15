<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaAsset extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['uploaded_by'];

    /**
     * Register media conversions for optimization and thumbnails.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(150)
             ->height(150)
             ->format('webp')
             ->nonQueued();

        $this->addMediaConversion('optimized')
             ->width(1200)
             ->format('webp')
             ->nonQueued();
    }
}
