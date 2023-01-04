<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\ScratchCardConfig;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardConfigCollection;

class BranchScratchCardConfigsController extends Controller
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

        $scratchCardConfigs = $branch
            ->scratchCardConfigs()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScratchCardConfigCollection($scratchCardConfigs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Branch $branch,
        ScratchCardConfig $scratchCardConfig
    ) {
        $this->authorize('update', $branch);

        $branch
            ->scratchCardConfigs()
            ->syncWithoutDetaching([$scratchCardConfig->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        ScratchCardConfig $scratchCardConfig
    ) {
        $this->authorize('update', $branch);

        $branch->scratchCardConfigs()->detach($scratchCardConfig);

        return response()->noContent();
    }
}
