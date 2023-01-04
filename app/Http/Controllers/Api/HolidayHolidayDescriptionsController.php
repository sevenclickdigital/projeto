<?php

namespace App\Http\Controllers\Api;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HolidayDescriptionResource;
use App\Http\Resources\HolidayDescriptionCollection;

class HolidayHolidayDescriptionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Holiday $holiday)
    {
        $this->authorize('view', $holiday);

        $search = $request->get('search', '');

        $holidayDescriptions = $holiday
            ->holidayDescriptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new HolidayDescriptionCollection($holidayDescriptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Holiday $holiday)
    {
        $this->authorize('create', HolidayDescription::class);

        $validated = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'active' => ['required', 'boolean'],
            'when_send' => [
                'required',
                'in:one_day,two_days,three_days,four_days,five_days,one_week,two_weeks,one_month,in_day',
            ],
            'time' => ['required', 'date_format:H:i:s'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
        ]);

        $holidayDescription = $holiday
            ->holidayDescriptions()
            ->create($validated);

        return new HolidayDescriptionResource($holidayDescription);
    }
}
