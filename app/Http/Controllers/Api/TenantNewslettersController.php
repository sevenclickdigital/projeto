<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsletterResource;
use App\Http\Resources\NewsletterCollection;

class TenantNewslettersController extends Controller
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

        $newsletters = $tenant
            ->newsletters()
            ->search($search)
            ->latest()
            ->paginate();

        return new NewsletterCollection($newsletters);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Newsletter::class);

        $validated = $request->validate([
            'active' => ['required', 'boolean'],
            'sent' => ['required', 'boolean'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
        ]);

        $newsletter = $tenant->newsletters()->create($validated);

        return new NewsletterResource($newsletter);
    }
}
