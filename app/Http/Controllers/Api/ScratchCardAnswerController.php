<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ScratchCardAnswer;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScratchCardAnswerResource;
use App\Http\Resources\ScratchCardAnswerCollection;
use App\Http\Requests\ScratchCardAnswerStoreRequest;
use App\Http\Requests\ScratchCardAnswerUpdateRequest;

class ScratchCardAnswerController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ScratchCardAnswer::class);

        $search = $request->get('search', '');

        $scratchCardAnswers = ScratchCardAnswer::search($search)
            ->latest()
            ->paginate();

        return new ScratchCardAnswerCollection($scratchCardAnswers);
    }

    /**
     * @param \App\Http\Requests\ScratchCardAnswerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScratchCardAnswerStoreRequest $request)
    {
        $this->authorize('create', ScratchCardAnswer::class);

        $validated = $request->validated();

        $scratchCardAnswer = ScratchCardAnswer::create($validated);

        return new ScratchCardAnswerResource($scratchCardAnswer);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardAnswer $scratchCardAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCardAnswer $scratchCardAnswer)
    {
        $this->authorize('view', $scratchCardAnswer);

        return new ScratchCardAnswerResource($scratchCardAnswer);
    }

    /**
     * @param \App\Http\Requests\ScratchCardAnswerUpdateRequest $request
     * @param \App\Models\ScratchCardAnswer $scratchCardAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(
        ScratchCardAnswerUpdateRequest $request,
        ScratchCardAnswer $scratchCardAnswer
    ) {
        $this->authorize('update', $scratchCardAnswer);

        $validated = $request->validated();

        $scratchCardAnswer->update($validated);

        return new ScratchCardAnswerResource($scratchCardAnswer);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardAnswer $scratchCardAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        ScratchCardAnswer $scratchCardAnswer
    ) {
        $this->authorize('delete', $scratchCardAnswer);

        $scratchCardAnswer->delete();

        return response()->noContent();
    }
}
