<?php

use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Priority;
use App\Models\User;
use Spatie\Permission\Models\Role;

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
Route::get('tickets/{categoryName}', [TicketController::class, 'index']);
// Route::get('tickets/{ticket}', [TicketController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('tickets', [TicketController::class, 'store']);
    Route::post('tickets/{category:name}', [TicketController::class, 'store']);
    Route::put('tickets/{ticket}', [TicketController::class, 'update']);
    Route::delete('tickets/{ticket}', [TicketController::class, 'destroy']);
});

Route::middleware('role:admin')->prefix('admin')->group(function () {
    Route::put('tickets/pursue/{ticket}', [App\Http\Controllers\Admin\TicketController::class, 'pursue']);
    Route::put('tickets/complete/{ticket}', [App\Http\Controllers\Admin\TicketController::class, 'complete']);
});

Route::get('priorities', function () {
    return response()->json(Priority::all(), 201);
});