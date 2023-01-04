<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class CategoryProductBranchesController extends Controller
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

        $branches = $categoryProduct
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        CategoryProduct $categoryProduct,
        Branch $branch
    ) {
        $this->authorize('update', $categoryProduct);

        $categoryProduct->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CategoryProduct $categoryProduct
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        CategoryProduct $categoryProduct,
        Branch $branch
    ) {
        $this->authorize('update', $categoryProduct);

        $categoryProduct->branches()->detach($branch);

        return response()->noContent();
    }
}
