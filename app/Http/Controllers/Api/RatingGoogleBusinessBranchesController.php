<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RatingGoogleBusiness;
use App\Http\Resources\BranchCollection;

class RatingGoogleBusinessBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        RatingGoogleBusiness $ratingGoogleBusiness
    ) {
        $this->authorize('view', $ratingGoogleBusiness);

        $search = $request->get('search', '');

        $branches = $ratingGoogleBusiness
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        RatingGoogleBusiness $ratingGoogleBusiness,
        Branch $branch
    ) {
        $this->authorize('update', $ratingGoogleBusiness);

        $ratingGoogleBusiness->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        RatingGoogleBusiness $ratingGoogleBusiness,
        Branch $branch
    ) {
        $this->authorize('update', $ratingGoogleBusiness);

        $ratingGoogleBusiness->branches()->detach($branch);

        return response()->noContent();
    }
}
