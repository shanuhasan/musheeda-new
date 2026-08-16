<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, $slug, \App\Services\SeoService $seoService)
    {
        $query = Page::where('slug', $slug)->with('seo', 'media');

        // Check for preview mode
        if ($request->query('preview') === 'true' && auth()->check() && auth()->user()->can('manage_pages')) {
            // Allow draft in preview
        } else {
            $query->where('status', 'published');
        }

        $page = $query->firstOrFail();

        $seoService->setModel($page);

        return view('pages.show', compact('page'));
    }
}
