<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\CategoryProductCollection;

class TenantCategoryProductsController extends Controller
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

        $categoryProducts = $tenant
            ->categoryProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new CategoryProductCollection($categoryProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', CategoryProduct::class);

        $validated = $request->validate([
            'active' => ['required', 'boolean'],
            'name' => ['required', 'max:255', 'string'],
            'category_photo_path' => ['image', 'max:1024', 'required'],
            'description' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('category_photo_path')) {
            $validated['category_photo_path'] = $request
                ->file('category_photo_path')
                ->store('public');
        }

        $categoryProduct = $tenant->categoryProducts()->create($validated);

        return new CategoryProductResource($categoryProduct);
    }
}
