<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\ScratchCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardCollection;

class BranchScratchCardsController extends Controller
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

        $scratchCards = $branch
            ->scratchCards()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScratchCardCollection($scratchCards);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Branch $branch,
        ScratchCard $scratchCard
    ) {
        $this->authorize('update', $branch);

        $branch->scratchCards()->syncWithoutDetaching([$scratchCard->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        ScratchCard $scratchCard
    ) {
        $this->authorize('update', $branch);

        $branch->scratchCards()->detach($scratchCard);

        return response()->noContent();
    }
}
