<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cartridge;
use App\Http\Resources\Cartridge as CartridgeResource;
use App\Http\Resources\CartridgeCollection;
use App\Http\Requests\UpdateCartridgeRequest;
use App\Http\Requests\SearchCartridgeRequest;
use App\Http\Requests\StoreCartridgeRequest;

class CartridgesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartridges = Cartridge::with('place')->get();
        return response()->json([
            "cartridges"  => new CartridgeCollection($cartridges)
        ]);
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
    public function store(StoreCartridgeRequest $request)
    {
        $cartridge = Cartridge::create($request->validated());
        return new CartridgeResource($cartridge);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cartridge = Cartridge::findOrFail($id);
        return response()->json([
            "cartridge"   => new CartridgeResource($cartridge)
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
    // public function update(Request $request, string $id)
    public function update(UpdateCartridgeRequest $request, Cartridge $cartridge)
    {
        $cartridge->update($request->validated());
        return new CartridgeResource($cartridge);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cartridge $cartridge)
    {
        $cartridge->delete();
        return response()->json(null, 204);
    }

    public function search(SearchCartridgeRequest $request)
    {
        $cartridges = Cartridge::where('barcode', 'like', $request->validated()['query'] . '%')->with('place')->get();
        return CartridgeResource::collection($cartridges);
    }
}
