<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\ScratchCardConfig;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class ScratchCardConfigBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        ScratchCardConfig $scratchCardConfig
    ) {
        $this->authorize('view', $scratchCardConfig);

        $search = $request->get('search', '');

        $branches = $scratchCardConfig
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ScratchCardConfig $scratchCardConfig,
        Branch $branch
    ) {
        $this->authorize('update', $scratchCardConfig);

        $scratchCardConfig->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ScratchCardConfig $scratchCardConfig,
        Branch $branch
    ) {
        $this->authorize('update', $scratchCardConfig);

        $scratchCardConfig->branches()->detach($branch);

        return response()->noContent();
    }
}
