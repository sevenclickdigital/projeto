<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SocialLeadResource;
use App\Http\Resources\SocialLeadCollection;

class TenantSocialLeadsController extends Controller
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

        $socialLeads = $tenant
            ->socialLeads()
            ->search($search)
            ->latest()
            ->paginate();

        return new SocialLeadCollection($socialLeads);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', SocialLead::class);

        $validated = $request->validate([
            'active' => ['required', 'boolean'],
            'profile_photo_path' => ['image', 'max:1024', 'nullable'],
            'social_id' => ['nullable', 'max:255', 'string'],
            'social_key' => ['nullable', 'max:255', 'string'],
            'social_type' => ['required', 'in:instagram,facebook,whatsapp'],
        ]);

        if ($request->hasFile('profile_photo_path')) {
            $validated['profile_photo_path'] = $request
                ->file('profile_photo_path')
                ->store('public');
        }

        $socialLead = $tenant->socialLeads()->create($validated);

        return new SocialLeadResource($socialLead);
    }
}
