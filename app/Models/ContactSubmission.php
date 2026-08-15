<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ContactSubmission extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'ip_address', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}
