<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Qrbilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QrbilderCollection;

class BranchQrbildersController extends Controller
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

        $qrbilders = $branch
            ->qrbilders()
            ->search($search)
            ->latest()
            ->paginate();

        return new QrbilderCollection($qrbilders);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch, Qrbilder $qrbilder)
    {
        $this->authorize('update', $branch);

        $branch->qrbilders()->syncWithoutDetaching([$qrbilder->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Branch $branch,
        Qrbilder $qrbilder
    ) {
        $this->authorize('update', $branch);

        $branch->qrbilders()->detach($qrbilder);

        return response()->noContent();
    }
}
