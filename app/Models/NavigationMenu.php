<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    protected $fillable = ['name', 'slug', 'location'];

    public function items()
    {
        return $this->hasMany(NavigationMenuItem::class)->whereNull('parent_id')->orderBy('order');
    }
}
