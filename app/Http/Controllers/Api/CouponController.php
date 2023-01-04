<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Http\Resources\CouponCollection;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;

class CouponController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Coupon::class);

        $search = $request->get('search', '');

        $coupons = Coupon::search($search)
            ->latest()
            ->paginate();

        return new CouponCollection($coupons);
    }

    /**
     * @param \App\Http\Requests\CouponStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStoreRequest $request)
    {
        $this->authorize('create', Coupon::class);

        $validated = $request->validated();

        $coupon = Coupon::create($validated);

        return new CouponResource($coupon);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Coupon $coupon)
    {
        $this->authorize('view', $coupon);

        return new CouponResource($coupon);
    }

    /**
     * @param \App\Http\Requests\CouponUpdateRequest $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(CouponUpdateRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $validated = $request->validated();

        $coupon->update($validated);

        return new CouponResource($coupon);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Coupon $coupon)
    {
        $this->authorize('delete', $coupon);

        $coupon->delete();

        return response()->noContent();
    }
}
