<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DataDosen extends Controller
{
    public function index()
    {
        $dataProdi = Prodi::all()->pluck('nama', 'id')->toArray();
        // Ambil semua data Dosen
        $dataDosen = Dosen::all();
        if (empty($dataDosen)) {
            $dataDosenFormatted = [];
        } else {
            // Buat array dengan format yang diinginkan
            $dataDosenFormatted = $dataDosen->map(function ($dosen) {

                $btnEdit = '<button data-key="' . encrypt($dosen->nidn) . '" class="btn btn-sm btn-default text-primary update-dosen" id="updateDosen" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                $token = csrf_token();
                $deleteUrl = route('destroy-dosen', encrypt($dosen->nidn));
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-default text-danger delet-dosen" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </form>
                ';

                // Mengembalikan data dalam bentuk array yang diinginkan
                return [
                    $dosen->nidn,
                    $dosen->nip,
                    $dosen->nama,
                    $dosen->email,
                    $dosen->no_hp,
                    '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
                ];
            })->toArray();
        }
        return view('admin.data-master.data-dosen', compact('dataProdi', 'dataDosenFormatted'));
    }

    //tempat crud dosen
    public function storeDosen(Request $request)
    {
        // validasi input
        $validasi = $request->validate([
            'nidn'            => 'required|string|unique:dosen,nidn',
            'nip'            => 'required|string|unique:dosen,nip',
            'nama'           => 'required|string|max:255',
            'email'          => [
                'required',
                'email',
                Rule::unique('dosen', 'email')->whereNull('deleted_at') // validasi hanya jika deleted_at NULL
            ],
            'prodi'          => 'required|exists:prodi,id',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'no_hp'          => 'required|string|max:20',
        ]);
          $roleDosenId = Role::where('name_role', 'Dosen')
                                ->value('id');
                            
        DB::beginTransaction();
        try {
            // Simpan ke database
            Dosen::create([
                'nidn'           => $validasi['nidn'],
                'nip'            => $validasi['nip'],
                'nama'           => $validasi['nama'],
                'email'          => $validasi['email'],
                'id_prodi'       => $validasi['prodi'],
                'tempat_lahir'   => $validasi['tempat_lahir'],
                'tanggal_lahir'  => $validasi['tanggal_lahir'],
                'no_hp'          => $validasi['no_hp'],
            ]);

                $user = User::create([
                    'id_user' => $validasi['nidn'],
                    'password' => Hash::make($validasi['nidn']),
                    // 'id_role' => $roleMahasiswaId,
                ]);
                $userId = $user->id;
                
                RoleUser::create([
                    'user_id' => $userId,
                    'role_id' => $roleDosenId,
                    // 'id_role' => $roleMahasiswaId,
                ]);
                
            DB::commit(); // semua sukses
        

            // Jika berhasil
            return redirect()->route('data-dosen')->with('success', 'Data Dosen berhasil ditambahkan');
        } catch (QueryException $e) {
            // Log error untuk debugging
              DB::rollback(); 
            Log::error('Gagal menambahkan data dosen: ' . $e->getMessage());

            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Dosen. Silakan coba lagi.');
        }
    }

    // Fungsi Menghapus Dosen
    public function destroyDosen($nidn)
    {
        // ambil id dosen dari request
        $id_dosen = decrypt($nidn);

        try {
            // hapus juga user yang berhubungan dengan data dosen tersebut
            User::where('id_user', $id_dosen)->delete();

            // hapus dosen
            Dosen::where('nidn', $id_dosen)->delete();

            // Jika berhasil
            return redirect()->route('data-dosen')->with('success', 'Data Dosen berhasil dihapus');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menghapus data dosen: ' . $e->getMessage());

            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data dosen. Silakan coba lagi.');
        }
    }

    // fungsi get data dosen berdasarkan nidn
    public function updateDosen($nidn)
    {
        $dosen = Dosen::select('nip', 'nama', 'email', 'no_hp', 'id_prodi', 'tanggal_lahir', 'tempat_lahir')
            ->where('nidn', decrypt($nidn))
            ->first();


        if (!$dosen) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $dosen->key = $nidn;
        return response()->json($dosen);
    }
    // fungsi update data
    public function updatedataDosen(Request $request, $nidn)
    {
        try {
            $dosen = Dosen::where('nidn', decrypt($nidn))->firstOrFail();

            // Validasi input
            $validasi = $request->validate([
                'nip1'            => 'required|string|unique:dosen,nip',
                'nama1'           => 'required|string|max:255',
                'email1'          => [
                    'required',
                    'email',
                    Rule::unique('dosen', 'email')
                        ->ignore($dosen->nidn, 'nidn') // abaikan data milik sendiri
                        ->whereNull('deleted_at') // validasi hanya jika deleted_at NULL
                ],
                'prodi1'          => 'required|exists:prodi,id',
                'tempat_lahir1'   => 'required|string|max:100',
                'tanggal_lahir1'  => 'required|date',
                'no_hp1'          => 'required|string|max:20',
            ]);

            // Lakukan update
            $updated = $dosen->update([
                'nip'           => $validasi['nip1'],
                'nama'           => $validasi['nama1'],
                'email'          => $validasi['email1'],
                'id_prodi'       => $validasi['prodi1'],
                'tempat_lahir'   => $validasi['tempat_lahir1'],
                'tanggal_lahir'  => $validasi['tanggal_lahir1'],
                'no_hp'          => $validasi['no_hp1'],
            ]);

            if (!$updated) {
                return redirect()->back()->with('error', 'Gagal memperbarui data dosen.');
            }
            return redirect()->back()->with('success', 'Data dosen berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Gagal update dosen: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        } catch (\Exception $e) {
            Log::error('Kesalahan umum saat update dosen: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Data dosen tidak ditemukan atau terjadi error.');
        }
    }

    // privew data dari csv
    public function previewCSVDosen(Request $request)
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

            $nidn = $row[0] ?? '';
            $nip = $row[1] ?? '';
            $nama = $row[2] ?? '';
            $tempat = $row[3] ?? '';
            $tgl = $row[4] ?? '';
            $prodi = $row[5] ?? '';
            $email = $row[6] ?? '';
            $no_hp = $row[7] ?? '';
            
            $prodiList = Prodi::pluck('id', 'nama')->toArray();
            if (array_key_exists($prodi, $prodiList)) {
                //  $id_prodi = $prodiList[$prodi];
                 $prodi = $prodi;
            }else{
                 $prodi = '';
            }
            
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

            $rowData[] = ['value' => $nidn, 'error' => empty($nidn) || Dosen::where('nidn', $nidn)->exists()];
            $rowData[] = ['value' => $nip, 'error' => empty($nip) || Dosen::where('nip', $nip)->exists()];
            $rowData[] = ['value' => $nama, 'error' => empty($nama)];
            $rowData[] = ['value' => $tempat, 'error' => empty($tempat)];
            $rowData[] = ['value' => $tgl, 'error' => empty($tgl) || !$validDate];
            $rowData[] = ['value' => $prodi, 'error' => empty($prodi)];
            $rowData[] = ['value' => $email, 'error' => empty($email) || Dosen::where('email', $email)->exists()];
            $rowData[] = ['value' => $no_hp, 'error' => empty($no_hp)];

            $processedData[] = $rowData;
        }
     
     return view('admin.data-master.priviewImportDosen', [
            'header' => $header,
            'data' => $processedData,
            'file' => $request->file('file')->hashName(),
        ]);
    }

    // insert data yang telah di priview
    public function importDosen(Request $request)
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
            $nidn = $row[0] ?? '';
            $nip = $row[1] ?? '';
            $nama = $row[2] ?? '';
            $tempat = $row[3] ?? '';
            $tgl = $row[4] ?? '';
            $prodi = $row[5] ?? '';
            $email = $row[6] ?? '';
            $no_hp = $row[7] ?? '';


            // Validasi sederhana sebelum insert
            if (!$nidn || !$nip || !$nama || !$email || !$prodi || !$tempat || !$tgl || !$no_hp) {
                continue; // skip baris invalid
            }

            //cek prodi
            // $prodiMap = Prodi::pluck('id', 'nama')->mapWithKeys(function ($id, $nama) {
            //     return [strtolower(trim($nama)) => $id]; // pakai lowercase untuk pencocokan aman
            // })->toArray();

            // $id_prodi = $prodiMap[strtolower(trim($prodi))] ?? null;
            $id_prodi='';
            //Validasi prodi
            $prodiList = Prodi::pluck('id', 'nama')->toArray();
            if (array_key_exists($prodi, $prodiList)) {
                 $id_prodi = $prodiList[$prodi];
                //  $prodi = $prodi;
            }

            if (!$id_prodi) {
                continue; // skip baris jika prodi tidak dikenali
            }

            // Cek duplikat
            if (Dosen::where('nidn', $nidn)->exists() || Dosen::where('nip', $nip)->exists() || Dosen::where('email', $email)->exists()) {
                continue;
            }

            // Validasi tanggal
            try {
                $tgl_lahir = \Carbon\Carbon::createFromFormat('Y-m-d', $tgl);
            } catch (\Exception $e) {
                continue; // skip jika tanggal salah format
            }
            $roleDosenId = Role::where('name_role', 'Dosen')
                                ->value('id');
                        

            DB::beginTransaction();

            try {
            // Insert ke database
            Dosen::create([
                'nidn'          => $nidn,
                'nip'           => $nip,
                'nama'          => $nama,
                'email'         => $email,
                'id_prodi'      => $id_prodi,
                'tempat_lahir'  => $tempat,
                'tanggal_lahir' => $tgl_lahir,
                'no_hp'         => $no_hp,
            ]);

                $user = User::create([
                    'id_user' => $nidn,
                    'password' => Hash::make($nidn),
                    // 'id_role' => $roleMahasiswaId,
                ]);
                $userId = $user->id;
                
                RoleUser::create([
                    'user_id' => $userId,
                    'role_id' => $roleDosenId,
                    // 'id_role' => $roleMahasiswaId,
                ]);
                
            DB::commit(); // semua sukses
        
                // return response()->json(['message' => 'Data berhasil disimpan']);
            } catch (\Exception $e) {
                DB::rollback(); // batalkan semua jika ada error
                // Hapus file sementara
               
            }
        }

        // Hapus file sementara
        Storage::delete('temp/' . $file);

        return redirect()->route('data-dosen')->with('success', 'Data Dosen berhasil ditambahkan');
    }
}