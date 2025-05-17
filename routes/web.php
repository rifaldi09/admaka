<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AktifKuliahController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Data\DataDosen;
use App\Http\Controllers\Data\DataMahasiswa;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengajuanKPController;
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
// Login
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login-process', 'loginProcess')->name('login-process');
    Route::get('logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'handle.session'])->group(function () {
    // Dashboard
    Route::get('dashboard', [HomepageController::class, 'dashboard'])->name('dashboard');

    // Sesi Admin
    Route::controller(AdminController::class)->group(function () {
        // Hak Akses
        Route::get('hak-akses', 'hakAkses')->name('hak-akses');
        Route::get('edit-hak-akses/{id}', 'editHakAkses')->name('edit-hak-akses');
        Route::post('update-hak-akses', 'updateHakAkses')->name('update-hak-akses');

        // Role
        Route::post('store-role', 'storeRole')->name('store-role');
        Route::post('destroy-role/{id}', 'destroyRole')->name('destroy-role');

        // Manajemen Menu
        Route::get('manajemen-menu', 'menuAll')->name('manajemen-menu');
        Route::post('store-menu', 'storeMenu')->name('store-menu');
        Route::get('edit-menu/{id}', 'updateMenu')->name('edit-menu');
        Route::put('update-menu/{id}', 'updatedataMenu')->name('update-menu');
        Route::delete('destroy-menu/{id}', 'destroyMenu')->name('destroy-menu');
    });

    // Data Master - Mahasiswa
    Route::controller(DataMahasiswa::class)->group(function () {
        Route::get('data-mahasiswa', 'index')->name('data-mahasiswa');
        Route::post('add_mhs', 'storeMhs')->name('add_mhs');
        Route::delete('destroy-mhs/{nim}', 'destroyMhs')->name('destroy-mhs');
        Route::get('update-mhs/{nim}', 'updateMhs')->name('update-mhs');
        Route::put('update_datamhs/{nim}', 'updatedataMhs')->name('update_datamhs');
        Route::post('mhs-preview', 'previewCSV')->name('mhs-preview');
        Route::post('import-mahasiswa', 'importMahasiswa')->name('import-mahasiswa');
    });

    // Data Master - Dosen
    Route::controller(DataDosen::class)->group(function () {
        Route::get('data-dosen', 'index')->name('data-dosen');
        Route::delete('destroy-dosen/{nidn}', 'destroyDosen')->name('destroy-dosen');
        Route::post('add_dosen', 'storeDosen')->name('add_dosen');
        Route::get('update-dosen/{nim}', 'updateDosen')->name('update-dosen');
        Route::put('update_datadosen/{nim}', 'updatedataDosen')->name('update_datadosen');
        Route::post('dosen-preview',  'previewCSVDosen')->name('dosen-preview');
        Route::post('import-dosen', 'importDosen')->name('import-dosen');
    });

    // Sesi Mahasiswa
    Route::controller(MahasiswaController::class)->group(function () {
        // Akses Menu
        Route::get('lihat-profil', 'lihatProfil')->name('lihat-profil');
        Route::get('menu-mahasiswa', 'menuMahasiswa')->name('menu-mahasiswa');

        // Surat Menu
        Route::get('permohonan-kerja-praktik-mahasiswa', 'kerjaPraktik')->name('permohonan-kerja-praktik-mahasiswa');
        Route::get('aktif-kuliah-mahasiswa', 'kerjaPraktik')->name('aktif-kuliah-mahasiswa');
    });

    // Pengajuan kp
    Route::controller(PengajuanKPController::class)->group(function () {
        // Route ke halaman pengajuan KP Mahasiswa
        Route::get('Mahasiswa/pengajuan-kp', 'pengajuanKp')->name('pengajuan_kp');
        // Route ke halaman pengajuan KP Admin
        Route::get('Administrator/pengajuan-kp', 'pengajuanKpAdmin')->name('pengajuan_kp_admin');
        // Route ke halaman pengajuan KP Koordinator
        Route::get('Koordinator Kerja Praktik/pengajuan-kp', 'pengajuanKpKoordinator')->name('pengajuan-kp-koordinator');

        // mengunduh word oleh admin agar bisa di TTD oleh dekan
        Route::put('word-pengajuan/{id}', 'wordPengajuan')->name('word-pengajuan');

        // membuat surat pengajuan
        Route::post('create-pengajuan', 'createPengajuan')->name('create-pengajuan');

        // upload surat pengajuan oleh admin ketika selesai di TTD olek dekan
        Route::post('upload-pengajuan/{pengajuan:id_pengajuan}', 'uploadPengajuan')->name('upload-pengajuan');

        // pengubahan status pengajuan surat
        Route::post('terima-pengajuan/{pengajuan:id_pengajuan}', 'terimaPengajuan')->name('terima-pengajuan');
        Route::post('tolak-pengajuan/{pengajuan:id_pengajuan}', 'tolakPengajuan')->name('tolak-pengajuan');
        Route::post('edit-pengajuan/{pengajuan:id_pengajuan}', 'editPengajuan')->name('edit-pengajuan');
        Route::post('penerbitan-pengajuan/{pengajuan:id_pengajuan}', 'penerbitanPengajuan')->name('penerbitan-pengajuan');
    });

    // Surat Pengajuan Aktif Kuliah
    Route::controller(AktifKuliahController::class)->group(function () {
        // Route ke halaman Surat Aktif Kuliah Mahasiswa
        Route::get('Mahasiswa/aktif-kuliah', 'aktifKuliah')->name('Mahasiswa/aktif-kuliah');
        // Route ke halaman Surat Aktif Kuliah Mahasiswa
        Route::get('Administrator/aktif-kuliah', 'aktifKuliahAdmin')->name('Administrator/aktif-kuliah');

        // membuat surat pengajuan
        Route::post('create-surat-aktif', 'createSuratAktif')->name('create-surat-aktif');

        Route::post('upload-aktif-kuliah', 'uploadAktifKuliah')->name('upload-aktif-kuliah');
        
        // pengubahan status pengajuan surat
        Route::post('terima-aktif-kuliah', 'terimaAktifKuliah')->name('terima-aktif-kuliah'); // proses mengubah status disetujui
        Route::post('tolak-aktif-kuliah', 'tolakAktifKuliah')->name('tolak-aktif-kuliah'); // proses mengubah status ditolak
        Route::post('penerbitan-aktif-kuliah', 'penerbitanAktifKuliah')->name('penerbitan-aktif-kuliah'); // proses mengubah status penerbitan 
        Route::post('edit-penolakan-surat', 'editPenolakanSurat')->name('edit-penolakan-surat');
    });


    // Tinggal dihapus kalau tidak digunakan
    // Akses Menu
    // Route::get('lihat-profil', [MahasiswaController::class, 'lihatProfil'])->name('lihat-profil');
    // Route::get('menu-mahasiswa', [MahasiswaController::class, 'menuMahasiswa'])->name('menu-mahasiswa');

    // Surat menu
    // Route::get('permohonana-kerja-praktik-mahasiswa', [MahasiswaController::class, 'kerjaPraktik'])->name('permohonana-kerja-praktik-mahasiswa');
    // Route::get('aktif-kuliah-mahasiswa', [MahasiswaController::class, 'aktifKuliah'])->name('aktif-kuliah-mahasiswa');
    // Route::get('permohonana-kerja-praktik-mahasiswa', [MahasiswaController::class, 'kerjaPraktik'])->name('permohonana-kerja-praktik-mahasiswa');

    // Hak Akses
    // Route::get('hak-akses', [AdminController::class, 'hakAkses'])->name('hak-akses');
    // Route::get('edit-hak-akses/{id}', [AdminController::class, 'editHakAkses'])->name('edit-hak-akses');
    // Route::post('update-hak-akses', [AdminController::class, 'updateHakAkses'])->name('update-hak-akses');

    // Menamabahkan Role
    // Route::post('store-role', [AdminController::class, 'storeRole'])->name('store-role');

    // Menghapus Role
    // Route::post('destroy-role/{id}', [AdminController::class, 'destroyRole'])->name('destroy-role');

    //menambah data mahasiswa

    //Admin Data Master Mahasiswa
    // Route::get('data-mhs', [AdminController::class, 'dataMhs'])->name('data-mhs');
    // Route::post('add_mhs', [AdminController::class, 'storeMhs'])->name('add_mhs');
    // Route::delete('destroy-mhs/{nim}', [AdminController::class, 'destroyMhs'])->name('destroy-mhs');
    // Route::get('update-mhs/{nim}', [AdminController::class, 'updateMhs'])->name('update-mhs');
    // Route::put('update_datamhs/{nim}', [AdminController::class, 'updatedataMhs'])->name('update_datamhs');
    // Route::post('mhs-preview', [AdminController::class, 'previewCSV'])->name('mhs-preview');
    // Route::post('import-mahasiswa', [AdminController::class, 'importMahasiswa'])->name('import-mahasiswa');
});