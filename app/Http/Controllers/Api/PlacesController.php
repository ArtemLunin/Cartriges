<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\PlaceCollection;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::all();
        return response()->json([
            "places"  => new PlaceCollection($places),
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
        $place = Place::create([
            "place_name" => $request->place_name,
            "comment"   => $request->comment
        ]);

        return $place;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $place = Place::find($id);
        if(!$place) {
            return response()->json([
                "status" => false,
                "message" => "Place Not Found"
            ])->setStatusCode(404, "Place Not Found");
        }
        return response()->json([
            "place"   => new PlaceResource($place)
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
        $place = Place::find($id);
        if(!$place) {
            return response()->json([
                "status" => false,
                "message" => "Place Not Found"
            ])->setStatusCode(404, "Place Not Found");
        }

        $place->place_name = $request->place_name;
        $place->comment = $request->comment;
        $place->save();
        return $place;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $place = Place::find($id);

        if(!$place) {
            return response()->json([
                "status" => false,
                "message" => "Place Not Found"
            ])->setStatusCode(404, "Place Not Found");
        }

        $place->delete();

        return response()->json([
            "status" => true,
            "message" => "Place is deleted"
        ])->setStatusCode(200, "Place is deleted");
    }
}
