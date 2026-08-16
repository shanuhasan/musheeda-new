<?php

namespace App\Models;

use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandingPage extends Model
{
    use HasFactory, SoftDeletes, HasSeo;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'blocks',
    ];

    protected $casts = [
        'blocks' => 'array',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
