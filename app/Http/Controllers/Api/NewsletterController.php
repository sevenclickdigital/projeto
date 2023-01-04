<?php

namespace App\Http\Controllers\Api;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsletterResource;
use App\Http\Resources\NewsletterCollection;
use App\Http\Requests\NewsletterStoreRequest;
use App\Http\Requests\NewsletterUpdateRequest;

class NewsletterController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Newsletter::class);

        $search = $request->get('search', '');

        $newsletters = Newsletter::search($search)
            ->latest()
            ->paginate();

        return new NewsletterCollection($newsletters);
    }

    /**
     * @param \App\Http\Requests\NewsletterStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsletterStoreRequest $request)
    {
        $this->authorize('create', Newsletter::class);

        $validated = $request->validated();

        $newsletter = Newsletter::create($validated);

        return new NewsletterResource($newsletter);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Newsletter $newsletter)
    {
        $this->authorize('view', $newsletter);

        return new NewsletterResource($newsletter);
    }

    /**
     * @param \App\Http\Requests\NewsletterUpdateRequest $request
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(
        NewsletterUpdateRequest $request,
        Newsletter $newsletter
    ) {
        $this->authorize('update', $newsletter);

        $validated = $request->validated();

        $newsletter->update($validated);

        return new NewsletterResource($newsletter);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Newsletter $newsletter)
    {
        $this->authorize('delete', $newsletter);

        $newsletter->delete();

        return response()->noContent();
    }
}
