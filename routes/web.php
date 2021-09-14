<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResetPasswordController;
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

Auth::routes();

Route::post('/login', [LoginController::class, 'login']);

Route::view('/reset-password', 'auth.passwords.reset')->name('reset_password');
Route::post('/update-password', [ResetPasswordController::class, 'update'])->name('update_password');


Route::middleware(['auth', 'first_login'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/incidents', 'incidents')->name('incidents');
    Route::view('/orders', 'orders')->name('orders');
    Route::view('/questions', 'questions')->name('questions');
});


Route::name('admin.')->prefix('admin')->middleware(['role:admin'])->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('index');
    Route::view('/register-user', 'auth.register')->name('register_user');
    Route::view('/users', 'admin.users')->name('users');
});
