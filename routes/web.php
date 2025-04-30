<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MahasiswaController;
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

// Admin (sementara)
// Route, nama route, sama method diganti ke dashboard untuk sementara
Route::get('dashboard', [HomepageController::class, 'dashboard'])->name('dashboard');
Route::get('lihat-profil', [MahasiswaController::class, 'lihatProfil'])->name('lihat-profil');
Route::get('hak-akses', [AdminController::class, 'hakAkses'])->name('hak-akses');
Route::get('data-master', [AdminController::class, 'dataMaster'])->name('data-master');
Route::post('edit-hak-akses', [AdminController::class, 'editHakAkses'])->name('edit-hak-akses');

// Login
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login-process', 'loginProcess')->name('login-process');
    Route::get('logout', 'logout')->name('logout');
});
