<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Menu;

class MahasiswaController extends Controller
{
    // Profil Mahasiswa
    public function lihatProfil()
    {
        return view('mahasiswa.profile');
    }

    // surat aktif kuliah
    public function aktifKuliah()
    {
        // return view('');
    }

    // surat kerja praktik
    public function lihatProfkerjaPraktikil()
    {
        // return view('');
    }
    public function menuMahasiswa()
    {
        $menuSurat = Menu::where('header', 'Surat')->get();
        return view('mahasiswa.menu',compact('menuSurat'));
    }
    
}