<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\RatingGoogleBusiness;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.rating_google_businesses.index',
            compact('ratingGoogleBusinesses', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', RatingGoogleBusiness::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.rating_google_businesses.create',
            compact('tenants', 'branches')
        );
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

        $ratingGoogleBusiness->branches()->attach($request->branches);

        return redirect()
            ->route('rating-google-businesses.edit', $ratingGoogleBusiness)
            ->withSuccess(__('crud.common.created'));
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

        return view(
            'resources.views.rating_google_businesses.show',
            compact('ratingGoogleBusiness')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\RatingGoogleBusiness $ratingGoogleBusiness
     * @return \Illuminate\Http\Response
     */
    public function edit(
        Request $request,
        RatingGoogleBusiness $ratingGoogleBusiness
    ) {
        $this->authorize('update', $ratingGoogleBusiness);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.rating_google_businesses.edit',
            compact('ratingGoogleBusiness', 'tenants', 'branches')
        );
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
        $ratingGoogleBusiness->branches()->sync($request->branches);

        $ratingGoogleBusiness->update($validated);

        return redirect()
            ->route('rating-google-businesses.edit', $ratingGoogleBusiness)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('rating-google-businesses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
