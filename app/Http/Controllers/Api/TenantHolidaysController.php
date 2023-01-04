<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HolidayResource;
use App\Http\Resources\HolidayCollection;

class TenantHolidaysController extends Controller
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

        $holidays = $tenant
            ->holidays()
            ->search($search)
            ->latest()
            ->paginate();

        return new HolidayCollection($holidays);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Holiday::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'date' => ['required', 'date'],
            'active' => ['required', 'boolean'],
            'custom' => ['required', 'boolean'],
        ]);

        $holiday = $tenant->holidays()->create($validated);

        return new HolidayResource($holiday);
    }
}
