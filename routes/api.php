<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/',[BookingController::class,'list']);

// GET
// /api/room/availability
Route::get('room/availability/{type}/{checkin}/{checkout}',[BookingController::class,'index']);
// POST
// /api/room/reservation
Route::post('room/reservation',[BookingController::class,'store']);
// PUT
// /api/room/reservation
Route::put('room/reservation',[BookingController::class,'update']);
// DELETE
// /api/room/reservation
Route::delete('room/reservation',[BookingController::class,'destroy']);