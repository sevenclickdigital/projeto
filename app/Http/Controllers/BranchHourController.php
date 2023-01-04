<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use App\Models\BranchHour;
use Illuminate\Http\Request;
use App\Http\Requests\BranchHourStoreRequest;
use App\Http\Requests\BranchHourUpdateRequest;

class BranchHourController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', BranchHour::class);

        $search = $request->get('search', '');

        $branchHours = BranchHour::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.branch_hours.index',
            compact('branchHours', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', BranchHour::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');
        $branches = Branch::pluck('name', 'id');

        return view(
            'resources.views.branch_hours.create',
            compact('tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\BranchHourStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchHourStoreRequest $request)
    {
        $this->authorize('create', BranchHour::class);

        $validated = $request->validated();

        $branchHour = BranchHour::create($validated);

        return redirect()
            ->route('branch-hours.edit', $branchHour)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BranchHour $branchHour
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BranchHour $branchHour)
    {
        $this->authorize('view', $branchHour);

        return view('resources.views.branch_hours.show', compact('branchHour'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BranchHour $branchHour
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, BranchHour $branchHour)
    {
        $this->authorize('update', $branchHour);

        $tenants = Tenant::pluck('facebook_page_id', 'id');
        $branches = Branch::pluck('name', 'id');

        return view(
            'resources.views.branch_hours.edit',
            compact('branchHour', 'tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\BranchHourUpdateRequest $request
     * @param \App\Models\BranchHour $branchHour
     * @return \Illuminate\Http\Response
     */
    public function update(
        BranchHourUpdateRequest $request,
        BranchHour $branchHour
    ) {
        $this->authorize('update', $branchHour);

        $validated = $request->validated();

        $branchHour->update($validated);

        return redirect()
            ->route('branch-hours.edit', $branchHour)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BranchHour $branchHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BranchHour $branchHour)
    {
        $this->authorize('delete', $branchHour);

        $branchHour->delete();

        return redirect()
            ->route('branch-hours.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
