<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsletterCollection;

class BranchNewslettersController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Branch $branch)
    {
        $this->authorize('view', $branch);

        $search = $request->get('search', '');

        $newsletters = $branch
            ->newsletters()
            ->search($search)
            ->latest()
            ->paginate();

        return new NewsletterCollection($newsletters);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Branch $branch,
        Newsletter $newsletter
    ) {
        $this->authorize('update', $branch);

        $branch->newsletters()->syncWithoutDetaching([$newsletter->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Newsletter $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        Newsletter $newsletter
    ) {
        $this->authorize('update', $branch);

        $branch->newsletters()->detach($newsletter);

        return response()->noContent();
    }
}
