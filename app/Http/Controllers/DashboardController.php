<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard Page
    public function dashboard()
    {
        return view('dashboard.home');
    }

    // Mahasiswa profile page
    public function lihatProfilMhs()
    {
        $user = auth()->user()->data;

        return view('dashboard.profileMhs', compact('user'), ['titleHeader' => 'Profile Mahasiswa']);
    }

    // Dosen profile page
    public function lihatProfilDosen()
    {
        $user = auth()->user()->data;

        return view('dashboard.profileDosen', compact('user'), ['titleHeader' => 'Profile Dosen']);
    }
}
