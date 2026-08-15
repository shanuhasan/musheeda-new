<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenuItem;
use App\Http\Requests\StoreNavigationMenuItemRequest;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class NavigationMenuItemController extends Controller
{
    public function store(StoreNavigationMenuItemRequest $request, NavigationService $navService)
    {
        $item = NavigationMenuItem::create($request->validated());
        $navService->clearCache($item->menu->location);
        
        return redirect()->back()->with('success', 'Menu item added successfully.');
    }

    public function update(StoreNavigationMenuItemRequest $request, NavigationMenuItem $menuItem, NavigationService $navService)
    {
        $menuItem->update($request->validated());
        $navService->clearCache($menuItem->menu->location);
        
        return redirect()->back()->with('success', 'Menu item updated successfully.');
    }

    public function destroy(NavigationMenuItem $menuItem, NavigationService $navService)
    {
        $location = $menuItem->menu->location;
        $menuItem->delete();
        $navService->clearCache($location);
        
        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

    public function toggle(NavigationMenuItem $menuItem, NavigationService $navService)
    {
        $menuItem->update(['is_active' => !$menuItem->is_active]);
        $navService->clearCache($menuItem->menu->location);

        return redirect()->back()->with('success', 'Menu item status updated.');
    }
}
