<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use App\Models\Birthday;
use Illuminate\Http\Request;
use App\Http\Requests\BirthdayStoreRequest;
use App\Http\Requests\BirthdayUpdateRequest;

class BirthdayController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Birthday::class);

        $search = $request->get('search', '');

        $birthdays = Birthday::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.birthdays.index',
            compact('birthdays', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Birthday::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.birthdays.create',
            compact('tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\BirthdayStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BirthdayStoreRequest $request)
    {
        $this->authorize('create', Birthday::class);

        $validated = $request->validated();

        $birthday = Birthday::create($validated);

        $birthday->branches()->attach($request->branches);

        return redirect()
            ->route('birthdays.edit', $birthday)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Birthday $birthday)
    {
        $this->authorize('view', $birthday);

        return view('resources.views.birthdays.show', compact('birthday'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Birthday $birthday)
    {
        $this->authorize('update', $birthday);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.birthdays.edit',
            compact('birthday', 'tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\BirthdayUpdateRequest $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function update(BirthdayUpdateRequest $request, Birthday $birthday)
    {
        $this->authorize('update', $birthday);

        $validated = $request->validated();
        $birthday->branches()->sync($request->branches);

        $birthday->update($validated);

        return redirect()
            ->route('birthdays.edit', $birthday)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Birthday $birthday)
    {
        $this->authorize('delete', $birthday);

        $birthday->delete();

        return redirect()
            ->route('birthdays.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
