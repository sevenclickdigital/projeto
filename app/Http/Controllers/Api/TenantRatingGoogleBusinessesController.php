<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RatingGoogleBusinessResource;
use App\Http\Resources\RatingGoogleBusinessCollection;

class TenantRatingGoogleBusinessesController extends Controller
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

        $ratingGoogleBusinesses = $tenant
            ->ratingGoogleBusinesses()
            ->search($search)
            ->latest()
            ->paginate();

        return new RatingGoogleBusinessCollection($ratingGoogleBusinesses);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', RatingGoogleBusiness::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'text' => ['nullable', 'max:255', 'string'],
            'stars' => [
                'nullable',
                'in:one_star,two_stars,three_stars,four_stars,five_stars',
            ],
        ]);

        $ratingGoogleBusiness = $tenant
            ->ratingGoogleBusinesses()
            ->create($validated);

        return new RatingGoogleBusinessResource($ratingGoogleBusiness);
    }
}
