<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationMenuItem extends Model
{
    protected $fillable = ['navigation_menu_id', 'parent_id', 'title', 'url', 'target', 'order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function menu()
    {
        return $this->belongsTo(NavigationMenu::class, 'navigation_menu_id');
    }

    public function parent()
    {
        return $this->belongsTo(NavigationMenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavigationMenuItem::class, 'parent_id')->orderBy('order');
    }
}
