<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Birthday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BirthdayCollection;

class BranchBirthdaysController extends Controller
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

        $birthdays = $branch
            ->birthdays()
            ->search($search)
            ->latest()
            ->paginate();

        return new BirthdayCollection($birthdays);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch, Birthday $birthday)
    {
        $this->authorize('update', $branch);

        $branch->birthdays()->syncWithoutDetaching([$birthday->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        Birthday $birthday
    ) {
        $this->authorize('update', $branch);

        $branch->birthdays()->detach($birthday);

        return response()->noContent();
    }
}
