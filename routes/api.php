<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Priority;


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

/* Ticket */
Route::get('tickets', [TicketController::class, 'index']);
Route::get('tickets/{ticket}', [TicketController::class, 'show']);
Route::post('tickets', [TicketController::class, 'store'])->middleware('auth:sanctum');
Route::put('tickets/{ticket}', [TicketController::class, 'update'])->middleware('auth:sanctum');
Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->middleware('auth:sanctum');


Route::get('priorities', function () {
    return response()->json(Priority::all(), 201);
});