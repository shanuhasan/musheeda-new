<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $product = new Product();
        return view('admin.products.create', compact('product'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        $product = Product::create($validated);
        
        if ($request->has('seo')) {
            $product->syncSeo($request->input('seo'));
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        if ($request->has('seo')) {
            $product->syncSeo($request->input('seo'));
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    private function validateProduct(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'features' => 'nullable|array',
            'benefits' => 'nullable|array',
            'price' => 'nullable|numeric',
            'pricing_type' => 'nullable|string|max:255',
            'demo_url' => 'nullable|url|max:255',
            'documentation_url' => 'nullable|url|max:255',
            'cta' => 'nullable|array',
            'status' => 'required|in:active,inactive,discontinued',
        ]);
    }
}
