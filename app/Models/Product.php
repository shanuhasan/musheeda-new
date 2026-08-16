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
        'description',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
