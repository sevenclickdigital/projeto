<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardPlayerResource;
use App\Http\Resources\ScratchCardPlayerCollection;

class LeadScratchCardPlayersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Lead $lead)
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $scratchCardPlayers = $lead
            ->scratchCardPlayers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScratchCardPlayerCollection($scratchCardPlayers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lead $lead)
    {
        $this->authorize('create', ScratchCardPlayer::class);

        $validated = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'scratch_card_id' => ['required', 'exists:scratch_cards,id'],
            'winner' => ['required', 'boolean'],
        ]);

        $scratchCardPlayer = $lead->scratchCardPlayers()->create($validated);

        return new ScratchCardPlayerResource($scratchCardPlayer);
    }
}
