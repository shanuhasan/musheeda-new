<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'email',
        'status',
        'token',
        'source',
        'ip_address',
        'verified_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Generate a new unique token for the subscriber.
     */
    public function generateToken()
    {
        $this->token = \Illuminate\Support\Str::random(60);
        $this->save();
        return $this->token;
    }
}
