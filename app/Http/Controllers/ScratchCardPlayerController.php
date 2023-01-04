<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\ScratchCard;
use Illuminate\Http\Request;
use App\Models\ScratchCardPlayer;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.scratch_card_players.index',
            compact('scratchCardPlayers', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ScratchCardPlayer::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');
        $scratchCards = ScratchCard::pluck('name', 'id');
        $leads = Lead::pluck('first_name', 'id');

        return view(
            'resources.views.scratch_card_players.create',
            compact('tenants', 'scratchCards', 'leads')
        );
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

        return redirect()
            ->route('scratch-card-players.edit', $scratchCardPlayer)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardPlayer $scratchCardPlayer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCardPlayer $scratchCardPlayer)
    {
        $this->authorize('view', $scratchCardPlayer);

        return view(
            'resources.views.scratch_card_players.show',
            compact('scratchCardPlayer')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardPlayer $scratchCardPlayer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ScratchCardPlayer $scratchCardPlayer)
    {
        $this->authorize('update', $scratchCardPlayer);

        $tenants = Tenant::pluck('facebook_page_id', 'id');
        $scratchCards = ScratchCard::pluck('name', 'id');
        $leads = Lead::pluck('first_name', 'id');

        return view(
            'resources.views.scratch_card_players.edit',
            compact('scratchCardPlayer', 'tenants', 'scratchCards', 'leads')
        );
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

        return redirect()
            ->route('scratch-card-players.edit', $scratchCardPlayer)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('scratch-card-players.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
