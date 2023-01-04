<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\HolidayDescription;
use App\Http\Controllers\Controller;
use App\Http\Resources\HolidayDescriptionCollection;

class BranchHolidayDescriptionsController extends Controller
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

        $holidayDescriptions = $branch
            ->holidayDescriptions()
            ->search($search)
            ->latest()
            ->paginate();

        return new HolidayDescriptionCollection($holidayDescriptions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\HolidayDescription $holidayDescription
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Branch $branch,
        HolidayDescription $holidayDescription
    ) {
        $this->authorize('update', $branch);

        $branch
            ->holidayDescriptions()
            ->syncWithoutDetaching([$holidayDescription->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\HolidayDescription $holidayDescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        HolidayDescription $holidayDescription
    ) {
        $this->authorize('update', $branch);

        $branch->holidayDescriptions()->detach($holidayDescription);

        return response()->noContent();
    }
}
