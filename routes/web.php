<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('{any}', function () {
//     return view('app');
// })->where('any', '.*');

Auth::routes();


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/incidents', function() { 
            return view('incidents'); 
        })->name('incidents');

Route::get('/orders', function() { 
            return view('orders'); 
        })->name('orders');

Route::get('/questions', function() { 
            return view('questions'); 
        })->name('questions');


Route::name('admin.')->prefix('admin')->middleware(['role:admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
});
