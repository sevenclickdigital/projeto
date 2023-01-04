<?php

namespace App\Http\Controllers\Api;

use App\Models\SocialLead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\MessageCollection;

class SocialLeadMessagesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SocialLead $socialLead
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SocialLead $socialLead)
    {
        $this->authorize('view', $socialLead);

        $search = $request->get('search', '');

        $messages = $socialLead
            ->messages()
            ->search($search)
            ->latest()
            ->paginate();

        return new MessageCollection($messages);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SocialLead $socialLead
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SocialLead $socialLead)
    {
        $this->authorize('create', Message::class);

        $validated = $request->validate([
            'text' => ['required', 'max:255', 'string'],
            'read' => ['required', 'boolean'],
            'message_key' => ['required', 'max:255', 'string'],
            'sender' => ['required', 'in:user,company'],
            'sender_id' => ['nullable', 'max:255'],
            'receiver_id' => ['nullable', 'max:255'],
            'tenant_id' => ['required', 'exists:tenants,id'],
        ]);

        $message = $socialLead->messages()->create($validated);

        return new MessageResource($message);
    }
}
