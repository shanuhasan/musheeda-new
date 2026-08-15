<?php

use App\Services\SettingService;
use App\Services\NavigationService;
use Illuminate\Support\Facades\App;

if (!function_exists('setting')) {
    /**
     * Get a website setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return App::make(SettingService::class)->get($key, $default);
    }
}

if (!function_exists('menu')) {
    /**
     * Get active navigation menu items for a specific location.
     *
     * @param string $location
     * @return \Illuminate\Support\Collection
     */
    function menu($location)
    {
        return App::make(NavigationService::class)->getMenu($location);
    }
}
