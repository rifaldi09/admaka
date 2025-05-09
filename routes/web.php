<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengajuanKPController;
use App\Models\PengajuanKP;
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

// Akses Menu
Route::get('lihat-profil', [MahasiswaController::class, 'lihatProfil'])->name('lihat-profil');
Route::get('data-master', [AdminController::class, 'dataMaster'])->name('data-master');
Route::get('menu-mahasiswa', [MahasiswaController::class, 'menuMahasiswa'])->name('menu-mahasiswa');

// Surat menu
Route::get('permohonana-kerja-praktik-mahasiswa', [MahasiswaController::class, 'kerjaPraktik'])->name('permohonana-kerja-praktik-mahasiswa');
Route::get('aktif-kuliah-mahasiswa', [MahasiswaController::class, 'aktifKuliah'])->name('aktif-kuliah-mahasiswa');
Route::get('permohonana-kerja-praktik-mahasiswa', [MahasiswaController::class, 'kerjaPraktik'])->name('permohonana-kerja-praktik-mahasiswa');

// Hak Akses
Route::get('hak-akses', [AdminController::class, 'hakAkses'])->name('hak-akses');
Route::get('edit-hak-akses/{id}', [AdminController::class, 'editHakAkses'])->name('edit-hak-akses');
Route::post('update-hak-akses', [AdminController::class, 'updateHakAkses'])->name('update-hak-akses');

// Menamabahkan Role
Route::post('store-role', [AdminController::class, 'storeRole'])->name('store-role');

// Menghapus Role
Route::post('destroy-role/{id}', [AdminController::class, 'destroyRole'])->name('destroy-role');

//menambah data mahasiswa
Route::post('add_mhs', [MahasiswaController::class, 'storeMhs'])->name('add_mhs');

// Login
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login-process', 'loginProcess')->name('login-process');
    Route::get('logout', 'logout')->name('logout');
});

// pengajuan kp
Route::controller(PengajuanKPController::class)->group(function() {
    Route::get('pengajuan-kp', 'pengajuanKp')->name('pengajuan_kp');
    Route::get('pengajuan-kp-admin', 'pengajuanKpAdmin')->name('pengajuan_kp_admin');
    Route::get('pengajuan-kp-koordinator', 'pengajuanKpKoordinator')->name('pengajuan-kp-koordinator');
    Route::get('pdf-pengajuan/{pengajuan:id_pengajuan}', 'pdfPengajuan')->name('pdf-pengajuan');
    Route::post('create-pengajuan', 'createPengajuan')->name('create-pengajuan');
    Route::post('upload-pengajuan/{pengajuan:id_pengajuan}', 'uploadPengajuan')->name('upload-pengajuan');
    Route::post('terima-pengajuan/{pengajuan:id_pengajuan}', 'terimaPengajuan')->name('terima-pengajuan');
    Route::post('tolak-pengajuan/{pengajuan:id_pengajuan}', 'tolakPengajuan')->name('tolak-pengajuan');
    Route::post('edit-pengajuan/{pengajuan:id_pengajuan}', 'editPengajuan')->name('edit-pengajuan');
    Route::post('penerbitan-pengajuan/{pengajuan:id_pengajuan}', 'penerbitanPengajuan')->name('penerbitan-pengajuan');
});
