<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\ScratchCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class ScratchCardBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ScratchCard $scratchCard)
    {
        $this->authorize('view', $scratchCard);

        $search = $request->get('search', '');

        $branches = $scratchCard
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        ScratchCard $scratchCard,
        Branch $branch
    ) {
        $this->authorize('update', $scratchCard);

        $scratchCard->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ScratchCard $scratchCard,
        Branch $branch
    ) {
        $this->authorize('update', $scratchCard);

        $scratchCard->branches()->detach($branch);

        return response()->noContent();
    }
}
