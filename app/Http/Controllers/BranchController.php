<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BranchStoreRequest;
use App\Http\Requests\BranchUpdateRequest;

class BranchController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Branch::class);

        $search = $request->get('search', '');

        $branches = Branch::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.branches.index',
            compact('branches', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Branch::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view('resources.views.branches.create', compact('tenants'));
    }

    /**
     * @param \App\Http\Requests\BranchStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchStoreRequest $request)
    {
        $this->authorize('create', Branch::class);

        $validated = $request->validated();
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

        $branch = Branch::create($validated);

        return redirect()
            ->route('branches.edit', $branch)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Branch $branch)
    {
        $this->authorize('view', $branch);

        return view('resources.views.branches.show', compact('branch'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Branch $branch)
    {
        $this->authorize('update', $branch);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view(
            'resources.views.branches.edit',
            compact('branch', 'tenants')
        );
    }

    /**
     * @param \App\Http\Requests\BranchUpdateRequest $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function update(BranchUpdateRequest $request, Branch $branch)
    {
        $this->authorize('update', $branch);

        $validated = $request->validated();
        if ($request->hasFile('branch_logo_path')) {
            if ($branch->branch_logo_path) {
                Storage::delete($branch->branch_logo_path);
            }

            $validated['branch_logo_path'] = $request
                ->file('branch_logo_path')
                ->store('public');
        }

        if ($request->hasFile('branch_cover_path')) {
            if ($branch->branch_cover_path) {
                Storage::delete($branch->branch_cover_path);
            }

            $validated['branch_cover_path'] = $request
                ->file('branch_cover_path')
                ->store('public');
        }

        $branch->update($validated);

        return redirect()
            ->route('branches.edit', $branch)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Branch $branch)
    {
        $this->authorize('delete', $branch);

        if ($branch->branch_logo_path) {
            Storage::delete($branch->branch_logo_path);
        }

        if ($branch->branch_cover_path) {
            Storage::delete($branch->branch_cover_path);
        }

        $branch->delete();

        return redirect()
            ->route('branches.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
