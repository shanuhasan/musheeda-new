<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationMenuItem extends Model
{
    protected $fillable = ['navigation_menu_id', 'parent_id', 'title', 'url', 'target', 'order'];

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
