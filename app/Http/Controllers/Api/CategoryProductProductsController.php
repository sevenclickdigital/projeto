<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class CategoryProductProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CategoryProduct $categoryProduct)
    {
        $this->authorize('view', $categoryProduct);

        $search = $request->get('search', '');

        $products = $categoryProduct
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CategoryProduct $categoryProduct)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'type' => ['required', 'in:catalog_online,catalog_pdf'],
            'product_photo_path' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            ' button_text' => ['nullable', 'max:255', 'string'],
            ' button_path' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('product_photo_path')) {
            $validated['product_photo_path'] = $request
                ->file('product_photo_path')
                ->store('public');
        }

        $product = $categoryProduct->products()->create($validated);

        return new ProductResource($product);
    }
}
