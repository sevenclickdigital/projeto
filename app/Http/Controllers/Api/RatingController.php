<?php

namespace App\Http\Controllers\Api;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RatingCollection;
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
            ->paginate();

        return new RatingCollection($ratings);
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

        return new RatingResource($rating);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Rating $rating)
    {
        $this->authorize('view', $rating);

        return new RatingResource($rating);
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

        $rating->update($validated);

        return new RatingResource($rating);
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

        return response()->noContent();
    }
}
