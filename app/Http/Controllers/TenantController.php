<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Requests\TenantStoreRequest;
use App\Http\Requests\TenantUpdateRequest;

class TenantController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Tenant::class);

        $search = $request->get('search', '');

        $tenants = Tenant::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.tenants.index',
            compact('tenants', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Tenant::class);

        return view('resources.views.tenants.create');
    }

    /**
     * @param \App\Http\Requests\TenantStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenantStoreRequest $request)
    {
        $this->authorize('create', Tenant::class);

        $validated = $request->validated();

        $tenant = Tenant::create($validated);

        return redirect()
            ->route('tenants.edit', $tenant)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        return view('resources.views.tenants.show', compact('tenant'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        return view('resources.views.tenants.edit', compact('tenant'));
    }

    /**
     * @param \App\Http\Requests\TenantUpdateRequest $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(TenantUpdateRequest $request, Tenant $tenant)
    {
        $this->authorize('update', $tenant);

        $validated = $request->validated();

        $tenant->update($validated);

        return redirect()
            ->route('tenants.edit', $tenant)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tenant $tenant)
    {
        $this->authorize('delete', $tenant);

        $tenant->delete();

        return redirect()
            ->route('tenants.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
