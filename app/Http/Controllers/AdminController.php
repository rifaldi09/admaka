<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleAkses;
use App\Models\HakAkses;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dataMaster()
    {
        return view('admin.data-master');
    }

    // untuk kehalaman Hak Akses admin
    public function hakAkses(){

        // ambil data dari mahasiswa dan dosen
        // untuk ditampilkan di form table
        $dataMhs = Mahasiswa::all();
        $dataDsn = Dosen::all();

        return view('admin.hakAkses',compact('dataMhs','dataDsn'));
    }

    // untuk kehalaman edit hak akses admin
    public function editHakAkses(Request $request)
    {

        // ambil nim/nidn dari request
        $id_user = $request->id_user;

        // ambil data dari mahasiswa, jika gak sesuai dengan nim mahasiswa maka ambil dari dosen
        $dataUser = Mahasiswa::where('nim', $id_user)->first();
        if ($dataUser == null) {
            $dataUser = Dosen::where('nidn', $id_user)->first();
        }

        // ambil data hak akses sesuai dengan user yang dipilih
        $dataUserAkses = User::with('roleAkses.hakAkses')->where('id_user', $id_user)->first();

        // ambil seluruh data hak akses untuk di tampilkan di form
        $dataHakAkses = HakAkses::all();

        // penampungan menu berdasarkan header
        $menuHakAkses = [];

        // Kelompokkan menu berdasarkan header
        foreach ($dataHakAkses as $menu) {
            $menuHakAkses[$menu->header]['header'] = $menu->header;  // set header berdasarkan relasi hakAkses
            $menuHakAkses[$menu->header]['menus'][] = [    
                'id' => $menu->id_akses,           // Set menu-item berdasarkan relasi hakAkses
                'text' => $menu->menu,
                'url'  => $menu->url,
                'icon' => $menu->icon,
            ];
        }

        // kirim ke view halaman edit hak akses
        return view('admin.editHakAkses', compact('dataUser', 'dataUserAkses', 'menuHakAkses'));
    }
}
