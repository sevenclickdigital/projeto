<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\MessageCollection;
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
            ->paginate();

        return new MessageCollection($messages);
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

        return new MessageResource($message);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Message $message)
    {
        $this->authorize('view', $message);

        return new MessageResource($message);
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

        return new MessageResource($message);
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

        return response()->noContent();
    }
}
