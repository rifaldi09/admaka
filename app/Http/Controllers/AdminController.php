<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleAkses;
use App\Models\Role;
use App\Models\User;
use App\Models\ViewMenusByRole;
use App\Models\Menu;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // untuk kehalaman Hak Akses admin
    public function hakAkses()
    {

        // ambil data dari mahasiswa dan dosen
        // untuk ditampilkan di form table
        $dataRole = Role::all();
        if (empty($dataRole)) {
            $dataRoleFormatted = [];
        } else {
            // Buat array dengan format yang diinginkan
            $dataRoleFormatted = $dataRole->map(function ($role) {
                $token = csrf_token();
                $editUrl = route('edit-hak-akses', encrypt($role->id));
                $deleteUrl = route('destroy-role', encrypt($role->id));

                $btnEdit = '
                    <form class="m-0 p-0" action="' . $editUrl . '" method="get" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <button class="btn btn-sm btn-default text-primary update-mhs" id="updateMhs" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                    </form>
                ';
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="' . $token . '">
                            <button type="button" class="btn btn-sm btn-default text-danger delet-mhs" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </form>
                ';
                // $btnDetails = '<button class="btn btn-sm btn-default text-teal  " title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></button>';

                // Mengembalikan data dalam bentuk array yang diinginkan
                return [
                    $role->id,
                    $role->name_role,
                    '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
                ];
            })->toArray();
        }
        return view('admin.hakAkses', compact('dataRoleFormatted'));
    }

    // untuk kehalaman edit hak akses admin
    public function editHakAkses($id)
    {

        // ambil id_role dari request
        $id_role = decrypt($id);
        // dd($id_role);

        // ambil data dari menu yang sesuai dengan $request
        $dataRole = Role::where('id', $id_role)->first();

        // if ($dataUser == null) {
        //     $dataUser = Dosen::where('nidn', $id_user)->first();
        // }

        // ambil data hak akses sesuai dengan user yang dipilih
        // $dataUserAkses = User::with('roleAkses.hakAkses')->where('id_user', $id_user)->first();
        $menuALL = ViewMenusByRole::where('id_role', $id_role)->get();
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

    public function updateHakAkses(Request $request)
    {
        // ambil id_role dari request
        $id_role = $request->id_role;

        // hapus semua hak akses yang ada di role tersebut
        RoleAkses::where('id_role', $id_role)->delete();

        // insert hak akses baru
        foreach ($request->check_akses as $menu) {
            RoleAkses::create([
                'id_role' => $id_role,
                'id_menu' => $menu,
            ]);
        }

        //! masih belum ada validasi ketika gagal menambahkan hak akses
        return redirect()->route('hak-akses')->with('success', 'Hak Akses Berhasil Diubah');
    }

    // Fungsi Menambahkan Role
    public function storeRole(Request $request)
    {
        // validasi input
        $validasi = $request->validate([
            'nama_role' => 'required|string|max:255',
        ]);

        // simpan role baru
        Role::create([
            'name_role' => $validasi['nama_role'],
        ]);

        //! masih belum ada validasi ketika gagal menambahkan role
        return redirect()->route('hak-akses')->with('success', 'Role Berhasil Ditambahkan');
    }

    // Fungsi Menghapus Role
    public function destroyRole($id)
    {
        // ambil id_role dari request
        $id_role = decrypt($id);

        // hapus role
        Role::where('id', $id_role)->delete();

        // hapus juga hak akses yang berhubungan dengan role tersebut
        RoleAkses::where('id_role', $id_role)->delete();

        //! masih belum ada validasi ketika gagal menghapus role
        return redirect()->route('hak-akses')->with('success', 'Role Berhasil Dihapus');
    }

    // Halaman Manajemen Menu
    public function manajemenMenu()
    {
        // Get all data menu
        $dataMenu = Menu::all();
        if (empty($dataMenu)) {
            $dataMenuFormatted = [];
        } else {
            // Buat array dengan format yang diinginkan
            $dataMenuFormatted = $dataMenu->map(function ($menu) {
                $token = csrf_token();
                $editUrl = route('edit-menu', encrypt($menu->id_menu));
                $deleteUrl = route('destroy-menu', encrypt($menu->id_menu));

                $btnEdit = '
                    <form class="m-0 p-0" action="' . $editUrl . '" method="get">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <button class="btn btn-sm btn-default text-primary update-mhs" id="updateMenu" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i>
                            </button>
                    </form>
                ';
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="post">
                            <input type="hidden" name="_token" value="' . $token . '">
                            <button type="button" class="btn btn-sm btn-default text-danger delet-mhs" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i></button>
                        </form>
                ';
                // $btnDetails = '<button class="btn btn-sm btn-default text-teal  " title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></button>';

                // Mengembalikan data dalam bentuk array yang diinginkan
                return [
                    $menu->id_menu,
                    $menu->kelompok_menu,
                    $menu->header,
                    $menu->menu,
                    '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
                ];
            })->toArray();
        }
        return view('admin.manajemen_menu', compact('dataMenuFormatted'));
    }

    // Tambah Menu
    public function storeMenu(Request $request)
    {
        // Validasi Input
        $data = $request->validate([
            'kelompok_menu' => 'required|min:3|max:100',
            'header' => 'required|min:3|max:100',
            'menu' => 'required|min:3|max:100|unique:menu,menu',
            'url' => 'required|min:6|unique:menu,url',
            'icon' => 'required|min:4'
        ]);

        // Simpan data
        Menu::create($data);

        return redirect()->route('manajemen-menu')->with('success', 'Menu Baru Berhasil Ditambahkan');
    }

    // Hapus Menu
    public function destroyMenu($id_menu)
    {
        // Get id menu
        $idMenu = decrypt($id_menu);

        // Hapus menu
        Menu::where('id_menu', $idMenu)->delete();

        // Hapus juga pada role akses
        RoleAkses::where('id_menu', $idMenu)->delete();

        return redirect()->route('manajemen-menu')->with('success', 'Menu Berhasil Dihapus');
    }
}
