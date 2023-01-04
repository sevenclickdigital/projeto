<?php

namespace App\Http\Controllers\Api;

use App\Models\Qrbilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\QrbilderResource;
use App\Http\Resources\QrbilderCollection;
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
            ->paginate();

        return new QrbilderCollection($qrbilders);
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

        return new QrbilderResource($qrbilder);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Qrbilder $qrbilder)
    {
        $this->authorize('view', $qrbilder);

        return new QrbilderResource($qrbilder);
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

        $qrbilder->update($validated);

        return new QrbilderResource($qrbilder);
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

        return response()->noContent();
    }
}
