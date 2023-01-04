<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ScratchCardPlayer;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardPlayerResource;
use App\Http\Resources\ScratchCardPlayerCollection;
use App\Http\Requests\ScratchCardPlayerStoreRequest;
use App\Http\Requests\ScratchCardPlayerUpdateRequest;

class ScratchCardPlayerController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ScratchCardPlayer::class);

        $search = $request->get('search', '');

        $scratchCardPlayers = ScratchCardPlayer::search($search)
            ->latest()
            ->paginate();

        return new ScratchCardPlayerCollection($scratchCardPlayers);
    }

    /**
     * @param \App\Http\Requests\ScratchCardPlayerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScratchCardPlayerStoreRequest $request)
    {
        $this->authorize('create', ScratchCardPlayer::class);

        $validated = $request->validated();

        $scratchCardPlayer = ScratchCardPlayer::create($validated);

        return new ScratchCardPlayerResource($scratchCardPlayer);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardPlayer $scratchCardPlayer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCardPlayer $scratchCardPlayer)
    {
        $this->authorize('view', $scratchCardPlayer);

        return new ScratchCardPlayerResource($scratchCardPlayer);
    }

    /**
     * @param \App\Http\Requests\ScratchCardPlayerUpdateRequest $request
     * @param \App\Models\ScratchCardPlayer $scratchCardPlayer
     * @return \Illuminate\Http\Response
     */
    public function update(
        ScratchCardPlayerUpdateRequest $request,
        ScratchCardPlayer $scratchCardPlayer
    ) {
        $this->authorize('update', $scratchCardPlayer);

        $validated = $request->validated();

        $scratchCardPlayer->update($validated);

        return new ScratchCardPlayerResource($scratchCardPlayer);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardPlayer $scratchCardPlayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ScratchCardPlayer $scratchCardPlayer
    ) {
        $this->authorize('delete', $scratchCardPlayer);

        $scratchCardPlayer->delete();

        return response()->noContent();
    }
}
