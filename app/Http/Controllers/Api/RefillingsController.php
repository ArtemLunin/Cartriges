<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Refilling;
use App\Http\Resources\Refilling as RefillingResource;
use App\Http\Resources\RefillingCollection;
use App\Http\Requests\StoreRefillingRequest;
use App\Http\Requests\UpdateRefillingRequest;
use App\Http\Requests\IndexRefillingRequest;
use Illuminate\Validation\ValidationException;


class RefillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRefillingRequest $request)
    {
        if ($request->filled('month') && $request->filled('year')) {
            $query = Refilling::with(['cartridge', 'cartridge.model']);//::query();
            $date_obj = Carbon::create($request->input('year'), $request->input('month'));
            $date_start = $date_obj->setDay(1)->startOfDay()->toDateTimeString();
            $date_end = $date_obj->endOfMonth()->endOfDay()->toDateTimeString();
            $query->whereDate('date_dispatch', '>=', $date_start);
            $query->where(function ($query) use ($date_end) {
                $query->whereDate('date_dispatch', '<=', $date_end);
                    //   ->orWhereNull('date_dispatch');
            });
            $refillings = $query->get();
            return response()->json([
                "refillings"  => new RefillingCollection($refillings)
           ]);
        } else {
            $refillings = Refilling::with(['cartridge', 'cartridge.model'])->get();
            return response()->json([
                "refillings"  => new RefillingCollection($refillings)
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRefillingRequest $request)
    {
        $validated = $request->validated();
        $this->checkConsistency($validated);
        $refilling = Refilling::create($validated);
        return new RefillingResource($refilling);
    }

    /**
     * Display the specified resource.
     */
    public function show(Refilling $refilling)
    {
        $refilling->load(['cartridge', 'cartridge.model']);
        return response()->json([
            "refilling"  => new RefillingResource($refilling)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRefillingRequest $request, Refilling $refilling)
    {
        $validated = $request->validated();
        // $this->checkConsistency($refilling, $validated);
        $refilling->update($validated);
        return new RefillingResource($refilling);
    }

    protected function checkConsistency(array $validated): void
    {
        if (isset($validated['date_dispatch'])) {
            $latest_date_dispatch = Refilling::where('cartridge_id', $validated['cartridge_id'])
                ->orderBy('date_dispatch', 'desc')
                ->first();

            if ($latest_date_dispatch && $latest_date_dispatch->date_dispatch >= $validated['date_dispatch']) {
                throw ValidationException::withMessages([
                    'date_dispatch' => 'The date_dispatch date cannot be earlier than the latest date_dispatch date (' . $latest_date_dispatch->date_dispatch . ').',
                ]);
            }
        }

        // \Log::info('Consistency check passed for Refilling', [
        //     'refilling_id' => $validated['cartridge_id'],
        //     'validated' => $validated,
        // ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Refilling $refilling)
    {
        $refilling->delete();
        return response()->json(null, 204);
    }
}
