<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\SeoService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(SeoService $seoService)
    {
        $products = Product::whereIn('status', ['active', 'discontinued'])->latest()->get();
        
        $seoService->setDefaultSeo(
            'Our Products - Musheeda Solutions',
            'Explore our range of software products designed to streamline your business operations.'
        );

        return view('frontend.products.index', compact('products'));
    }

    public function show(Product $product, SeoService $seoService)
    {
        if ($product->status === 'inactive') {
            abort(404);
        }

        $seoService->setModel($product);

        // Sanitize rich content to prevent XSS
        $product->description = \Mews\Purifier\Facades\Purifier::clean($product->description);

        return view('frontend.products.show', compact('product'));
    }
}
