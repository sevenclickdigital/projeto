<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryProductStoreRequest;
use App\Http\Requests\CategoryProductUpdateRequest;

class CategoryProductController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', CategoryProduct::class);

        $search = $request->get('search', '');

        $categoryProducts = CategoryProduct::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.category_products.index',
            compact('categoryProducts', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', CategoryProduct::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.category_products.create',
            compact('tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\CategoryProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryProductStoreRequest $request)
    {
        $this->authorize('create', CategoryProduct::class);

        $validated = $request->validated();
        if ($request->hasFile('category_photo_path')) {
            $validated['category_photo_path'] = $request
                ->file('category_photo_path')
                ->store('public');
        }

        $categoryProduct = CategoryProduct::create($validated);

        $categoryProduct->branches()->attach($request->branches);

        return redirect()
            ->route('category-products.edit', $categoryProduct)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, CategoryProduct $categoryProduct)
    {
        $this->authorize('view', $categoryProduct);

        return view(
            'resources.views.category_products.show',
            compact('categoryProduct')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CategoryProduct $categoryProduct)
    {
        $this->authorize('update', $categoryProduct);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.category_products.edit',
            compact('categoryProduct', 'tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\CategoryProductUpdateRequest $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function update(
        CategoryProductUpdateRequest $request,
        CategoryProduct $categoryProduct
    ) {
        $this->authorize('update', $categoryProduct);

        $validated = $request->validated();
        if ($request->hasFile('category_photo_path')) {
            if ($categoryProduct->category_photo_path) {
                Storage::delete($categoryProduct->category_photo_path);
            }

            $validated['category_photo_path'] = $request
                ->file('category_photo_path')
                ->store('public');
        }

        $categoryProduct->branches()->sync($request->branches);

        $categoryProduct->update($validated);

        return redirect()
            ->route('category-products.edit', $categoryProduct)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CategoryProduct $categoryProduct)
    {
        $this->authorize('delete', $categoryProduct);

        if ($categoryProduct->category_photo_path) {
            Storage::delete($categoryProduct->category_photo_path);
        }

        $categoryProduct->delete();

        return redirect()
            ->route('category-products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
