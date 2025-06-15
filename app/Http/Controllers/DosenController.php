<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    // Dosen profile page
    public function lihatProfilDosen()
    {
        $user = auth()->user()->data;

        return view('dashboard.profileDosen', compact('user'), ['titleHeader' => 'Profile Dosen']);
    }
}
