<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\HolidayDescription;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class HolidayDescriptionBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HolidayDescription $holidayDescription
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        HolidayDescription $holidayDescription
    ) {
        $this->authorize('view', $holidayDescription);

        $search = $request->get('search', '');

        $branches = $holidayDescription
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HolidayDescription $holidayDescription
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        HolidayDescription $holidayDescription,
        Branch $branch
    ) {
        $this->authorize('update', $holidayDescription);

        $holidayDescription->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\HolidayDescription $holidayDescription
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        HolidayDescription $holidayDescription,
        Branch $branch
    ) {
        $this->authorize('update', $holidayDescription);

        $holidayDescription->branches()->detach($branch);

        return response()->noContent();
    }
}
