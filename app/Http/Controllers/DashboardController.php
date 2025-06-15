<?php

namespace App\Http\Controllers;

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
            return "Sesi Admin";
        }
    }

    // Dashboard Mahasiswa
    public function dashboardMahasiswa()
    {
        $user = auth()->user()->data;

        return view('dashboard.indexMahasiswa', compact('user'), ['titleHeader' => 'Dashboard']);
    }

    // Dashboard Dosen
    public function dashboardDosen()
    {
        $user = auth()->user()->data;

        return view('dashboard.indexDosen', compact('user'), ['titleHeader' => 'Dashboard']);
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
