<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function lihatProfil()
    {
        return view('mahasiswa.profile');
    }

    
    //tempat crud mahasiswa
}
