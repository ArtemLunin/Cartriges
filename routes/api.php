<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PrintersController;
use App\Http\Controllers\Api\PlacesController;
use App\Http\Controllers\Api\CartridgesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('printers', PrintersController::class);
Route::apiResource('places', PlacesController::class);
Route::apiResource('cartridges', CartridgesController::class);