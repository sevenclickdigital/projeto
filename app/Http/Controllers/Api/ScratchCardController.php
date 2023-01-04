<?php

namespace App\Http\Controllers\Api;

use App\Models\ScratchCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ScratchCardResource;
use App\Http\Resources\ScratchCardCollection;
use App\Http\Requests\ScratchCardStoreRequest;
use App\Http\Requests\ScratchCardUpdateRequest;

class ScratchCardController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ScratchCard::class);

        $search = $request->get('search', '');

        $scratchCards = ScratchCard::search($search)
            ->latest()
            ->paginate();

        return new ScratchCardCollection($scratchCards);
    }

    /**
     * @param \App\Http\Requests\ScratchCardStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScratchCardStoreRequest $request)
    {
        $this->authorize('create', ScratchCard::class);

        $validated = $request->validated();
        if ($request->hasFile('award_photo_path')) {
            $validated['award_photo_path'] = $request
                ->file('award_photo_path')
                ->store('public');
        }

        $scratchCard = ScratchCard::create($validated);

        return new ScratchCardResource($scratchCard);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCard $scratchCard)
    {
        $this->authorize('view', $scratchCard);

        return new ScratchCardResource($scratchCard);
    }

    /**
     * @param \App\Http\Requests\ScratchCardUpdateRequest $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function update(
        ScratchCardUpdateRequest $request,
        ScratchCard $scratchCard
    ) {
        $this->authorize('update', $scratchCard);

        $validated = $request->validated();

        if ($request->hasFile('award_photo_path')) {
            if ($scratchCard->award_photo_path) {
                Storage::delete($scratchCard->award_photo_path);
            }

            $validated['award_photo_path'] = $request
                ->file('award_photo_path')
                ->store('public');
        }

        $scratchCard->update($validated);

        return new ScratchCardResource($scratchCard);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ScratchCard $scratchCard)
    {
        $this->authorize('delete', $scratchCard);

        if ($scratchCard->award_photo_path) {
            Storage::delete($scratchCard->award_photo_path);
        }

        $scratchCard->delete();

        return response()->noContent();
    }
}
