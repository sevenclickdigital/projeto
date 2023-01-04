<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryProductCollection;

class BranchCategoryProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Branch $branch)
    {
        $this->authorize('view', $branch);

        $search = $request->get('search', '');

        $categoryProducts = $branch
            ->categoryProducts()
            ->search($search)
            ->latest()
            ->paginate();

        return new CategoryProductCollection($categoryProducts);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Branch $branch,
        CategoryProduct $categoryProduct
    ) {
        $this->authorize('update', $branch);

        $branch
            ->categoryProducts()
            ->syncWithoutDetaching([$categoryProduct->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\CategoryProduct $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        CategoryProduct $categoryProduct
    ) {
        $this->authorize('update', $branch);

        $branch->categoryProducts()->detach($categoryProduct);

        return response()->noContent();
    }
}
