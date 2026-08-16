<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Services\SeoService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show(Request $request, $slug, SeoService $seoService)
    {
        $query = LandingPage::where('slug', $slug)->with('seoMetadata');

        // Check for preview mode
        if ($request->query('preview') === 'true' && auth()->check() && auth()->user()->hasRole('Super Admin')) {
            // Allow draft in preview
        } else {
            $query->published();
        }

        $landingPage = $query->firstOrFail();

        $seoService->setModel($landingPage);

        return view('frontend.landing.show', compact('landingPage'));
    }
}
