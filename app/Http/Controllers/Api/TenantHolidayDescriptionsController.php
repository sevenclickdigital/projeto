<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HolidayDescriptionResource;
use App\Http\Resources\HolidayDescriptionCollection;

class TenantHolidayDescriptionsController extends Controller
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

        $holidayDescriptions = $tenant
            ->holidayDescriptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new HolidayDescriptionCollection($holidayDescriptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', HolidayDescription::class);

        $validated = $request->validate([
            'holiday_id' => ['required', 'exists:holidays,id'],
            'active' => ['required', 'boolean'],
            'when_send' => [
                'required',
                'in:one_day,two_days,three_days,four_days,five_days,one_week,two_weeks,one_month,in_day',
            ],
            'time' => ['required', 'date_format:H:i:s'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
        ]);

        $holidayDescription = $tenant
            ->holidayDescriptions()
            ->create($validated);

        return new HolidayDescriptionResource($holidayDescription);
    }
}
