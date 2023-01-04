<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Http\Resources\CouponCollection;

class TenantCouponsController extends Controller
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

        $coupons = $tenant
            ->coupons()
            ->search($search)
            ->latest()
            ->paginate();

        return new CouponCollection($coupons);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Coupon::class);

        $validated = $request->validate([
            'active' => ['required', 'boolean'],
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'code' => ['required', 'max:255', 'string'],
            'coupon_type' => ['required', 'in:default,first_order'],
            'limit' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'expire_date' => ['required', 'date'],
            'min_purchase' => ['required', 'numeric'],
            'max_discount' => ['required', 'numeric'],
            'discount_type' => ['required', 'in:amount,percent'],
            'discount' => ['required', 'numeric'],
            'when_send' => ['required', 'date'],
        ]);

        $coupon = $tenant->coupons()->create($validated);

        return new CouponResource($coupon);
    }
}
