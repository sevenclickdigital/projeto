<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Models\HolidayDescription;
use App\Http\Requests\HolidayDescriptionStoreRequest;
use App\Http\Requests\HolidayDescriptionUpdateRequest;

class HolidayDescriptionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', HolidayDescription::class);

        $search = $request->get('search', '');

        $holidayDescriptions = HolidayDescription::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.holiday_descriptions.index',
            compact('holidayDescriptions', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', HolidayDescription::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');
        $holidays = Holiday::pluck('name', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.holiday_descriptions.create',
            compact('tenants', 'holidays', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\HolidayDescriptionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayDescriptionStoreRequest $request)
    {
        $this->authorize('create', HolidayDescription::class);

        $validated = $request->validated();

        $holidayDescription = HolidayDescription::create($validated);

        $holidayDescription->branches()->attach($request->branches);

        return redirect()
            ->route('holiday-descriptions.edit', $holidayDescription)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HolidayDescription $holidayDescription
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        HolidayDescription $holidayDescription
    ) {
        $this->authorize('view', $holidayDescription);

        return view(
            'resources.views.holiday_descriptions.show',
            compact('holidayDescription')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HolidayDescription $holidayDescription
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        HolidayDescription $holidayDescription
    ) {
        $this->authorize('update', $holidayDescription);

        $tenants = Tenant::pluck('facebook_page_id', 'id');
        $holidays = Holiday::pluck('name', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.holiday_descriptions.edit',
            compact('holidayDescription', 'tenants', 'holidays', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\HolidayDescriptionUpdateRequest $request
     * @param \App\Models\HolidayDescription $holidayDescription
     * @return \Illuminate\Http\Response
     */
    public function update(
        HolidayDescriptionUpdateRequest $request,
        HolidayDescription $holidayDescription
    ) {
        $this->authorize('update', $holidayDescription);

        $validated = $request->validated();
        $holidayDescription->branches()->sync($request->branches);

        $holidayDescription->update($validated);

        return redirect()
            ->route('holiday-descriptions.edit', $holidayDescription)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HolidayDescription $holidayDescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        HolidayDescription $holidayDescription
    ) {
        $this->authorize('delete', $holidayDescription);

        $holidayDescription->delete();

        return redirect()
            ->route('holiday-descriptions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
