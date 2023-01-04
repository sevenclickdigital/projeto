<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardPlayerResource;
use App\Http\Resources\ScratchCardPlayerCollection;

class TenantScratchCardPlayersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        $search = $request->get('search', '');

        $scratchCardPlayers = $tenant
            ->scratchCardPlayers()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScratchCardPlayerCollection($scratchCardPlayers);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', ScratchCardPlayer::class);

        $validated = $request->validate([
            'scratch_card_id' => ['required', 'exists:scratch_cards,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'winner' => ['required', 'boolean'],
        ]);

        $scratchCardPlayer = $tenant->scratchCardPlayers()->create($validated);

        return new ScratchCardPlayerResource($scratchCardPlayer);
    }
}
