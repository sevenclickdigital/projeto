<?php

namespace App\Http\Controllers\Api;

use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\MessageCollection;

class TenantMessagesController extends Controller
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

        $messages = $tenant
            ->messages()
            ->search($search)
            ->latest()
            ->paginate();

        return new MessageCollection($messages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tenant $tenant
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tenant $tenant)
    {
        $this->authorize('create', Message::class);

        $validated = $request->validate([
            'text' => ['required', 'max:255', 'string'],
            'read' => ['required', 'boolean'],
            'message_key' => ['required', 'max:255', 'string'],
            'sender' => ['required', 'in:user,company'],
            'sender_id' => ['nullable', 'max:255'],
            'receiver_id' => ['nullable', 'max:255'],
        ]);

        $message = $tenant->messages()->create($validated);

        return new MessageResource($message);
    }
}
