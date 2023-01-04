<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\HolidayDescription;
use App\Http\Controllers\Controller;
use App\Http\Resources\HolidayDescriptionResource;
use App\Http\Resources\HolidayDescriptionCollection;
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
            ->paginate();

        return new HolidayDescriptionCollection($holidayDescriptions);
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

        return new HolidayDescriptionResource($holidayDescription);
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

        return new HolidayDescriptionResource($holidayDescription);
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

        $holidayDescription->update($validated);

        return new HolidayDescriptionResource($holidayDescription);
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

        return response()->noContent();
    }
}
