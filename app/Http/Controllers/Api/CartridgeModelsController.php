<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartridgeModel;
use App\Http\Resources\CartridgeModel as CartridgeModelResource;
use App\Http\Resources\CartridgeModelCollection;
use App\Http\Requests\StoreCartridgeModelRequest;
use App\Http\Requests\UpdateCartridgeModelRequest;

class CartridgeModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartridgeModels = CartridgeModel::all();
        return response()->json([
            "cartridgeModels"  => new CartridgeModelCollection($cartridgeModels)
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
    public function store(StoreCartridgeModelRequest $request)
    {
        $cartridgeModel = CartridgeModel::create($request->validated());
        return new CartridgeModelResource($cartridgeModel);
    }

    /**
     * Display the specified resource.
     */
    public function show(CartridgeModel $cartridgeModel)
    {
        return response()->json([
            "cartridge"   => new CartridgeModelResource($cartridgeModel)
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
    public function update(UpdateCartridgeModelRequest $request, CartridgeModel $cartridgeModel)
    {
        $cartridgeModel->update($request->validated());
        return new CartridgeModelResource($cartridgeModel);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartridgeModel $cartridgeModel)
    {
        $cartridgeModel->delete();
        return response()->json(null, 204);
    }
}
