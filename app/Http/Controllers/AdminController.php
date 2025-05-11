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


class AdminController extends Controller
{
    // untuk kehalaman Hak Akses admin
    public function hakAkses(){

        // ambil data dari mahasiswa dan dosen
        // untuk ditampilkan di form table
        $dataRole = Role::all();

        return view('admin.hakAkses',compact('dataRole'));
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




    // Menu Data Master Untuk MHS
    public function dataMhs()
    {
        $dataProdi = Prodi::all()->pluck('nama', 'id')->toArray();
        // Ambil semua data mahasiswa
        $dataMhs = Mahasiswa::all();
        if(empty($dataMhs)){
            $dataMhsFormatted = [];
        }else{
              // Buat array dengan format yang diinginkan
            $dataMhsFormatted = $dataMhs->map(function($mahasiswa) {
             
                // Button edit, delete, dan details bisa kamu sesuaikan dengan route atau URL yang sesuai
                $btnEdit = '<button data-key="'.encrypt($mahasiswa->nim).'" class="btn btn-sm btn-default text-primary update-mhs" id="updateMhs" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                // $btnDelete = '<button class="btn btn-sm btn-default text-danger  " title="Delete"><i class="fa fa-lg fa-fw fa-trash"></i></button>';
                $token = csrf_token();
                $deleteUrl = route('destroy-mhs', encrypt($mahasiswa->nim));
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-default text-danger delet-mhs" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </form>
                ';
                // $btnDetails = '<button class="btn btn-sm btn-default text-teal  " title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></button>';

                // Mengembalikan data dalam bentuk array yang diinginkan
                return [
                    $mahasiswa->nim,
                    $mahasiswa->nama,
                    $mahasiswa->email,
                    $mahasiswa->no_hp,
                    '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
                ];
            })->toArray();
        }
        return view('admin.data-mahasiswa',compact('dataProdi', 'dataMhsFormatted'));
    }

    //tempat crud mahasiswa
    public function storeMhs(Request $request)
    {
  
        // validasi input
        $validasi = $request->validate([
            'nim'            => 'required|string|unique:mahasiswa,nim',
            'nama'           => 'required|string|max:255',
            'email'          => [
                                    'required',
                                    'email',
                                    Rule::unique('mahasiswa', 'email')->whereNull('deleted_at') // validasi hanya jika deleted_at NULL
                                ],
            'prodi'          => 'required|exists:prodi,id',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'no_hp'          => 'required|string|max:20',
        ]);
          try {
            // Simpan ke database
            Mahasiswa::create([
                'nim'            => $validasi['nim'],
                'nama'           => $validasi['nama'],
                'email'          => $validasi['email'],
                'id_prodi'       => $validasi['prodi'],
                'tempat_lahir'   => $validasi['tempat_lahir'],
                'tanggal_lahir'  => $validasi['tanggal_lahir'],
                'no_hp'          => $validasi['no_hp'],
            ]);
              
            User::create([
                'id_user'        => $validasi['nim'],
                'password'       => Hash::make($validasi['nim']),
                'id_role'        => 1,
            ]);
      
            // Jika berhasil
            return redirect()->route('data-mhs')->with('success', 'Data Mahasiswa berhasil ditambahkan');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menambahkan data mahasiswa: ' . $e->getMessage());
      
            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Mahasiswa. Silakan coba lagi.');
        }
      
    }

    // Fungsi Menghapus Mahasiswa
    public function destroyMhs($nim)
    {
        // ambil id mhs dari request
        $id_mhs = decrypt($nim);

        try {
            // hapus juga user yang berhubungan dengan data mhs tersebut
            User::where('id_user', $id_mhs)->delete();

            // hapus mhs
            Mahasiswa::where('nim', $id_mhs)->delete();
      
            // Jika berhasil
            return redirect()->route('data-mhs')->with('success', 'Data Mahasiswa berhasil dihapus');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menghapus data mahasiswa: ' . $e->getMessage());
      
            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data Mahasiswa. Silakan coba lagi.');
        }
      }
      
    public function updateMhs($nim)
    {
        $mhs = Mahasiswa::select('nama', 'email', 'no_hp','id_prodi','tanggal_lahir','tempat_lahir')
                ->where('nim', decrypt($nim))
                ->first();
        
        
        if (!$mhs) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $mhs->key = $nim;
        return response()->json($mhs);
    }
    
    public function updatedataMhs(Request $request, $nim)
    {
        try {
            $mahasiswa = Mahasiswa::where('nim', decrypt($nim))->firstOrFail();
            // Validasi input
            $validasi = $request->validate([
                'nama1'           => 'required|string|max:255',
                'email1'          => [
                    'required',
                    'email',
                    Rule::unique('mahasiswa', 'email')
                    ->ignore($mahasiswa->nim, 'nim') // abaikan data milik sendiri
                    ->whereNull('deleted_at') // validasi hanya jika deleted_at NULL
                ],
                'prodi1'          => 'required|exists:prodi,id',
                'tempat_lahir1'   => 'required|string|max:100',
                'tanggal_lahir1'  => 'required|date',
                'no_hp1'          => 'required|string|max:20',
            ]);
          
            // Lakukan update
            $updated= $mahasiswa->update([
                'nama'           => $validasi['nama1'],
                'email'          => $validasi['email1'],
                'id_prodi'       => $validasi['prodi1'],
                'tempat_lahir'   => $validasi['tempat_lahir1'],
                'tanggal_lahir'  => $validasi['tanggal_lahir1'],
                'no_hp'          => $validasi['no_hp1'],
            ]);
    
            if (!$updated) {
                return redirect()->back()->with('error', 'Gagal memperbarui data mahasiswa.');
            }
            return redirect()->back()->with('success', 'Data mahasiswa berhasil diperbarui.');

        } catch (QueryException $e) {
            Log::error('Gagal update mahasiswa: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        } catch (\Exception $e) {
            Log::error('Kesalahan umum saat update mahasiswa: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Data mahasiswa tidak ditemukan atau terjadi error.');
        }
    }
    
    
}