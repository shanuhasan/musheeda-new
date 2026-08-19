<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index()
    {
        $landingPages = LandingPage::latest()->paginate(20);
        return view('admin.landing-pages.index', compact('landingPages'));
    }

    public function create()
    {
        return view('admin.landing-pages.form');
    }

    public function store(Request $request)
    {
        if ($request->has('blocks') && is_string($request->blocks)) {
            $request->merge(['blocks' => json_decode($request->blocks, true)]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_pages',
            'status' => 'required|in:draft,published',
            'blocks' => 'nullable|array',
        ]);

        $landingPage = LandingPage::create($validated);
        
        return redirect()->route('admin.landing-pages.edit', $landingPage)->with('success', 'Landing Page created successfully.');
    }

    public function edit(LandingPage $landingPage)
    {
        return view('admin.landing-pages.form', compact('landingPage'));
    }

    public function update(Request $request, LandingPage $landingPage)
    {
        if ($request->has('blocks') && is_string($request->blocks)) {
            $request->merge(['blocks' => json_decode($request->blocks, true)]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:landing_pages,slug,' . $landingPage->id,
            'status' => 'required|in:draft,published',
            'blocks' => 'nullable|array',
        ]);

        // Security check: Only super admin can save 'html' blocks
        if (isset($validated['blocks'])) {
            foreach ($validated['blocks'] as &$block) {
                if ($block['type'] === 'html') {
                    if (!auth()->user()->hasRole('Super Admin')) {
                        // Strip html completely or just block the update
                        abort(403, 'Unauthorized to use raw HTML block.');
                    }
                }
            }
        }

        $landingPage->update($validated);
        
        return redirect()->route('admin.landing-pages.edit', $landingPage)->with('success', 'Landing Page updated successfully.');
    }

    public function destroy(LandingPage $landingPage)
    {
        $landingPage->delete();
        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing Page deleted successfully.');
    }
}
