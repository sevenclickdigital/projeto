<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchResource;
use App\Http\Resources\BranchCollection;

class TenantBranchesController extends Controller
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

        $branches = $tenant
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Branch::class);

        $validated = $request->validate([
            'branch_logo_path' => ['image', 'max:1024', 'nullable'],
            'branch_cover_path' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'currency' => ['nullable', 'max:3', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'slug' => ['nullable', 'max:255', 'string'],
            'phone' => ['nullable', 'max:255', 'string'],
            'cell' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'email'],
            'place_id' => ['nullable', 'numeric'],
            'coordinates' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'city' => ['nullable', 'max:255', 'string'],
            'state' => ['nullable', 'max:255', 'string'],
            'zip_code' => ['nullable', 'max:255', 'string'],
            'country' => ['nullable', 'max:255', 'string'],
        ]);

        if ($request->hasFile('branch_logo_path')) {
            $validated['branch_logo_path'] = $request
                ->file('branch_logo_path')
                ->store('public');
        }

        if ($request->hasFile('branch_cover_path')) {
            $validated['branch_cover_path'] = $request
                ->file('branch_cover_path')
                ->store('public');
        }

        $branch = $tenant->branches()->create($validated);

        return new BranchResource($branch);
    }
}
