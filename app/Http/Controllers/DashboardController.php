<?php

namespace App\Http\Controllers;

use App\Models\AktifKuliah;
use App\Models\FilePermohonan;
use App\Models\PengajuanKP;
use App\Models\PermohonanMagang;
use App\Models\SuratRekomendasi;
use App\Models\Transkrip;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard Page
    public function dashboard()
    {
        // return view('dashboard.home');
        $userLog = auth()->user();

        if ($userLog->id === 1) {
            return $this->dashboardMahasiswa();
        } else if ($userLog->id === 2) {
            return $this->dashboardDosen();
        } else {
            // return "Sesi Admin";
            return view('dashboard.home');
        }
    }

    // Dashboard Mahasiswa
    public function dashboardMahasiswa()
    {
        // Get all surat data
        $dataAktif = AktifKuliah::count();
        $dataKP = PengajuanKP::count();
        $dataPenelitian = FilePermohonan::count();
        $dataMagang = PermohonanMagang::count();
        $dataRekomendasi = SuratRekomendasi::count();
        $dataTranskrip = Transkrip::count();

        // Get user data
        $user = auth()->user()->data;

        return view('dashboard.indexMahasiswa', compact('user', 'dataAktif', 'dataKP', 'dataPenelitian', 'dataMagang', 'dataRekomendasi', 'dataTranskrip'), ['titleHeader' => 'Dashboard']);
    }

    // Dashboard Dosen
    public function dashboardDosen()
    {
        // Get all surat data
        $dataPenelitian = FilePermohonan::count();
        $dataKP = PengajuanKP::count();
        $dataTranskrip = Transkrip::count();

        // Get user data
        $user = auth()->user()->data;

        return view('dashboard.indexDosen', compact('user', 'dataPenelitian', 'dataKP', 'dataTranskrip'), ['titleHeader' => 'Dashboard']);
    }

    // Profile Page
    public function lihatProfil(MahasiswaController $mahasiswaController, DosenController $dosenController)
    {
        $userLog = auth()->user();

        if ($userLog->id === 1) {
            return $mahasiswaController->lihatProfilMhs();
        } else if ($userLog->id === 2) {
            return $dosenController->lihatProfilDosen();
        } else {
            return "Sesi Admin";
        }
    }
}
