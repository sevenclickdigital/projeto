<?php
namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCollection;

class LeadBranchesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Lead $lead)
    {
        $this->authorize('view', $lead);

        $search = $request->get('search', '');

        $branches = $lead
            ->branches()
            ->search($search)
            ->latest()
            ->paginate();

        return new BranchCollection($branches);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lead $lead, Branch $branch)
    {
        $this->authorize('update', $lead);

        $lead->branches()->syncWithoutDetaching([$branch->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @param \App\Models\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Lead $lead, Branch $branch)
    {
        $this->authorize('update', $lead);

        $lead->branches()->detach($branch);

        return response()->noContent();
    }
}
