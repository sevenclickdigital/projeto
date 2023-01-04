<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QrbilderResource;
use App\Http\Resources\QrbilderCollection;

class TenantQrbildersController extends Controller
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

        $qrbilders = $tenant
            ->qrbilders()
            ->search($search)
            ->latest()
            ->paginate();

        return new QrbilderCollection($qrbilders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Qrbilder::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'bilder_photo_path' => ['image', 'max:1024', 'nullable'],
        ]);

        if ($request->hasFile('bilder_photo_path')) {
            $validated['bilder_photo_path'] = $request
                ->file('bilder_photo_path')
                ->store('public');
        }

        $qrbilder = $tenant->qrbilders()->create($validated);

        return new QrbilderResource($qrbilder);
    }
}
