<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class TenantProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        $search = $request->get('search', '');

        $products = $tenant
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'type' => ['required', 'in:catalog_online,catalog_pdf'],
            'category_product_id' => [
                'required',
                'exists:category_products,id',
            ],
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

        $product = $tenant->products()->create($validated);

        return new ProductResource($product);
    }
}
