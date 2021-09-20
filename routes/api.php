<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
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

/* Ticket */
Route::get('tickets/{categoryName}', [TicketController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('tickets', [TicketController::class, 'store']);
    Route::post('tickets/{category:name}', [TicketController::class, 'store']);
    Route::put('tickets/{ticket}', [TicketController::class, 'update']);
    Route::delete('tickets/{ticket}', [TicketController::class, 'destroy']);

    Route::post('tickets/{id}/comments', [CommentController::class, 'store']);
});

Route::middleware('role:admin')->prefix('admin')->group(function () {
    Route::put('tickets/pursue/{ticket}', [AdminTicketController::class, 'pursue']);
    Route::put('tickets/complete/{ticket}', [AdminTicketController::class, 'complete']);

    Route::post('/register-user', [RegisterController::class, 'register']);
    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
});


Route::get('priorities', function () {
    return response()->json(Priority::all(), 201);
});