<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMetadata extends Model
{
    protected $table = 'seo_metadata';

    protected $fillable = [
        'meta_title', 
        'meta_description', 
        'meta_keywords', 
        'focus_keyword', 
        'canonical_url',
        'robots', 
        'og_title', 
        'og_description', 
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_type',
        'custom_schema'
    ];

    protected $casts = [
        'custom_schema' => 'array',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
