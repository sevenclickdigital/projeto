<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Birthday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class BirthdayBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Birthday $birthday)
    {
        $this->authorize('view', $birthday);

        $search = $request->get('search', '');

        $branches = $birthday
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Birthday $birthday, Branch $branch)
    {
        $this->authorize('update', $birthday);

        $birthday->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Birthday $birthday,
        Branch $branch
    ) {
        $this->authorize('update', $birthday);

        $birthday->branches()->detach($branch);

        return response()->noContent();
    }
}
