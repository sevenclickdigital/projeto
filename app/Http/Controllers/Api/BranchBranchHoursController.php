<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchHourResource;
use App\Http\Resources\BranchHourCollection;

class BranchBranchHoursController extends Controller
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

        $branchHours = $branch
            ->branchHours()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchHourCollection($branchHours);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch)
    {
        $this->authorize('create', BranchHour::class);

        $validated = $request->validate([
            'day' => [
                'required',
                'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            ],
            'hour_start' => ['nullable', 'date_format:H:i:s'],
            'tenant_id' => ['required', 'exists:tenants,id'],
            'hour_end' => ['nullable', 'date_format:H:i:s'],
        ]);

        $branchHour = $branch->branchHours()->create($validated);

        return new BranchHourResource($branchHour);
    }
}
