<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Http\Resources\TenantCollection;
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
            ->paginate();

        return new TenantCollection($tenants);
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

        return new TenantResource($tenant);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Tenant $tenant)
    {
        $this->authorize('view', $tenant);

        return new TenantResource($tenant);
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

        return new TenantResource($tenant);
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

        return response()->noContent();
    }
}
