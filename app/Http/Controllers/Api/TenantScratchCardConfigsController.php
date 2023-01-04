<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardConfigResource;
use App\Http\Resources\ScratchCardConfigCollection;

class TenantScratchCardConfigsController extends Controller
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

        $scratchCardConfigs = $tenant
            ->scratchCardConfigs()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScratchCardConfigCollection($scratchCardConfigs);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', ScratchCardConfig::class);

        $validated = $request->validate([
            'Keyword' => ['required', 'max:255', 'string'],
            'when_send' => [
                'required',
                'in:no_send,one_week,two_weeks,one_month',
            ],
            'winner_photo_path' => ['image', 'max:1024', 'required'],
            'loser_photo_path' => ['image', 'max:1024', 'required'],
        ]);

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

        $scratchCardConfig = $tenant->scratchCardConfigs()->create($validated);

        return new ScratchCardConfigResource($scratchCardConfig);
    }
}
