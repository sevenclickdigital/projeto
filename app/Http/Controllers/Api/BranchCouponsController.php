<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponCollection;

class BranchCouponsController extends Controller
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

        $coupons = $branch
            ->coupons()
            ->search($search)
            ->latest()
            ->paginate();

        return new CouponCollection($coupons);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch, Coupon $coupon)
    {
        $this->authorize('update', $branch);

        $branch->coupons()->syncWithoutDetaching([$coupon->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Branch $branch, Coupon $coupon)
    {
        $this->authorize('update', $branch);

        $branch->coupons()->detach($coupon);

        return response()->noContent();
    }
}
