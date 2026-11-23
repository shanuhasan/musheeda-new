<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasSeo;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasSeo;

    protected $fillable = [
        'name',
        'type',
        'slug',
        'short_description',
        'description',
        'images',
        'features',
        'benefits',
        'price',
        'mrp',
        'pricing_type',
        'demo_url',
        'documentation_url',
        'cta',
        'status',
        'download_file_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'images' => 'array',
        'features' => 'array',
        'benefits' => 'array',
        'cta' => 'array',
    ];

    /**
     * True when an MRP is set and is higher than the selling price.
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->price !== null && $this->mrp !== null && (float) $this->mrp > (float) $this->price;
    }

    /**
     * Whole-number discount percentage off the MRP (0 when there is no discount).
     */
    public function getDiscountPercentAttribute(): int
    {
        return $this->has_discount
            ? (int) round(((float) $this->mrp - (float) $this->price) / (float) $this->mrp * 100)
            : 0;
    }

    /**
     * Absolute path of the downloadable file (e.g. the e-book PDF), or null if it is missing.
     *
     * Older uploads were recorded as "app/ebooks/..." while the file actually landed in
     * storage/app/private/ebooks/..., so both locations are checked.
     */
    public function downloadFileAbsolutePath(): ?string
    {
        $relative = $this->download_file_path;
        if (!$relative) {
            return null;
        }

        $candidates = [storage_path($relative)];
        if (str_starts_with($relative, 'app/') && !str_starts_with($relative, 'app/private/')) {
            $candidates[] = storage_path('app/private/' . substr($relative, 4));
        }

        foreach ($candidates as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('home.products');
        });
        static::deleted(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('home.products');
        });
    }
}
