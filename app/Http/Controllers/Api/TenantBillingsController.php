<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BillingResource;
use App\Http\Resources\BillingCollection;

class TenantBillingsController extends Controller
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

        $billings = $tenant
            ->billings()
            ->search($search)
            ->latest()
            ->paginate();

        return new BillingCollection($billings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Billing::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $billing = $tenant->billings()->create($validated);

        return new BillingResource($billing);
    }
}
