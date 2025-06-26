<?php

namespace App\Http\Controllers;

use App\Models\AktifKuliah;
use App\Models\FilePermohonan;
use App\Models\PengajuanKP;
use App\Models\PermohonanMagang;
use App\Models\PPDP;
use App\Models\SuratRekomendasi;
use App\Models\Transkrip;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    // Dashboard Page
    public function dashboard()
    {
        $userLog = auth()->user();

        if ($userLog->id === 1) {
            return $this->dashboardMahasiswa();
        } else if ($userLog->id === 2) {
            return $this->dashboardDosen();
        } else {
            return $this->dashboardAdmin();
        }
    }

    // Dashboard Mahasiswa
    public function dashboardMahasiswa()
    {
        // Get user data
        $user = auth()->user()->data;

        // Get all data surat
        $models = [AktifKuliah::class, PengajuanKP::class, PPDP::class, PermohonanMagang::class, SuratRekomendasi::class, Transkrip::class];

        // Count data surat
        $belumDiterima = collect($models)->sum(fn($models) => $models::where('status', 'Belum Diterima')->count());
        $dataDiterima = collect($models)->sum(fn($models) => $models::where('status', 'Diterima')->count());
        $dataDitolak = collect($models)->sum(fn($models) => $models::where('status', 'Ditolak')->count());
        $dataPenerbitan = collect($models)->sum(fn($models) => $models::where('status', 'Penerbitan')->count());

        // Get surat penerbitan terbaru
        $suratTerbaru = $this->getSuratPenerbitanTerbaru(2);

        return view('dashboard.indexMahasiswa', compact('user', 'belumDiterima', 'dataDiterima', 'dataDitolak', 'dataPenerbitan', 'suratTerbaru'), ['titleHeader' => 'Dashboard']);
    }

    // Dashboard Dosen
    public function dashboardDosen()
    {
        // Get user data
        $user = auth()->user()->data;

        // Get all surat data
        $dataPenelitian = FilePermohonan::count();
        $dataKP = PengajuanKP::count();
        $dataTranskrip = Transkrip::count();

        // Get surat pengajuan terbaru
        $suratPengajuanTerbaru = $this->getPengajuanSuratTerbaru(2);

        return view('dashboard.indexDosen', compact('user', 'dataPenelitian', 'dataKP', 'dataTranskrip', 'suratPengajuanTerbaru'), ['titleHeader' => 'Dashboard']);
    }

    // Dashboard Admin
    public function dashboardAdmin()
    {
        // Get all surat data
        $dataAktif = AktifKuliah::count();
        $dataKP = PengajuanKP::count();
        $dataPenelitian = PPDP::count();
        $dataMagang = PermohonanMagang::count();
        $dataRekomendasi = SuratRekomendasi::count();
        $dataTranskrip = Transkrip::count();

        return view('dashboard.indexAdmin', compact('dataAktif', 'dataKP', 'dataPenelitian', 'dataMagang', 'dataRekomendasi', 'dataTranskrip'), ['titleHeader' => 'Dashboard']);
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

    // All Data Surat - Mahasiswa
    private function getSuratPenerbitanTerbaru(int $limit = 2): Collection
    {
        $suratAktif = AktifKuliah::where('status', 'Penerbitan')->get()->map(function ($item) {
            $item->jenis_surat = 'Aktif Kuliah';
            return $item;
        });
        $suratPengajuanKP = PengajuanKP::where('status', 'Penerbitan')->get()->map(function ($item) {
            $item->jenis_surat = 'Pengajuan Kerja Praktik';
            return $item;
        });
        $suratPenelitian = PPDP::where('status', 'Penerbitan')->get()->map(function ($item) {
            $item->jenis_surat = 'Permohonan Penelitian';
            return $item;
        });
        $suratMagang = PermohonanMagang::where('status', 'Penerbitan')->get()->map(function ($item) {
            $item->jenis_surat = 'Permohonan Magang';
            return $item;
        });
        $suratRekomendasi = SuratRekomendasi::where('status', 'Penerbitan')->get()->map(function ($item) {
            $item->jenis_surat = 'Rekomendasi';
            return $item;
        });
        $suratTranskrip = Transkrip::where('status', 'Penerbitan')->get()->map(function ($item) {
            $item->jenis_surat = 'Transkrip';
            return $item;
        });

        return collect()->merge($suratAktif)
            ->merge($suratPengajuanKP)
            ->merge($suratPenelitian)
            ->merge($suratMagang)
            ->merge($suratRekomendasi)
            ->merge($suratTranskrip)
            ->sortByDesc('updated_at')
            ->take($limit);
    }

    // All Data Pengajuan Surat - Dosen
    private function getPengajuanSuratTerbaru(int $limit = 2): Collection
    {
        $suratPenelitian = PPDP::where('status', 'Belum Diterima')->get()->map(function ($item) {
            $item->jenis_surat = 'Permohonan Penelitian';
            return $item;
        });
        $suratPengajuanKP = PengajuanKP::where('status', 'Belum Diterima')->get()->map(function ($item) {
            $item->jenis_surat = 'Pengajuan Kerja Praktik';
            return $item;
        });
        $suratTranskrip = Transkrip::where('status', 'Belum Diterima')->get()->map(function ($item) {
            $item->jenis_surat = 'Transkrip';
            return $item;
        });

        return collect()->merge($suratPenelitian)->merge($suratPengajuanKP)->merge($suratTranskrip)
            ->sortByDesc('created_at')->take($limit);
    }
}
