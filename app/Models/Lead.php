<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /** @use HasFactory<\Database\Factories\LeadFactory> */
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'message',
        'source',
        'landing_page',
        'product_service',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'ip_address',
        'user_agent',
        'status',
        'notes',
        'assigned_to',
    ];

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
