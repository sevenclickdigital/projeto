<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Requests\MessageStoreRequest;
use App\Http\Requests\MessageUpdateRequest;

class MessageController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Message::class);

        $search = $request->get('search', '');

        $messages = Message::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.messages.index',
            compact('messages', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Message::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view('resources.views.messages.create', compact('tenants'));
    }

    /**
     * @param \App\Http\Requests\MessageStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageStoreRequest $request)
    {
        $this->authorize('create', Message::class);

        $validated = $request->validated();

        $message = Message::create($validated);

        return redirect()
            ->route('messages.edit', $message)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Message $message)
    {
        $this->authorize('view', $message);

        return view('resources.views.messages.show', compact('message'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Message $message)
    {
        $this->authorize('update', $message);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        return view(
            'resources.views.messages.edit',
            compact('message', 'tenants')
        );
    }

    /**
     * @param \App\Http\Requests\MessageUpdateRequest $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(MessageUpdateRequest $request, Message $message)
    {
        $this->authorize('update', $message);

        $validated = $request->validated();

        $message->update($validated);

        return redirect()
            ->route('messages.edit', $message)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Message $message)
    {
        $this->authorize('delete', $message);

        $message->delete();

        return redirect()
            ->route('messages.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
