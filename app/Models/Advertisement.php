<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'placement',
        'code',
        'is_active',
        'is_lazy',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_lazy' => 'boolean',
    ];
}
