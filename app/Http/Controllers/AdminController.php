<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleAkses;
use App\Models\Role;
use App\Models\User;
use App\Models\ViewMenusByRole;
use App\Models\Menu;
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
        $dataRole = Role::all();

        return view('admin.hakAkses',compact('dataRole'));
    }

    // untuk kehalaman edit hak akses admin
    public function editHakAkses(Request $request)
    {

        // ambil id_role dari request
        $id_role = $request->id_user;

        // ambil data dari menuyangsesuai dengan $request
        $dataRole = Role::where('id', $id_role)->first();

        // if ($dataUser == null) {
        //     $dataUser = Dosen::where('nidn', $id_user)->first();
        // }

        // ambil data hak akses sesuai dengan user yang dipilih
        // $dataUserAkses = User::with('roleAkses.hakAkses')->where('id_user', $id_user)->first();
        $menuALL = ViewMenusByRole::where('id_role',$id_role)->get();
        // ambil seluruh data hak akses untuk di tampilkan di form
        $dataHakAkses = Menu::all();

        // penampungan menu berdasarkan header
        $menuHakAkses = [];

        // Kelompokkan menu berdasarkan header
        foreach ($dataHakAkses as $menu) {
            $menuHakAkses[$menu->header]['header'] = $menu->header;  // set header berdasarkan relasi hakAkses
            $menuHakAkses[$menu->header]['menus'][] = [    
                'id' => $menu->id_menu,           // Set menu-item berdasarkan relasi hakAkses
                'text' => $menu->menu,
                'url'  => $menu->url,
                'icon' => $menu->icon,
            ];
        }

        // kirim ke view halaman edit hak akses
        return view('admin.editHakAkses', compact('dataRole', 'menuALL', 'menuHakAkses'));
    }
}