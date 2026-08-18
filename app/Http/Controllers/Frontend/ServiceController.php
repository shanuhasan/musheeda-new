<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(SeoService $seoService)
    {
        $services = Service::active()->orderBy('sort_order')->get();
        
        $seoService->setDefaultSeo(
            'Our Services - Musheeda Solutions',
            'Explore our professional services including custom software development, ERP, and CRM solutions.'
        );

        return view('frontend.services.index', compact('services'));
    }

    public function show(Service $service, SeoService $seoService)
    {
        if ($service->status !== 'active') {
            abort(404);
        }

        $seoService->setModel($service);

        // Sanitize rich content to prevent XSS
        $service->full_description = \Mews\Purifier\Facades\Purifier::clean($service->full_description);

        return view('frontend.services.show', compact('service'));
    }
}
