<?php
namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class CouponBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Coupon $coupon)
    {
        $this->authorize('view', $coupon);

        $search = $request->get('search', '');

        $branches = $coupon
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Coupon $coupon, Branch $branch)
    {
        $this->authorize('update', $coupon);

        $coupon->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Coupon $coupon, Branch $branch)
    {
        $this->authorize('update', $coupon);

        $coupon->branches()->detach($branch);

        return response()->noContent();
    }
}
