<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ScratchCardConfig;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ScratchCardConfigResource;
use App\Http\Resources\ScratchCardConfigCollection;
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
            ->paginate();

        return new ScratchCardConfigCollection($scratchCardConfigs);
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

        return new ScratchCardConfigResource($scratchCardConfig);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardConfig $scratchCardConfig
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCardConfig $scratchCardConfig)
    {
        $this->authorize('view', $scratchCardConfig);

        return new ScratchCardConfigResource($scratchCardConfig);
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

        $scratchCardConfig->update($validated);

        return new ScratchCardConfigResource($scratchCardConfig);
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

        return response()->noContent();
    }
}
