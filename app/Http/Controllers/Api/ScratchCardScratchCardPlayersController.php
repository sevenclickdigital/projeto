<?php

namespace App\Http\Controllers\Api;

use App\Models\ScratchCard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardPlayerResource;
use App\Http\Resources\ScratchCardPlayerCollection;

class ScratchCardScratchCardPlayersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ScratchCard $scratchCard)
    {
        $this->authorize('view', $scratchCard);

        $search = $request->get('search', '');

        $scratchCardPlayers = $scratchCard
            ->scratchCardPlayers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScratchCardPlayerCollection($scratchCardPlayers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ScratchCard $scratchCard)
    {
        $this->authorize('create', ScratchCardPlayer::class);

        $validated = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'winner' => ['required', 'boolean'],
        ]);

        $scratchCardPlayer = $scratchCard
            ->scratchCardPlayers()
            ->create($validated);

        return new ScratchCardPlayerResource($scratchCardPlayer);
    }
}
