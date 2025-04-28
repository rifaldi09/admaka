<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomepageController::class, "index"])->name('home');

// Admin LTE (sementara)
// Route, nama route, sama method diganti ke dashboard untuk sementara
Route::get('dashboard', [HomepageController::class, 'dashboard'])->name('dashboard');

// Login
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login-process', 'loginProcess')->name('login-process');
    Route::get('logout', 'logout')->name('logout');
});
