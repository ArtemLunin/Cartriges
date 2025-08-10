<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Printer;
use App\Http\Resources\Printer as PrinterResource;
use App\Http\Resources\PrinterCollection;
use App\Http\Requests\UpdatePrinterRequest;
use App\Http\Requests\StorePrinterRequest;


class PrintersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $printers = Printer::with('place')->get();
        return response()->json([
            "printers"  => new PrinterCollection($printers)
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
    public function store(StorePrinterRequest $request)
    {
        // $printer = Printer::create([
        //     "model" => $request->model,
        //     "comment"   => $request->comment,
        //     "place_id"  => $request->place_id
        // ]);

        $printer = Printer::create($request->validated());
        return new PrinterResource($printer);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return Printer::find($id);
        $printer = Printer::find($id);
        if(!$printer) {
            return response()->json([
                "status" => false,
                "message" => "Printer Not Found"
            ])->setStatusCode(404, "Printer Not Found");
        }
        return response()->json([
            "printer"   => new PrinterResource($printer)
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
    public function update(UpdatePrinterRequest $request, Printer $printer)
    {
        // $printer = Printer::find($id);
        // if(!$printer) {
        //     return response()->json([
        //         "status" => false,
        //         "message" => "Printer Not Found"
        //     ])->setStatusCode(404, "Printer Not Found");
        // }

        // $printer->model = $request->model;
        // $printer->comment = $request->comment;
        // $printer->place_id = $request->place_id;
        // $printer->save();
        // return $printer;

        $printer->update($request->validated());
        return new PrinterResource($printer);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $printer = Printer::find($id);

        if(!$printer) {
            return response()->json([
                "status" => false,
                "message" => "Printer Not Found"
            ])->setStatusCode(404, "Printer Not Found");
        }

        $printer->delete();

        return response()->json([
            "status" => true,
            "message" => "Printer is deleted"
        ])->setStatusCode(200, "Printer is deleted");

    }
}
