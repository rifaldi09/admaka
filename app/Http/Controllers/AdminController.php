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
      
    // fungsi get data mhs berdasarkan nim
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
    // fungsi update data
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

// privew data dari csv
    public function previewCSV(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);
    
        // Simpan sementara
        $path = $request->file('file')->store('temp');
        $fullPath = storage_path('app/' . $path);
    
        // Hapus BOM UTF-8
        $raw = file_get_contents($fullPath);
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw); // Remove BOM
        file_put_contents($fullPath, $raw);
    
        // Buka file dan deteksi delimiter
        $handle = fopen($fullPath, 'r');
        $firstLine = fgets($handle);
        $delimiter = strpos($firstLine, ';') !== false ? ';' : (strpos($firstLine, ',') !== false ? ',' : "\t");
        rewind($handle);
    
        // Baca isi file
        $data = [];
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    
        if (empty($data)) {
            return back()->with('error', 'File CSV kosong atau tidak bisa dibaca.');
        }
    
        $header = $data[0];
        $dataRows = array_slice($data, 1);

        // Pengecekan error pada setiap baris
        $processedData = [];
        foreach ($dataRows as $index => $row) {
            $rowData = [];
            $hasError = false;
    
            $nim = $row[0] ?? '';
            $nama = $row[1] ?? '';
            $tempat = $row[2] ?? '';
            $tgl = $row[3] ?? '';
            $id_prodi = $row[4] ?? '';
            $email = $row[5] ?? '';
            $no_hp = $row[6] ?? '';
            
            // Validasi tanggal
            $validDate = true;
            if (!empty($tgl)) {
                try {
                    $parsed = \Carbon\Carbon::createFromFormat('Y-m-d', $tgl);
                    $validDate = $parsed && $parsed->format('Y-m-d') === $tgl;
                } catch (\Exception $e) {
                    $validDate = false;
                }
            }
            
            $rowData[] = ['value' => $nim, 'error' => empty($nim) || Mahasiswa::where('nim', $nim)->exists()];
            $rowData[] = ['value' => $nama, 'error' => empty($nama)];
            $rowData[] = ['value' => $tempat, 'error' => empty($tempat)];
            $rowData[] = ['value' => $tgl, 'error' => empty($tgl) || !$validDate];
            $rowData[] = ['value' => $id_prodi, 'error' => !Prodi::where('nama', $id_prodi)->exists()];
            $rowData[] = ['value' => $email, 'error' => empty($email) || Mahasiswa::where('email', $email)->exists()];
            $rowData[] = ['value' => $no_hp, 'error' => empty($no_hp)];
    
            $processedData[] = $rowData;
        }

        return view('admin.priviewImportMhs', [
            'header' => $header,
            'data' => $processedData,
            'file' => $request->file('file')->hashName(),
        ]);
    }
    // insert data yang telah di priview
    public function importMahasiswa(Request $request)
    {
        $file = $request->input('file');
        $fullPath = storage_path('app/temp/' . $file);

        if (!file_exists($fullPath)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        // Baca ulang isi CSV
        $handle = fopen($fullPath, 'r');
        $firstLine = fgets($handle);
        $delimiter = strpos($firstLine, ';') !== false ? ';' : (strpos($firstLine, ',') !== false ? ',' : "\t");
        rewind($handle);

        $data = [];
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            $data[] = $row;
        }
        fclose($handle);

        if (count($data) < 2) {
            return back()->with('error', 'Data kosong.');
        }

        $rows = array_slice($data, 1); // Lewati header

        foreach ($rows as $row) {
            // Ambil dan bersihkan nilai
            $nim = $row[0] ?? '';
            $nama = $row[1] ?? '';
            $tempat = $row[2] ?? '';
            $tgl = $row[3] ?? '';
            $prodi = $row[4] ?? '';
            $email = $row[5] ?? '';
            $no_hp = $row[6] ?? '';
           
 
            // Validasi sederhana sebelum insert
            if (!$nim || !$nama || !$email || !$prodi || !$tempat || !$tgl || !$no_hp) {
                continue; // skip baris invalid
            }
            
           //cek prodi
           $prodiMap = Prodi::pluck('id', 'nama')->mapWithKeys(function($id, $nama) {
                return [strtolower(trim($nama)) => $id]; // pakai lowercase untuk pencocokan aman
            })->toArray();

            $id_prodi = $prodiMap[strtolower(trim($prodi))] ?? null;
            
            if (!$id_prodi) {
                continue; // skip baris jika prodi tidak dikenali
            }
            
            // Cek duplikat
            if (Mahasiswa::where('nim', $nim)->exists() || Mahasiswa::where('email', $email)->exists()) {
                continue;
            }

            // Validasi tanggal
            try {
                $tgl_lahir = \Carbon\Carbon::createFromFormat('Y-m-d', $tgl);
            } catch (\Exception $e) {
                continue; // skip jika tanggal salah format
            }

            // Insert ke database
            Mahasiswa::create([
                'nim'           => $nim,
                'nama'          => $nama,
                'email'         => $email,
                'id_prodi'      => $id_prodi,
                'tempat_lahir'  => $tempat,
                'tanggal_lahir' => $tgl_lahir,
                'no_hp'         => $no_hp,
            ]);

            User::create([
                'id_user' => $nim,
                'password'=> Hash::make($nim),
                'id_role' => 1,
            ]);
        }

        // Hapus file sementara
        Storage::delete('temp/' . $file);

        return redirect()->route('data-mhs')->with('success', 'Data Mahasiswa berhasil ditambahkan');
    }
    
}