<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RatingGoogleBusiness;
use App\Http\Resources\RatingGoogleBusinessCollection;

class BranchRatingGoogleBusinessesController extends Controller
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

        $ratingGoogleBusinesses = $branch
            ->ratingGoogleBusinesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new RatingGoogleBusinessCollection($ratingGoogleBusinesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Branch $branch,
        RatingGoogleBusiness $ratingGoogleBusiness
    ) {
        $this->authorize('update', $branch);

        $branch
            ->ratingGoogleBusinesses()
            ->syncWithoutDetaching([$ratingGoogleBusiness->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        RatingGoogleBusiness $ratingGoogleBusiness
    ) {
        $this->authorize('update', $branch);

        $branch->ratingGoogleBusinesses()->detach($ratingGoogleBusiness);

        return response()->noContent();
    }
}
