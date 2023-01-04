<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardResource;
use App\Http\Resources\ScratchCardCollection;

class TenantScratchCardsController extends Controller
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

        $scratchCards = $tenant
            ->scratchCards()
            ->search($search)
            ->latest()
            ->paginate();

        return new ScratchCardCollection($scratchCards);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', ScratchCard::class);

        $validated = $request->validate([
            'published' => ['required', 'in:published,draft,archived'],
            'award_photo_path' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'Keyword' => ['nullable', 'max:255', 'string'],
            'chances_of_winning' => ['required', 'numeric'],
            ' play_number' => ['required', 'numeric'],
            'show_day' => ['required', 'max:255', 'string'],
            'prize_availability' => ['required', 'in:always,date'],
            'prize_date_end' => ['nullable', 'date'],
        ]);

        if ($request->hasFile('award_photo_path')) {
            $validated['award_photo_path'] = $request
                ->file('award_photo_path')
                ->store('public');
        }

        $scratchCard = $tenant->scratchCards()->create($validated);

        return new ScratchCardResource($scratchCard);
    }
}
