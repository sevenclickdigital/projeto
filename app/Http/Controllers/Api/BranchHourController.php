<?php

namespace App\Http\Controllers\Api;

use App\Models\BranchHour;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchHourResource;
use App\Http\Resources\BranchHourCollection;
use App\Http\Requests\BranchHourStoreRequest;
use App\Http\Requests\BranchHourUpdateRequest;

class BranchHourController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', BranchHour::class);

        $search = $request->get('search', '');

        $branchHours = BranchHour::search($search)
            ->latest()
            ->paginate();

        return new BranchHourCollection($branchHours);
    }

    /**
     * @param \App\Http\Requests\BranchHourStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchHourStoreRequest $request)
    {
        $this->authorize('create', BranchHour::class);

        $validated = $request->validated();

        $branchHour = BranchHour::create($validated);

        return new BranchHourResource($branchHour);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BranchHour $branchHour
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BranchHour $branchHour)
    {
        $this->authorize('view', $branchHour);

        return new BranchHourResource($branchHour);
    }

    /**
     * @param \App\Http\Requests\BranchHourUpdateRequest $request
     * @param \App\Models\BranchHour $branchHour
     * @return \Illuminate\Http\Response
     */
    public function update(
        BranchHourUpdateRequest $request,
        BranchHour $branchHour
    ) {
        $this->authorize('update', $branchHour);

        $validated = $request->validated();

        $branchHour->update($validated);

        return new BranchHourResource($branchHour);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BranchHour $branchHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BranchHour $branchHour)
    {
        $this->authorize('delete', $branchHour);

        $branchHour->delete();

        return response()->noContent();
    }
}
