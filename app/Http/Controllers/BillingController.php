<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Billing;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.billings.index',
            compact('billings', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Billing::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view('resources.views.billings.create', compact('tenants'));
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

        return redirect()
            ->route('billings.edit', $billing)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Billing $billing
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Billing $billing)
    {
        $this->authorize('view', $billing);

        return view('resources.views.billings.show', compact('billing'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Billing $billing
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Billing $billing)
    {
        $this->authorize('update', $billing);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view(
            'resources.views.billings.edit',
            compact('billing', 'tenants')
        );
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

        return redirect()
            ->route('billings.edit', $billing)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('billings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
