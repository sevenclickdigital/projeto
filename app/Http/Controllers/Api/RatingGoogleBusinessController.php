<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\RatingGoogleBusiness;
use App\Http\Controllers\Controller;
use App\Http\Resources\RatingGoogleBusinessResource;
use App\Http\Resources\RatingGoogleBusinessCollection;
use App\Http\Requests\RatingGoogleBusinessStoreRequest;
use App\Http\Requests\RatingGoogleBusinessUpdateRequest;

class RatingGoogleBusinessController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', RatingGoogleBusiness::class);

        $search = $request->get('search', '');

        $ratingGoogleBusinesses = RatingGoogleBusiness::search($search)
            ->latest()
            ->paginate();

        return new RatingGoogleBusinessCollection($ratingGoogleBusinesses);
    }

    /**
     * @param \App\Http\Requests\RatingGoogleBusinessStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingGoogleBusinessStoreRequest $request)
    {
        $this->authorize('create', RatingGoogleBusiness::class);

        $validated = $request->validated();

        $ratingGoogleBusiness = RatingGoogleBusiness::create($validated);

        return new RatingGoogleBusinessResource($ratingGoogleBusiness);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @return \Illuminate\Http\Response
     */
    public function show(
        Request $request,
        RatingGoogleBusiness $ratingGoogleBusiness
    ) {
        $this->authorize('view', $ratingGoogleBusiness);

        return new RatingGoogleBusinessResource($ratingGoogleBusiness);
    }

    /**
     * @param \App\Http\Requests\RatingGoogleBusinessUpdateRequest $request
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @return \Illuminate\Http\Response
     */
    public function update(
        RatingGoogleBusinessUpdateRequest $request,
        RatingGoogleBusiness $ratingGoogleBusiness
    ) {
        $this->authorize('update', $ratingGoogleBusiness);

        $validated = $request->validated();

        $ratingGoogleBusiness->update($validated);

        return new RatingGoogleBusinessResource($ratingGoogleBusiness);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        RatingGoogleBusiness $ratingGoogleBusiness
    ) {
        $this->authorize('delete', $ratingGoogleBusiness);

        $ratingGoogleBusiness->delete();

        return response()->noContent();
    }
}
