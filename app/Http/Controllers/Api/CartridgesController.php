<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cartridge;
use App\Http\Resources\Cartridge as CartridgeResource;
use App\Http\Resources\CartridgeCollection;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string|max:50',
            'barcode' => 'string|max:10',
            'comment'   => 'nullable|string',
            'working' => 'nullable|integer|min:0',
            'place_id' => 'required|exists:places,id',
        ]);

        $cartridge = Cartridge::create($validated);
        return new CartridgeResource($cartridge);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cartridge = Cartridge::find($id);
        if(!$cartridge) {
            return response()->json([
                "status" => false,
                "message" => "Cartridge Not Found"
            ])->setStatusCode(404, "Cartridge Not Found");
        }
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
    public function update(Request $request, string $id)
    {
        $cartridge = Cartridge::find($id);
        if(!$cartridge) {
            return response()->json([
                "status" => false,
                "message" => "Cartridge Not Found"
            ])->setStatusCode(404, "Cartridge Not Found");
        }

        $cartridge->model = $request->model;
        $cartridge->barcode = $request->barcode;
        $cartridge->comment = $request->comment;
        $cartridge->working = $request->working;
        $cartridge->save();
        return $cartridge;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartridge = Cartridge::find($id);

        if(!$cartridge) {
            return response()->json([
                "status" => false,
                "message" => "Cartridge Not Found"
            ])->setStatusCode(404, "Cartridge Not Found");
        }

        $cartridge->delete();

        return response()->json([
            "status" => true,
            "message" => "Cartridge is deleted"
        ])->setStatusCode(200, "Cartridge is deleted");
    }
}
