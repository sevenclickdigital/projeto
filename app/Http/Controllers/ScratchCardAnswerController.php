<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScratchCardAnswer;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.scratch_card_answers.index',
            compact('scratchCardAnswers', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ScratchCardAnswer::class);

        return view('resources.views.scratch_card_answers.create');
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

        return redirect()
            ->route('scratch-card-answers.edit', $scratchCardAnswer)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardAnswer $scratchCardAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScratchCardAnswer $scratchCardAnswer)
    {
        $this->authorize('view', $scratchCardAnswer);

        return view(
            'resources.views.scratch_card_answers.show',
            compact('scratchCardAnswer')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ScratchCardAnswer $scratchCardAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ScratchCardAnswer $scratchCardAnswer)
    {
        $this->authorize('update', $scratchCardAnswer);

        return view(
            'resources.views.scratch_card_answers.edit',
            compact('scratchCardAnswer')
        );
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

        return redirect()
            ->route('scratch-card-answers.edit', $scratchCardAnswer)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('scratch-card-answers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
