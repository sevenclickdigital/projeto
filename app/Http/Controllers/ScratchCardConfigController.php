<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\ScratchCardConfig;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ScratchCardConfigStoreRequest;
use App\Http\Requests\ScratchCardConfigUpdateRequest;

class ScratchCardConfigController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ScratchCardConfig::class);

        $search = $request->get('search', '');

        $scratchCardConfigs = ScratchCardConfig::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.scratch_card_configs.index',
            compact('scratchCardConfigs', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ScratchCardConfig::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.scratch_card_configs.create',
            compact('tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\ScratchCardConfigStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScratchCardConfigStoreRequest $request)
    {
        $this->authorize('create', ScratchCardConfig::class);

        $validated = $request->validated();
        if ($request->hasFile('winner_photo_path')) {
            $validated['winner_photo_path'] = $request
                ->file('winner_photo_path')
                ->store('public');
        }

        if ($request->hasFile('loser_photo_path')) {
            $validated['loser_photo_path'] = $request
                ->file('loser_photo_path')
                ->store('public');
        }

        $scratchCardConfig = ScratchCardConfig::create($validated);

        $scratchCardConfig->branches()->attach($request->branches);

        return redirect()
            ->route('scratch-card-configs.edit', $scratchCardConfig)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCardConfig $scratchCardConfig)
    {
        $this->authorize('view', $scratchCardConfig);

        return view(
            'resources.views.scratch_card_configs.show',
            compact('scratchCardConfig')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ScratchCardConfig $scratchCardConfig)
    {
        $this->authorize('update', $scratchCardConfig);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.scratch_card_configs.edit',
            compact('scratchCardConfig', 'tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\ScratchCardConfigUpdateRequest $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function update(
        ScratchCardConfigUpdateRequest $request,
        ScratchCardConfig $scratchCardConfig
    ) {
        $this->authorize('update', $scratchCardConfig);

        $validated = $request->validated();
        if ($request->hasFile('winner_photo_path')) {
            if ($scratchCardConfig->winner_photo_path) {
                Storage::delete($scratchCardConfig->winner_photo_path);
            }

            $validated['winner_photo_path'] = $request
                ->file('winner_photo_path')
                ->store('public');
        }

        if ($request->hasFile('loser_photo_path')) {
            if ($scratchCardConfig->loser_photo_path) {
                Storage::delete($scratchCardConfig->loser_photo_path);
            }

            $validated['loser_photo_path'] = $request
                ->file('loser_photo_path')
                ->store('public');
        }

        $scratchCardConfig->branches()->sync($request->branches);

        $scratchCardConfig->update($validated);

        return redirect()
            ->route('scratch-card-configs.edit', $scratchCardConfig)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ScratchCardConfig $scratchCardConfig
    ) {
        $this->authorize('delete', $scratchCardConfig);

        if ($scratchCardConfig->winner_photo_path) {
            Storage::delete($scratchCardConfig->winner_photo_path);
        }

        if ($scratchCardConfig->loser_photo_path) {
            Storage::delete($scratchCardConfig->loser_photo_path);
        }

        $scratchCardConfig->delete();

        return redirect()
            ->route('scratch-card-configs.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
