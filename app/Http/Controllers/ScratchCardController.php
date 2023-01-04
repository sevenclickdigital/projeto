<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use App\Models\ScratchCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.scratch_cards.index',
            compact('scratchCards', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ScratchCard::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.scratch_cards.create',
            compact('tenants', 'branches')
        );
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

        $scratchCard->branches()->attach($request->branches);

        return redirect()
            ->route('scratch-cards.edit', $scratchCard)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCard $scratchCard)
    {
        $this->authorize('view', $scratchCard);

        return view(
            'resources.views.scratch_cards.show',
            compact('scratchCard')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCard $scratchCard
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ScratchCard $scratchCard)
    {
        $this->authorize('update', $scratchCard);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.scratch_cards.edit',
            compact('scratchCard', 'tenants', 'branches')
        );
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

        $scratchCard->branches()->sync($request->branches);

        $scratchCard->update($validated);

        return redirect()
            ->route('scratch-cards.edit', $scratchCard)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('scratch-cards.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
