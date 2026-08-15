<?php

namespace App\Services;

use App\Models\NavigationMenu;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    public function getMenu(string $location)
    {
        $cacheKey = "website.menu.{$location}";

        return Cache::rememberForever($cacheKey, function () use ($location) {
            $menu = NavigationMenu::where('location', $location)->first();
            
            if (!$menu) {
                return collect([]);
            }

            return $menu->items()
                ->active()
                ->whereNull('parent_id')
                ->with(['children' => function($query) {
                    $query->active();
                }])
                ->orderBy('order')
                ->get();
        });
    }

    public function clearCache(string $location = null)
    {
        if ($location) {
            Cache::forget("website.menu.{$location}");
        } else {
            $menus = NavigationMenu::pluck('location');
            foreach ($menus as $loc) {
                Cache::forget("website.menu.{$loc}");
            }
        }
    }
}
