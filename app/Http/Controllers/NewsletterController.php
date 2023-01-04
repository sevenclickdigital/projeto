<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Branch;
use App\Models\Newsletter;
use Illuminate\Http\Request;
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
            ->paginate(5)
            ->withQueryString();

        return view(
            'resources.views.newsletters.index',
            compact('newsletters', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Newsletter::class);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.newsletters.create',
            compact('tenants', 'branches')
        );
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

        $newsletter->branches()->attach($request->branches);

        return redirect()
            ->route('newsletters.edit', $newsletter)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Newsletter $newsletter)
    {
        $this->authorize('view', $newsletter);

        return view('resources.views.newsletters.show', compact('newsletter'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Newsletter $newsletter)
    {
        $this->authorize('update', $newsletter);

        $tenants = Tenant::pluck('facebook_page_id', 'id');

        $branches = Branch::get();

        return view(
            'resources.views.newsletters.edit',
            compact('newsletter', 'tenants', 'branches')
        );
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
        $newsletter->branches()->sync($request->branches);

        $newsletter->update($validated);

        return redirect()
            ->route('newsletters.edit', $newsletter)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('newsletters.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
