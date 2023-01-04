<?php
namespace App\Http\Controllers\Api;

use App\Models\Lead;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadCollection;

class BranchLeadsController extends Controller
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

        $leads = $branch
            ->leads()
            ->search($search)
            ->latest()
            ->paginate();

        return new LeadCollection($leads);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch, Lead $lead)
    {
        $this->authorize('update', $branch);

        $branch->leads()->syncWithoutDetaching([$lead->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Branch $branch
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Branch $branch, Lead $lead)
    {
        $this->authorize('update', $branch);

        $branch->leads()->detach($lead);

        return response()->noContent();
    }
}
