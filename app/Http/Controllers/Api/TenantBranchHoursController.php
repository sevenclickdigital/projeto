<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchHourResource;
use App\Http\Resources\BranchHourCollection;

class TenantBranchHoursController extends Controller
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

        $branchHours = $tenant
            ->branchHours()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchHourCollection($branchHours);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', BranchHour::class);

        $validated = $request->validate([
            'day' => [
                'required',
                'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            ],
            'hour_start' => ['nullable', 'date_format:H:i:s'],
            'hour_end' => ['nullable', 'date_format:H:i:s'],
            'branch_id' => ['required', 'exists:branches,id'],
        ]);

        $branchHour = $tenant->branchHours()->create($validated);

        return new BranchHourResource($branchHour);
    }
}
