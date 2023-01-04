<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Tenant;
use App\Models\Branch;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.coupons.index',
            compact('coupons', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Coupon::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.coupons.create',
            compact('tenants', 'branches')
        );
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

        $coupon->branches()->attach($request->branches);

        return redirect()
            ->route('coupons.edit', $coupon)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Coupon $coupon)
    {
        $this->authorize('view', $coupon);

        return view('resources.views.coupons.show', compact('coupon'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.coupons.edit',
            compact('coupon', 'tenants', 'branches')
        );
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
        $coupon->branches()->sync($request->branches);

        $coupon->update($validated);

        return redirect()
            ->route('coupons.edit', $coupon)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('coupons.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
