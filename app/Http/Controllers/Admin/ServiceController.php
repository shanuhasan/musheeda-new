<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->paginate(20);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $service = new Service();
        return view('admin.services.create', compact('service'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateService($request);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $service = Service::create($validated);
        
        if ($request->has('seo')) {
            $service->syncSeo($request->input('seo'));
        }

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $this->validateService($request, $service->id);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $service->update($validated);

        if ($request->has('seo')) {
            $service->syncSeo($request->input('seo'));
        }

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    private function validateService(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug,' . $id,
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'featured_image' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'required|integer',
            'benefits' => 'nullable|array',
            'features' => 'nullable|array',
            'faq' => 'nullable|array',
            'cta' => 'nullable|array',
        ]);
    }
}
