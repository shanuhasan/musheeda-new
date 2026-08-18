<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasSeo;

class Service extends Model
{
    use HasFactory, SoftDeletes, HasSeo;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'full_description',
        'icon',
        'featured_image',
        'benefits',
        'features',
        'faq',
        'cta',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'benefits' => 'array',
        'features' => 'array',
        'faq' => 'array',
        'cta' => 'array',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('home.services');
        });
        static::deleted(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('home.services');
        });
    }
}
