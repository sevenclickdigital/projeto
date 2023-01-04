<?php

namespace App\Http\Controllers\Api;

use App\Models\Billing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BillingResource;
use App\Http\Resources\BillingCollection;
use App\Http\Requests\BillingStoreRequest;
use App\Http\Requests\BillingUpdateRequest;

class BillingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Billing::class);

        $search = $request->get('search', '');

        $billings = Billing::search($search)
            ->latest()
            ->paginate();

        return new BillingCollection($billings);
    }

    /**
     * @param \App\Http\Requests\BillingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillingStoreRequest $request)
    {
        $this->authorize('create', Billing::class);

        $validated = $request->validated();

        $billing = Billing::create($validated);

        return new BillingResource($billing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Billing $billing
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Billing $billing)
    {
        $this->authorize('view', $billing);

        return new BillingResource($billing);
    }

    /**
     * @param \App\Http\Requests\BillingUpdateRequest $request
     * @param \App\Models\Billing $billing
     * @return \Illuminate\Http\Response
     */
    public function update(BillingUpdateRequest $request, Billing $billing)
    {
        $this->authorize('update', $billing);

        $validated = $request->validated();

        $billing->update($validated);

        return new BillingResource($billing);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Billing $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Billing $billing)
    {
        $this->authorize('delete', $billing);

        $billing->delete();

        return response()->noContent();
    }
}
