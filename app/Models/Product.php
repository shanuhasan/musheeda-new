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
        'slug',
        'short_description',
        'description',
        'images',
        'features',
        'benefits',
        'price',
        'pricing_type',
        'demo_url',
        'documentation_url',
        'cta',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
        'features' => 'array',
        'benefits' => 'array',
        'cta' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
