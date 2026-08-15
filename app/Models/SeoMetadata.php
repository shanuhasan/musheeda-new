<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMetadata extends Model
{
    protected $fillable = [
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url',
        'robots', 'og_title', 'og_description', 'og_image'
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
