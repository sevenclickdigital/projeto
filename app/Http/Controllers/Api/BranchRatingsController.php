<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RatingCollection;

class BranchRatingsController extends Controller
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

        $ratings = $branch
            ->ratings()
            ->search($search)
            ->latest()
            ->paginate();

        return new RatingCollection($ratings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch, Rating $rating)
    {
        $this->authorize('update', $branch);

        $branch->ratings()->syncWithoutDetaching([$rating->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Branch $branch, Rating $rating)
    {
        $this->authorize('update', $branch);

        $branch->ratings()->detach($rating);

        return response()->noContent();
    }
}
