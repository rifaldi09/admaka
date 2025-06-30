<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataProdi extends Controller
{
    public function index()
    {
        $dataProdi = Prodi::all();

        if (empty($dataProdi)) {
            $dataProdiFormatted = [];
        } else {
            // Buat array dengan format yang diinginkan
            $dataProdiFormatted = $dataProdi->map(function ($prodi) {

                $btnEdit = '<button data-key="' . encrypt($prodi->id) . '" class="btn btn-sm btn-default text-primary update-prodi" id="updateProdi" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></button>';
                $token = csrf_token();
                $deleteUrl = route('destroy-prodi', encrypt($prodi->id));
                $btnDelete = '
                    <form class="m-0 p-0" action="' . $deleteUrl . '" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="' . $token . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-sm btn-default text-danger delete-prodi" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                    </form>
                ';

                // Mengembalikan data dalam bentuk array yang diinginkan
                return [
                    $prodi->id,
                    $prodi->nama,
                    '<div class="d-flex gap-1">' . $btnEdit . $btnDelete . '</div>', // gabungkan tombol
                ];
            })->toArray();
        }
        return view('admin.data-master.data-prodi', compact('dataProdi', 'dataProdiFormatted'));
    }

    public function storeProdi(Request $request)
    {
        // validasi input
        $validasi = $request->validate([
            'nama' => 'required|string|min:3|max:255',
        ]);

        try {
            // Simpan ke database
            Prodi::create($validasi);

            // Jika berhasil
            return redirect()->route('data-prodi')->with('success', 'Data Prodi berhasil ditambahkan');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menambahkan data prodi: ' . $e->getMessage());

            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Prodi. Silakan coba lagi.');
        }
    }

    public function updateProdi($id)
    {
        $prodi = Prodi::where('id', decrypt($id))->first();

        if (!$prodi) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $prodi->key = $id;
        return response()->json($prodi);
    }

    public function updatedataProdi(Request $request, $id)
    {
        try {
            $prodi = Prodi::where('id', decrypt($id))->firstOrFail();
            // Validasi input
            $validasi = $request->validate([
                'nama' => 'required|string|min:3|max:255',
            ]);

            // Lakukan update
            $updated = $prodi->update($validasi);

            if (!$updated) {
                return redirect()->back()->with('error', 'Gagal memperbarui data prodi.');
            }
            return redirect()->back()->with('success', 'Data prodi berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Gagal update prodi: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        } catch (\Exception $e) {
            Log::error('Kesalahan umum saat update prodi: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Data prodi tidak ditemukan atau terjadi error.');
        }
    }

    public function destroyProdi($id)
    {
        // ambil id prodi dari request
        $id_prodi = decrypt($id);

        try {
            // hapus prodi
            Prodi::where('id', $id_prodi)->delete();

            // Jika berhasil
            return redirect()->route('data-prodi')->with('success', 'Data Prodi berhasil dihapus');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menghapus data prodi: ' . $e->getMessage());

            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menghapus data Prodi. Silakan coba lagi.');
        }
    }
}
