<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BirthdayResource;
use App\Http\Resources\BirthdayCollection;

class TenantBirthdaysController extends Controller
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

        $birthdays = $tenant
            ->birthdays()
            ->search($search)
            ->latest()
            ->paginate();

        return new BirthdayCollection($birthdays);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Birthday::class);

        $validated = $request->validate([
            'when_send' => [
                'required',
                'in:one_day,two_days,three_days,four_days,five_days,one_week,two_weeks,one_month,in_day',
            ],
            'time' => ['required', 'date_format:H:i:s'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
        ]);

        $birthday = $tenant->birthdays()->create($validated);

        return new BirthdayResource($birthday);
    }
}
