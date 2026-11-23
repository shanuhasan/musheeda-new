<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSettingsRequest;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index()
    {
        $settings = $this->settingService->all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateSettingsRequest $request)
    {
        $settings = $request->validated('settings');

        if ($request->hasFile('favicon')) {
            // Store a host-independent path; views render it with asset().
            $path = $request->file('favicon')->storePublicly('settings', 'public');
            $settings['favicon'] = 'storage/' . $path;
        }

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->storePublicly('settings', 'public');
            $settings['site_logo'] = 'storage/' . $path;
        }

        $this->settingService->set($settings, $request->validated('group'));
        
        return redirect()->back()->with('success', ucfirst($request->validated('group')) . ' settings updated successfully.');
    }
}
