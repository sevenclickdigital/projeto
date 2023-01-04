<?php
namespace App\Http\Controllers\Api;

use App\Models\Branch;
use App\Models\Qrbilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class QrbilderBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qrbilder $qrbilder
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Qrbilder $qrbilder)
    {
        $this->authorize('view', $qrbilder);

        $search = $request->get('search', '');

        $branches = $qrbilder
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qrbilder $qrbilder
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Qrbilder $qrbilder, Branch $branch)
    {
        $this->authorize('update', $qrbilder);

        $qrbilder->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Qrbilder $qrbilder
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Qrbilder $qrbilder,
        Branch $branch
    ) {
        $this->authorize('update', $qrbilder);

        $qrbilder->branches()->detach($branch);

        return response()->noContent();
    }
}
