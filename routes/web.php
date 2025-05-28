<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AktifKuliahController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Data\DataDosen;
use App\Http\Controllers\Data\DataMahasiswa;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengajuanKPController;
use App\Http\Controllers\PermohonanMagangController;
use App\Http\Controllers\PPDPController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\TranskripController;
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
        Route::put('tolak-pengajuan/{pengajuan:id_pengajuan}', 'tolakPengajuan')->name('tolak-pengajuan');
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
        Route::post('penerbitan-aktif-kuliah/{id}', 'penerbitanAktifKuliah')->name('penerbitan-aktif-kuliah'); // proses mengubah status penerbitan 
        Route::post('edit-penolakan-surat', 'editPenolakanSurat')->name('edit-penolakan-surat');
        Route::post('unduh-pdf-surat-aktif-kuliah', 'unduhPDF')->name('unduh-pdf-surat-aktif-kuliah');
    });

    // Permohonan Pengambilan Data Penelitian
    Route::controller(PPDPController::class)->group(function() {
        // Route get untuk tampilan awal mahasiswa,admin,dosen-koordinator
        Route::get('Mahasiswa/permohonan-pengambilan', 'ppdpMahasiswa')->name('ppdp-mahasiswa');
        Route::get('Administrator/permohonan-pengambilan', 'ppdpAdmin')->name('ppdp-admin');
        Route::get('Koordinator Pengambilan Data/permohonan-pengambilan', 'ppdpKoordinator')->name('ppdp-koordinator');
        Route::get('Dosen/permohonan-pengambilan', 'ppdpDosen')->name('ppdp-dosen');

        // membuat surat permohonan - mahasiswa
        Route::post('create-permohonan-mahasiswa', 'createPermohonan')->name('create-permohonan-mahasiswa');

        // upload surat permohonan jika sudah di tanda tangani- admin (TU)
        Route::post('upload-permohonan/{permohonan:id_permohonan}', 'uploadPermohonan')->name('upload-permohonan');

        // generate surat dengan format docx/word - admin
        Route::put('generate-permohonan/{permohonan:id_permohonan}', 'generatePermohonan')->name('generate-permohonan');
        
        // route buat ubah status surat permohonan
        Route::put('terima-permohonan-mahasiswa/{permohonan:id_permohonan}', 'terimaPermohonan')->name('terima-permohonan-mahasiswa');
        Route::put('penerbitan-permohonan/{permohonan:id_permohonan}', 'penerbitanPermohonan')->name('penerbitan-permohonan');
        Route::put('tolak-permohonan/{permohonan:id_permohonan}', 'tolakPermohonan')->name('tolak-permohonan');
        Route::put('edit-permohonan/{permohonan:id_permohonan}', 'editPermohonan')->name('edit-permohonan');
    });

    // Transkrip Nilai
    Route::controller(TranskripController::class)->group(function() {
        // route ke halaman masing-masing tiap role
        Route::get('Mahasiswa/transkrip', 'transkripMahasiswa')->name('transkrip-mahasiswa');
        Route::get('Administrator/transkrip', 'transkripAdmin')->name('transkrip-admin');
        Route::get('Wakil-Dekan-1/transkrip', 'transkripWD')->name('transkrip-wd');

        // route upload / buat data baru
        Route::post('create-transkrip', 'createTranskrip')->name('create-transkrip');
        Route::post('upload-transkrip/{transkrip:id_transkrip}', 'uploadTranskrip')->name('upload-transkrip');

        // route put untuk ubah status transkrip
        Route::put('terima-transkrip/{transkrip:id_transkrip}', 'terimaTranskrip')->name('terima-transkrip');
        Route::put('penerbitan-transkrip/{transkrip:id_transkrip}', 'penerbitanTranskrip')->name('penerbitan-transkrip');
        Route::put('tolak-transkrip/{transkrip:id_transkrip}', 'tolakTranskrip')->name('tolak-transkrip');
        Route::put('edit-transkrip/{transkrip:id_transkrip}', 'editTranskrip')->name('edit-transkrip');
    });

    Route::controller(PermohonanMagangController::class)->group(function() {
        Route::get('Mahasiswa/permohonan-magang','PermohonanMagangMahasiswa')->name('permohonan-magang-mahasiswa');
        Route::get('Administrator/permohonan-magang','PermohonanMagangAdmin')->name('permohonan-magang-admin');
        Route::get('Koordinator Kerja Praktik/permohonan-magang','PermohonanMagangKKP')->name('permohonan-magang-kkp');

        // mengunduh word oleh admin agar bisa di TTD oleh dekan
        Route::put('word-permohonan-magang/{id}', 'wordPermohonan')->name('word-permohonan-magang');

        // membuat surat pengajuan
        Route::post('create-permohonan-magang', 'createPermohonan')->name('create-permohonan-magang');

        // upload surat pengajuan oleh admin ketika selesai di TTD olek dekan
        Route::post('upload-permohonan-magang/{permohonan:id_permohonan_magang}', 'uploadPermohonan')->name('upload-permohonan-magang');

        // pengubahan status pengajuan surat
        Route::post('terima-permohonan-magang/{permohonan:id_permohonan_magang}', 'terimaPermohonan')->name('terima-permohonan-magang');
        Route::put('tolak-permohonan-magang/{permohonan:id_permohonan_magang}', 'tolakPermohonan')->name('tolak-permohonan-magang');
        Route::post('edit-permohonan-magang/{permohonan:id_permohonan_magang}', 'editPermohonan')->name('edit-permohonan-magang');
        Route::post('penerbitan-permohonan-magang/{permohonan:id_permohonan_magang}', 'penerbitanPermohonan')->name('penerbitan-permohonan-magang');
    });

    Route::controller(RekomendasiController::class)->group(function(){
        Route::get('Mahasiswa/surat-rekomendasi', 'rekomendasiMahasiswa')->name('surat-rekomendasi');
        Route::get('Administrator/surat-rekomendasi','rekomendasiAdmin')->name('surat-rekomendasi');
        Route::post('create-surat-rekomendasi', 'createRekomendasi')->name('create-surat-rekomendasi');
        Route::post('edit-penolakan-rekomendasi', 'editRekomendasiMahasiswa')->name('edit-penolakan-rekomendasi');
        Route::post('terima-surat-rekomendasi', 'terimaSuratRekomendasi')->name('terima-surat-rekomendasi');
        Route::post('tolak-surat-rekomendasi', 'tolakSuratRekomendasi')->name('tolak-surat-rekomendasi');
        Route::post('penerbitan-surat-rekomendasi/{id}', 'penerbitanSuratRekomendasi')->name('penerbitan-surat-rekomendasi');
        Route::post('upload-surat-rekomendasi', 'uploadSuratRekomendasi')->name('upload-surat-rekomendasi');
        Route::post('unduh-pdf-surat-rekomendasi', 'unduhSuratRekomendasi')->name('unduh-pdf-surat-rekomendasi');
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