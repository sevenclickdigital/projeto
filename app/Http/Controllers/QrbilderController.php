<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use App\Models\Qrbilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\QrbilderStoreRequest;
use App\Http\Requests\QrbilderUpdateRequest;

class QrbilderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Qrbilder::class);

        $search = $request->get('search', '');

        $qrbilders = Qrbilder::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.qrbilders.index',
            compact('qrbilders', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Qrbilder::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.qrbilders.create',
            compact('tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\QrbilderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QrbilderStoreRequest $request)
    {
        $this->authorize('create', Qrbilder::class);

        $validated = $request->validated();
        if ($request->hasFile('bilder_photo_path')) {
            $validated['bilder_photo_path'] = $request
                ->file('bilder_photo_path')
                ->store('public');
        }

        $qrbilder = Qrbilder::create($validated);

        $qrbilder->branches()->attach($request->branches);

        return redirect()
            ->route('qrbilders.edit', $qrbilder)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Qrbilder $qrbilder)
    {
        $this->authorize('view', $qrbilder);

        return view('resources.views.qrbilders.show', compact('qrbilder'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Qrbilder $qrbilder)
    {
        $this->authorize('update', $qrbilder);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.qrbilders.edit',
            compact('qrbilder', 'tenants', 'branches')
        );
    }

    /**
     * @param \App\Http\Requests\QrbilderUpdateRequest $request
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function update(QrbilderUpdateRequest $request, Qrbilder $qrbilder)
    {
        $this->authorize('update', $qrbilder);

        $validated = $request->validated();
        if ($request->hasFile('bilder_photo_path')) {
            if ($qrbilder->bilder_photo_path) {
                Storage::delete($qrbilder->bilder_photo_path);
            }

            $validated['bilder_photo_path'] = $request
                ->file('bilder_photo_path')
                ->store('public');
        }

        $qrbilder->branches()->sync($request->branches);

        $qrbilder->update($validated);

        return redirect()
            ->route('qrbilders.edit', $qrbilder)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Qrbilder $qrbilder)
    {
        $this->authorize('delete', $qrbilder);

        if ($qrbilder->bilder_photo_path) {
            Storage::delete($qrbilder->bilder_photo_path);
        }

        $qrbilder->delete();

        return redirect()
            ->route('qrbilders.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
