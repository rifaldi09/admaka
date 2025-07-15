<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
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
use Illuminate\Validation\ValidationException;

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


    // Mengirim data ke halaman menu
    public function menuAll()
    {
        // Ambil semua data Dosen
        $dataMenu = Menu::all();
        if (empty($dataMenu)) {
            $dataMenuFormatted = [];
        } else {
            // Buat array dengan format yang diinginkan
            $dataMenuFormatted = $dataMenu->map(function ($menu) {

                $btnEdit = '<button data-key="' . encrypt($menu->id_menu) . '" class="btn btn-sm btn-default text-primary update-menu" id="updateMenu" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                $token = csrf_token();
                $deleteUrl = route('destroy-menu', encrypt($menu->id_menu));
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-default text-danger delet-menu" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </form>
                ';

                // Mengembalikan data dalam bentuk array yang diinginkan
                return [
                    $menu->kelompok_menu,
                    $menu->header,
                    $menu->menu,
                    '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
                ];
            })->toArray();
        }

        return view('admin.manajemen_menu', compact('dataMenuFormatted'));
    }

    //tempat crud menu
    public function storeMenu(Request $request)
    {
        // validasi input
        $validasi = $request->validate([
            'kelompok_menu'    => 'required|string',
            'header'           => 'required|string',
            'menu'             => 'required|string',
            'url'              => 'required|string',
            'icon'             => 'required|string',
        ]);

        try {
            // Simpan ke database
            Menu::create([
                'kelompok_menu'     => $validasi['kelompok_menu'],
                'header'            => $validasi['header'],
                'menu'              => $validasi['menu'],
                'url'               => $validasi['url'],
                'icon'              => $validasi['icon'],
            ]);

            // Jika berhasil
            return redirect()->route('manajemen-menu')->with('success', 'Menu Baru berhasil ditambahkan');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menambahkan data menu: ' . $e->getMessage());

            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Menu. Silakan coba lagi.');
        }
    }

    // Fungsi Menghapus menu
    public function destroyMenu($id)
    {
        // ambil id menu dari request
        $id_menu = decrypt($id);

        try {
            // hapus Role AKses
            RoleAkses::where('id_menu', $id_menu)->delete();


            Menu::where('id_menu', $id_menu)->delete();

            // Jika berhasil
            return redirect()->route('manajemen-menu')->with('success', 'Data Menu berhasil dihapus');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menghapus data menu: ' . $e->getMessage());

            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data Menu. Silakan coba lagi.');
        }
    }

    // fungsi get data menu berdasarkan id
    public function updateMenu($id)
    {
        $menu = Menu::select('kelompok_menu', 'menu', 'header', 'url', 'icon')
            ->where('id_menu', decrypt($id))
            ->first();


        if (!$menu) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $menu->key = $id;
        return response()->json($menu);
    }
    // fungsi update data
    public function updatedataMenu(Request $request, $id)
    {
        try {
            $menu = Menu::where('id_menu', decrypt($id))->firstOrFail();

            // validasi input
            $validasi = $request->validate([
                'kelompok_menu1'    => 'required|string',
                'header1'           => 'required|string',
                'menu1'             => 'required|string',
                'url1'              => 'required|string',
                'icon1'             => 'required|string',
            ]);

            // Lakukan update
            $updated = $menu->update([
                'kelompok_menu'    => $validasi['kelompok_menu1'],
                'header'           => $validasi['header1'],
                'menu'             => $validasi['menu1'],
                'url'              => $validasi['url1'],
                'icon'             => $validasi['icon1'],

            ]);

            if (!$updated) {
                return redirect()->back()->with('error', 'Gagal memperbarui data menu.');
            }
            return redirect()->back()->with('success', 'Data menu berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Gagal update menu: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        } catch (\Exception $e) {
            Log::error('Kesalahan umum saat update menu: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Data menu tidak ditemukan atau terjadi error.');
        }
    }

    // Admin password update
    public function updatePasswordAdmin(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Update password berhasil');
    }
}
