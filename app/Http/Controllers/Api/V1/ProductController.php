<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\V1\ProductResource;
use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::active()->get();
        return $this->successResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if ($product->status !== 'active') {
            return $this->errorResponse('Product not found.', 404);
        }
        
        return $this->successResponse(new ProductResource($product), 'Product retrieved successfully.');
    }
}
