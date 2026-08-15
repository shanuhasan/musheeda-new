<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NavigationMenu;
use App\Http\Requests\StoreNavigationMenuRequest;
use App\Services\NavigationService;
use Illuminate\Http\Request;

class NavigationMenuController extends Controller
{
    public function index()
    {
        $menus = NavigationMenu::paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function store(StoreNavigationMenuRequest $request)
    {
        NavigationMenu::create($request->validated());
        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(NavigationMenu $menu)
    {
        // Load items for the builder
        $menu->load(['items' => function($q) {
            $q->whereNull('parent_id')->with('children')->orderBy('order');
        }]);
        
        return view('admin.menus.builder', compact('menu'));
    }

    public function update(StoreNavigationMenuRequest $request, NavigationMenu $menu)
    {
        $menu->update($request->validated());
        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(NavigationMenu $menu, NavigationService $navService)
    {
        $location = $menu->location;
        $menu->delete();
        $navService->clearCache($location);
        
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}
