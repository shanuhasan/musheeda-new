<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'status', 'verified_at'];

    protected $casts = [
        'verified_at' => 'datetime',
    ];
}
