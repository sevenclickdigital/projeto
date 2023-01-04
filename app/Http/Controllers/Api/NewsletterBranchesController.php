<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class NewsletterBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Newsletter $newsletter)
    {
        $this->authorize('view', $newsletter);

        $search = $request->get('search', '');

        $branches = $newsletter
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Newsletter $newsletter
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Newsletter $newsletter,
        Branch $branch
    ) {
        $this->authorize('update', $newsletter);

        $newsletter->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Newsletter $newsletter
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Newsletter $newsletter,
        Branch $branch
    ) {
        $this->authorize('update', $newsletter);

        $newsletter->branches()->detach($branch);

        return response()->noContent();
    }
}
