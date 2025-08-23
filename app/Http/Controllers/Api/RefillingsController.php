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


class RefillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRefillingRequest $request)
    {
        if ($request->filled('month') && $request->filled('year')) {
            $query = Refilling::with('cartridge');//::query();
            $date_obj = Carbon::create($request->input('year'), $request->input('month'));
            $date_start = $date_obj->setDay(1)->startOfDay()->toDateTimeString();
            $date_end = $date_obj->endOfMonth()->endOfDay()->toDateTimeString();
            $query->whereDate('date_dispatch', '>=', $date_start);
            $query->where(function ($query) use ($date_end) {
                $query->whereDate('date_receipt', '<=', $date_end)
                      ->orWhereNull('date_receipt');
            });
            $refillings = $query->get();
            return response()->json([
                "refillings"  => new RefillingCollection($refillings)
           ]);
        } else {
            $refillings = Refilling::with('cartridge')->get();
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
        $refilling = Refilling::create($request->validated());
        return new RefillingResource($refilling);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $refilling->update($request->validated());
        return new RefillingResource($refilling);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
