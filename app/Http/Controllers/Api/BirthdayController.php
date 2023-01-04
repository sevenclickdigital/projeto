<?php

namespace App\Http\Controllers\Api;

use App\Models\Birthday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BirthdayResource;
use App\Http\Resources\BirthdayCollection;
use App\Http\Requests\BirthdayStoreRequest;
use App\Http\Requests\BirthdayUpdateRequest;

class BirthdayController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Birthday::class);

        $search = $request->get('search', '');

        $birthdays = Birthday::search($search)
            ->latest()
            ->paginate();

        return new BirthdayCollection($birthdays);
    }

    /**
     * @param \App\Http\Requests\BirthdayStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BirthdayStoreRequest $request)
    {
        $this->authorize('create', Birthday::class);

        $validated = $request->validated();

        $birthday = Birthday::create($validated);

        return new BirthdayResource($birthday);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Birthday $birthday)
    {
        $this->authorize('view', $birthday);

        return new BirthdayResource($birthday);
    }

    /**
     * @param \App\Http\Requests\BirthdayUpdateRequest $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function update(BirthdayUpdateRequest $request, Birthday $birthday)
    {
        $this->authorize('update', $birthday);

        $validated = $request->validated();

        $birthday->update($validated);

        return new BirthdayResource($birthday);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Birthday $birthday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Birthday $birthday)
    {
        $this->authorize('delete', $birthday);

        $birthday->delete();

        return response()->noContent();
    }
}
