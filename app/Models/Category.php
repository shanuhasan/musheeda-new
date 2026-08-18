<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSeo;

class Category extends Model
{
    use HasFactory, HasSeo;

    protected $fillable = ['name', 'slug', 'description'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('blog.categories');
        });
        static::deleted(function ($model) {
            \Illuminate\Support\Facades\Cache::forget('blog.categories');
        });
    }
}
