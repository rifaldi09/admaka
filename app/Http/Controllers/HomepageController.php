<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\RoleAkses;
use App\Models\HakAkses;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        return view('homepage.index');
    }

    // untuk kehalaman admin LTE (sementara)
    public function dashboard()
    {

        // $idRole = Auth::user()->id_role;
        // $data = RoleAkses::with('hakAkses')->where('id_role', $idRole)->get();
        // $menus = HakAkses::orderBy('id_akses')->get();
        // dd($data);

        return view('dashboard.home');
    }
}
