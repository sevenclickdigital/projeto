<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Requests\HolidayStoreRequest;
use App\Http\Requests\HolidayUpdateRequest;

class HolidayController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Holiday::class);

        $search = $request->get('search', '');

        $holidays = Holiday::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.holidays.index',
            compact('holidays', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Holiday::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view('resources.views.holidays.create', compact('tenants'));
    }

    /**
     * @param \App\Http\Requests\HolidayStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayStoreRequest $request)
    {
        $this->authorize('create', Holiday::class);

        $validated = $request->validated();

        $holiday = Holiday::create($validated);

        return redirect()
            ->route('holidays.edit', $holiday)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Holiday $holiday)
    {
        $this->authorize('view', $holiday);

        return view('resources.views.holidays.show', compact('holiday'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Holiday $holiday)
    {
        $this->authorize('update', $holiday);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view(
            'resources.views.holidays.edit',
            compact('holiday', 'tenants')
        );
    }

    /**
     * @param \App\Http\Requests\HolidayUpdateRequest $request
     * @param \App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayUpdateRequest $request, Holiday $holiday)
    {
        $this->authorize('update', $holiday);

        $validated = $request->validated();

        $holiday->update($validated);

        return redirect()
            ->route('holidays.edit', $holiday)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Holiday $holiday)
    {
        $this->authorize('delete', $holiday);

        $holiday->delete();

        return redirect()
            ->route('holidays.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
