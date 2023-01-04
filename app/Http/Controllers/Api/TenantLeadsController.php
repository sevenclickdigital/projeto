<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Resources\LeadResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class TenantLeadsController extends Controller
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

        $leads = $tenant
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validate([
            'active' => ['required', 'boolean'],
            'first_name' => ['required', 'max:255', 'string'],
            'last_name' => ['nullable', 'max:255', 'string'],
            'gender' => ['nullable', 'in:male,female,other'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'max:255', 'string'],
            'birthday' => ['nullable', 'date'],
            'notify_news' => ['required', 'boolean'],
            'notify_holiday' => ['required', 'boolean'],
            'notify_birthday' => ['required', 'boolean'],
            'notify_scratch_card' => ['required', 'boolean'],
            'notify_coupon' => ['required', 'boolean'],
        ]);

        $lead = $tenant->leads()->create($validated);

        return new LeadResource($lead);
    }
}
