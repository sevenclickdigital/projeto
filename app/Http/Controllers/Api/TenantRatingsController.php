<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Http\Resources\RatingCollection;

class TenantRatingsController extends Controller
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

        $ratings = $tenant
            ->ratings()
            ->search($search)
            ->latest()
            ->paginate();

        return new RatingCollection($ratings);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Rating::class);

        $validated = $request->validate([
            'active' => ['required', 'boolean'],
            'award_photo_path' => ['image', 'max:1024', 'nullable'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
        ]);

        if ($request->hasFile('award_photo_path')) {
            $validated['award_photo_path'] = $request
                ->file('award_photo_path')
                ->store('public');
        }

        $rating = $tenant->ratings()->create($validated);

        return new RatingResource($rating);
    }
}
