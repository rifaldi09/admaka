<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Role\DosenController;
use App\Http\Controllers\Role\MahasiswaController;
use App\Models\AktifKuliah;
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
        $user = auth()->user();

        // User check roles
        if ($user->roles->contains('name_role', 'Mahasiswa')) {
            return $this->dashboardMahasiswa();
        } else if ($user->roles->contains('name_role', 'Dosen') || $user->roles->contains('name_role', 'Ketua Prodi') || $user->roles->contains('name_role', 'Koordinator Kerja Praktik') || $user->roles->contains('name_role', 'Koordinator Pengambilan Data') || $user->roles->contains('name_role', 'Wakil-Dekan-1')) {
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
        $belumDiterima = collect($models)->sum(fn($models) => $models::where('status', 'Belum Diterima')->where('user_id', auth()->user()->id)->count());
        $dataDiterima = collect($models)->sum(fn($models) => $models::where('status', 'Diterima')->where('user_id', auth()->user()->id)->count());
        $dataDitolak = collect($models)->sum(fn($models) => $models::where('status', 'Ditolak')->where('user_id', auth()->user()->id)->count());
        $dataPenerbitan = collect($models)->sum(fn($models) => $models::where('status', 'Penerbitan')->where('user_id', auth()->user()->id)->count());

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
        $dataPenelitian = PPDP::count();
        $dataKP = PengajuanKP::count();
        $dataTranskrip = Transkrip::count();

        // Get surat pengajuan terbaru
        $suratPengajuanTerbaru = $this->getPengajuanSuratTerbaru(2);

        return view('dashboard.indexDosen', compact('user', 'dataPenelitian', 'dataKP', 'dataTranskrip', 'suratPengajuanTerbaru'), ['titleHeader' => 'Dashboard']);
    }

    // Dashboard Admin
    public function dashboardAdmin()
    {
        // Get user log
        $user = auth()->user();

        // Get all surat data
        $dataAktif = AktifKuliah::count();
        $dataKP = PengajuanKP::count();
        $dataPenelitian = PPDP::count();
        $dataMagang = PermohonanMagang::count();
        $dataRekomendasi = SuratRekomendasi::count();
        $dataTranskrip = Transkrip::count();

        if ($user->roles->contains('name_role', 'Administrator')) {
            return view('dashboard.indexAdmin', compact('dataAktif', 'dataKP', 'dataPenelitian', 'dataMagang', 'dataRekomendasi', 'dataTranskrip'), ['titleHeader' => 'Dashboard', 'titleBody' => 'Administrator']);
        } else {
            return view('dashboard.indexSuperAdmin', compact('dataAktif', 'dataKP', 'dataPenelitian', 'dataMagang', 'dataRekomendasi', 'dataTranskrip'), ['titleHeader' => 'Dashboard', 'titleBody' => 'Super Administrator']);
        }
    }

    // Profile Page
    public function lihatProfil(MahasiswaController $mahasiswaController, DosenController $dosenController)
    {
        $user = auth()->user();

        // User check roles
        if ($user->roles->contains('name_role', 'Mahasiswa')) {
            return $mahasiswaController->lihatProfilMhs();
        } else if ($user->roles->contains('name_role', 'Dosen') || $user->roles->contains('name_role', 'Ketua Prodi') || $user->roles->contains('name_role', 'Koordinator Kerja Praktik') || $user->roles->contains('name_role', 'Koordinator Pengambilan Data') || $user->roles->contains('name_role', 'Wakil-Dekan-1')) {
            return $dosenController->lihatProfilDosen();
        } else {
            if ($user->roles->contains('name_role', 'Administrator')) {
                return view('dashboard.profileAdmin', ['titleHeader' => 'Admin']);
            } else {
                return view('dashboard.profileSuperAdmin', ['titleHeader' => 'Super Admin']);
            }
        }
    }

    // All Data Surat - Mahasiswa
    private function getSuratPenerbitanTerbaru(int $limit = 2): Collection
    {
        $suratAktif = AktifKuliah::where('status', 'Penerbitan')->where('user_id', auth()->user()->id)->get()->map(function ($item) {
            $item->jenis_surat = 'Aktif Kuliah';
            return $item;
        });
        $suratPengajuanKP = PengajuanKP::where('status', 'Penerbitan')->where('user_id', auth()->user()->id)->get()->map(function ($item) {
            $item->jenis_surat = 'Pengajuan Kerja Praktik';
            return $item;
        });
        $suratPenelitian = PPDP::where('status', 'Penerbitan')->where('user_id', auth()->user()->id)->get()->map(function ($item) {
            $item->jenis_surat = 'Permohonan Penelitian';
            return $item;
        });
        $suratMagang = PermohonanMagang::where('status', 'Penerbitan')->where('user_id', auth()->user()->id)->get()->map(function ($item) {
            $item->jenis_surat = 'Permohonan Magang';
            return $item;
        });
        $suratRekomendasi = SuratRekomendasi::where('status', 'Penerbitan')->where('user_id', auth()->user()->id)->get()->map(function ($item) {
            $item->jenis_surat = 'Rekomendasi';
            return $item;
        });
        $suratTranskrip = Transkrip::where('status', 'Penerbitan')->where('user_id', auth()->user()->id)->get()->map(function ($item) {
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
    private function getPengajuanSuratTerbaru(int $limit = 5): Collection
    {
        $suratPenelitian = PPDP::get()->map(function ($item) {
            $item->jenis_surat = 'Permohonan Penelitian';
            return $item;
        });
        $suratPengajuanKP = PengajuanKP::get()->map(function ($item) {
            $item->jenis_surat = 'Pengajuan Kerja Praktik';
            return $item;
        });
        $suratTranskrip = Transkrip::get()->map(function ($item) {
            $item->jenis_surat = 'Transkrip';
            return $item;
        });

        return collect()->merge($suratPenelitian)->merge($suratPengajuanKP)->merge($suratTranskrip)
            ->sortByDesc('created_at')->take($limit);
    }
}