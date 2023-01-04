<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\SocialLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.social_leads.index',
            compact('socialLeads', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', SocialLead::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view('resources.views.social_leads.create', compact('tenants'));
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

        return redirect()
            ->route('social-leads.edit', $socialLead)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SocialLead $socialLead
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, SocialLead $socialLead)
    {
        $this->authorize('view', $socialLead);

        return view('resources.views.social_leads.show', compact('socialLead'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SocialLead $socialLead
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SocialLead $socialLead)
    {
        $this->authorize('update', $socialLead);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view(
            'resources.views.social_leads.edit',
            compact('socialLead', 'tenants')
        );
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

        return redirect()
            ->route('social-leads.edit', $socialLead)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('social-leads.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
