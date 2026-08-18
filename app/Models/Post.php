<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasSeo;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'status',
        'is_featured',
        'reading_time_minutes',
        'meta_title',
        'meta_description',
        'author_id',
        'published_at',
        'show_toc',
        'faqs',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'show_toc' => 'boolean',
        'faqs' => 'array',
        'published_at' => 'datetime',
    ];

    public function relatedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_related', 'post_id', 'related_post_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(150)
              ->height(150)
              ->format('webp')
              ->nonQueued();

        $this->addMediaConversion('featured')
              ->width(1200)
              ->height(630)
              ->format('webp')
              ->nonQueued();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('home.posts');
        });
        static::deleted(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('home.posts');
        });
    }
}
