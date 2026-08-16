<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasSeo;

class Page extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasSeo;

    protected $fillable = ['title', 'slug', 'content', 'status', 'author_id', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function seo()
    {
        return $this->morphOne(SeoMetadata::class, 'model');
    }
}
