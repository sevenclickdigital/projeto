<?php
namespace App\Http\Controllers\Api;

use App\Models\Rating;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class RatingBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Rating $rating)
    {
        $this->authorize('view', $rating);

        $search = $request->get('search', '');

        $branches = $rating
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Rating $rating, Branch $branch)
    {
        $this->authorize('update', $rating);

        $rating->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rating $rating, Branch $branch)
    {
        $this->authorize('update', $rating);

        $rating->branches()->detach($branch);

        return response()->noContent();
    }
}
