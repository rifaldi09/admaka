<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\AktifKuliah;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;

class AktifKuliahController extends Controller
{
    
    // Fungsi untuk menampilkan halaman aktif kuliah role mahasiswa
    public function aktifKuliah() {
        // data untuk modal Ajukan Surat Baru
        $dataUser = Auth::user()->data;
        $prodi = Prodi::find($dataUser->id_prodi);

        // data yang akan tampil pada tabel
        // Mengambil data surat aktif kuliah berdasarkan user_id
        $dataTable = AktifKuliah::where('user_id', Auth::user()->id)->get();


        // Validasi data table jika kosong
        if (empty($dataTable)) {
            $dataSuratFormatted = [];
        } else {
            // Buat array untuk dikirim ke view
            $dataSuratFormatted = $dataTable->map(function ($surat, $index) {

                // Defaultkan status dan tombol Aksi
                $status = '';
                $btnActions = '';

                // Tentukan status dan tombol Aksi berdasarkan status surat
                switch ($surat->status) {
                    case 'Ditolak':
                        $status = '<div class="border border-danger btn-sm text-danger text-center">' . $surat->status . '</div>';
                        $btnActions = '<button class="btn btn-default text-warning" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>';
                        break;
                    case 'Penerbitan':
                        $status = '<div class="border border-primary btn-sm text-primary text-center">' . $surat->status . '</div>';
                        $btnActions = '<button class="btn btn-default text-primary" title="Unduh"><i class="fa-solid fa-download"></i></button>';
                        break;
                    case 'Diterima':
                        $status = '<div class="border border-success btn-sm text-success text-center">' . $surat->status . '</div>';
                        break;
                    default:
                        $status = '<div class="border border-warning btn-sm text-warning text-center">' . $surat->status . '</div>';
                        break;
                }

                // Mengembalikan data dalam bentuk array 
                return [
                    $index + 1,
                    $surat->keperluan,
                    $status,
                    '<nobr>' . $btnActions . '</nobr>',
                ];
            })->toArray();
        }

        return view('mahasiswa.aktif-kuliah.index', compact('dataUser', 'prodi', 'dataSuratFormatted'));
    }

    //! MASIH BELUM SELESAI
    // Fungsi untuk menampilkan halaman aktif kuliah role admin
    public function aktifKuliahAdmin(){
        $dataSurat = AktifKuliah::with('user')->get();
        // dd($dataSurat[0]->user_id);

        // gak tau gimana cara menjelaskannya
        // yang penting untuk menampilkan data surat aktif kuliah beserta data mahasiswa
        $data = collect();
        foreach ($dataSurat as $surat) {
            $mahasiswa = Mahasiswa::where('nim', $surat->user->id_user)->first();
            if ($mahasiswa) {
                $prodi = Prodi::where('id', $mahasiswa->id_prodi)->first();
                $mahasiswa->id = $surat->user_id;
                $mahasiswa->keperluan = $surat->keperluan;
                $mahasiswa->status = $surat->status;
                $mahasiswa->deskripsi = $surat->deskripsi;
                $mahasiswa->prodi = $prodi ? $prodi->nama : '-';
                $mahasiswa->created_at = $surat->created_at;
                $data->push($mahasiswa);
            }
        }

        // data surat yang sudah disetujui dan ditolak
        $dataDisetujui = $data->filter(function ($item) {
            return $item->status !== 'Belum Diterima';
        })->map(function ($item, $index) {
            $status = '';
            if ($item->status == 'Ditolak') {
                $status = '<div class="border border-danger btn-sm text-danger text-center">' . e($item->status) . '</div>';
            } else {
                $status = '<div class="border border-success btn-sm text-success text-center">' . e($item->status) . '</div>';
            }
            return [
                e($item->nim),
                e($item->nama),
                e($item->prodi),
                $status,
                $item->created_at->format('d-m-Y'),
                '<nobr></nobr>', // Tidak ada tombol
            ];
        })->values()->toArray();
        dd($data);


        // data surat yang belum disetujui
        $dataBelumDisetujui = $data->filter(function ($item) {
            return $item->status === 'Belum Diterima';
        })->map(function ($item, $index) {
            $status = '<div class="border border-warning btn-sm text-warning text-center">' . e($item->status) . '</div>';
            $btnLihat = '<button class="btn btn-primary btn-edit btn-sm mr-3"
                    data-toggle="modal"
                    data-target="#modalLihat"
                    data-id="' . e(encrypt($item->id)) . '"
                    data-nim="' . e($item->nim) . '"
                    data-nama="' . e($item->nama) . '"
                    data-prodi="' . e($item->prodi) . '"
                    data-keperluan="' . e($item->keperluan) . '"
                    data-deskripsi="' . e($item->deskripsi) . '"
                    data-email="' . e($item->email) . '"
                    data-nohp="' . e($item->no_hp) . '"
                    data-status="' . e($item->status) . '"
                    data-tempatLhr="' . e($item->tempat_lahir) . '"
                    data-tanggalLhr="' . e($item->tanggal_lahir) . '"
                    title="Detail">
                    <i class="fa-solid fa-eye"></i> Lihat
                </button>';
            $btnTolak = '<button class="btn btn-danger btn-edit btn-sm"
                    data-toggle="modal"
                    data-target="#modalTolak"
                    data-id="' . e(encrypt($item->id)) . '"
                    title="Tolak">
                    <i class="fa-solid fa-circle-info"></i> Tolak
                </button>';

            return [
                e($item->nim),
                e($item->nama),
                e($item->prodi),
                $status,
                $item->created_at->format('d-m-Y'),
                '<nobr>' . $btnLihat . $btnTolak . '</nobr>',
            ];
        })->values()->toArray();

        return view('admin.aktif-kuliah.index', compact('dataDisetujui', 'dataBelumDisetujui'));
    }

    // Fungsi untuk input pengajuan surat aktif kuliah dari mahasiswa
    public function createSuratAktif(Request $request) {
        // Validasi inputan
        $request->validate([
            'keperluan' => 'required|string|max:255',
        ]);

        // Cek apakah surat aktif kuliah sudah ada
        $validasi = AktifKuliah::create([
            'keperluan' => $request->keperluan,
            'user_id' => Auth::user()->id,
        ]);


        if ($validasi) {
            return redirect()->back()->with('success', 'Data Mahasiswa berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan data Mahasiswa. Silakan coba lagi.');
        }
    }

    //! MASIH BELUM SELESAI 
    public function terimaAktifKuliah(Request $request){
        dd($request->id);
        $id = decrypt($request->id);
        $deskripsi = $request->deskripsi;

        // update status aktif kuliah
        if ($deskripsi == null) {
            AktifKuliah::where('id', $id)->update([
                'status' => 'Diterima',
            ]);
        } else {
            AktifKuliah::where('id', $id)->update([
                'status' => 'Diterima',
                'alasan' => $deskripsi,
            ]);
        }

        return redirect()->route('Administrator/aktif-kuliah')->with('success', 'Status Aktif Kuliah Berhasil Diubah');
    }
}
