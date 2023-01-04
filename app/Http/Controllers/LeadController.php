<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Tenant;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Requests\LeadStoreRequest;
use App\Http\Requests\LeadUpdateRequest;

class LeadController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Lead::class);

        $search = $request->get('search', '');

        $leads = Lead::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('resources.views.leads.index', compact('leads', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Lead::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.leads.create',
            compact('tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\LeadStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeadStoreRequest $request)
    {
        $this->authorize('create', Lead::class);

        $validated = $request->validated();

        $lead = Lead::create($validated);

        $lead->branches()->attach($request->branches);

        return redirect()
            ->route('leads.edit', $lead)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Lead $lead)
    {
        $this->authorize('view', $lead);

        return view('resources.views.leads.show', compact('lead'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.leads.edit',
            compact('lead', 'tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\LeadUpdateRequest $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function update(LeadUpdateRequest $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $validated = $request->validated();
        $lead->branches()->sync($request->branches);

        $lead->update($validated);

        return redirect()
            ->route('leads.edit', $lead)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Lead $lead)
    {
        $this->authorize('delete', $lead);

        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
