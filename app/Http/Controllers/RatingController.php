<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Tenant;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RatingStoreRequest;
use App\Http\Requests\RatingUpdateRequest;

class RatingController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Rating::class);

        $search = $request->get('search', '');

        $ratings = Rating::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.ratings.index',
            compact('ratings', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Rating::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view('resources.views.ratings.create', compact('tenants'));
    }

    /**
     * @param \App\Http\Requests\RatingStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RatingStoreRequest $request)
    {
        $this->authorize('create', Rating::class);

        $validated = $request->validated();
        if ($request->hasFile('award_photo_path')) {
            $validated['award_photo_path'] = $request
                ->file('award_photo_path')
                ->store('public');
        }

        $rating = Rating::create($validated);

        return redirect()
            ->route('ratings.edit', $rating)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Rating $rating)
    {
        $this->authorize('view', $rating);

        return view('resources.views.ratings.show', compact('rating'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.ratings.edit',
            compact('rating', 'tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\RatingUpdateRequest $request
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function update(RatingUpdateRequest $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $validated = $request->validated();
        if ($request->hasFile('award_photo_path')) {
            if ($rating->award_photo_path) {
                Storage::delete($rating->award_photo_path);
            }

            $validated['award_photo_path'] = $request
                ->file('award_photo_path')
                ->store('public');
        }

        $rating->branches()->sync($request->branches);

        $rating->update($validated);

        return redirect()
            ->route('ratings.edit', $rating)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rating $rating)
    {
        $this->authorize('delete', $rating);

        if ($rating->award_photo_path) {
            Storage::delete($rating->award_photo_path);
        }

        $rating->delete();

        return redirect()
            ->route('ratings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
