<?php

namespace App\Http\Controllers\Api;

use App\Models\SocialLead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SocialLeadResource;
use App\Http\Resources\SocialLeadCollection;
use App\Http\Requests\SocialLeadStoreRequest;
use App\Http\Requests\SocialLeadUpdateRequest;

class SocialLeadController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', SocialLead::class);

        $search = $request->get('search', '');

        $socialLeads = SocialLead::search($search)
            ->latest()
            ->paginate();

        return new SocialLeadCollection($socialLeads);
    }

    /**
     * @param \App\Http\Requests\SocialLeadStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SocialLeadStoreRequest $request)
    {
        $this->authorize('create', SocialLead::class);

        $validated = $request->validated();
        if ($request->hasFile('profile_photo_path')) {
            $validated['profile_photo_path'] = $request
                ->file('profile_photo_path')
                ->store('public');
        }

        $socialLead = SocialLead::create($validated);

        return new SocialLeadResource($socialLead);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SocialLead $socialLead
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SocialLead $socialLead)
    {
        $this->authorize('view', $socialLead);

        return new SocialLeadResource($socialLead);
    }

    /**
     * @param \App\Http\Requests\SocialLeadUpdateRequest $request
     * @param \App\Models\SocialLead $socialLead
     * @return \Illuminate\Http\Response
     */
    public function update(
        SocialLeadUpdateRequest $request,
        SocialLead $socialLead
    ) {
        $this->authorize('update', $socialLead);

        $validated = $request->validated();

        if ($request->hasFile('profile_photo_path')) {
            if ($socialLead->profile_photo_path) {
                Storage::delete($socialLead->profile_photo_path);
            }

            $validated['profile_photo_path'] = $request
                ->file('profile_photo_path')
                ->store('public');
        }

        $socialLead->update($validated);

        return new SocialLeadResource($socialLead);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SocialLead $socialLead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SocialLead $socialLead)
    {
        $this->authorize('delete', $socialLead);

        if ($socialLead->profile_photo_path) {
            Storage::delete($socialLead->profile_photo_path);
        }

        $socialLead->delete();

        return response()->noContent();
    }
}
