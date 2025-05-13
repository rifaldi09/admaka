<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\AktifKuliah;
use App\Models\Mahasiswa;
use App\Models\FilePengajuan;
use Illuminate\Support\Facades\Auth;

class AktifKuliahController extends Controller
{

    // Fungsi untuk menampilkan halaman aktif kuliah role mahasiswa
    public function aktifKuliah()
    {
        // data untuk modal Ajukan Surat Baru
        $dataUser = Auth::user()->data;
        $prodi = Prodi::find($dataUser->id_prodi);

        // data yang akan tampil pada tabel
        // Mengambil data surat aktif kuliah berdasarkan user_id
        $dataTable = AktifKuliah::with('filePengajuan')->where('user_id', Auth::user()->id)->get();
        // dd($dataTable);

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
                        $btnActions = '<button class="btn btn-default text-warning btn-edit"
                        data-toggle="modal"
                        data-target="#modalEdit"
                        data-id="' . e($surat->id_aktif_kuliah) . '"
                        data-keperluan="' . e($surat->keperluan) . '"
                        data-status="' . e($surat->status) . '"
                        data-alasan="' . e($surat->alasan) . '"
                        title="Edit"><i class="fa-solid fa-pen-to-square"></i> Edit</button>';
                        break;
                    case 'Penerbitan':
                        $status = '<div class="border border-primary btn-sm text-primary text-center">' . $surat->status . '</div>';
                        foreach ($surat->filePengajuan as $file) {
                            $btnActions = '<button class="btn btn-default text-primary" title="Unduh"><i class="fa-solid fa-download"></i> Unduh</button>';
                        }
                        break;
                    case 'Diterima':
                        $status = '<div class="border border-success btn-sm text-success text-center">' . $surat->status . '</div>';
                        break;
                    default:
                        $status = '<div class="border border-warning btn-sm text-warning text-center">' . $surat->status . '</div>';
                        break;
                }

                //! belum siap
                // $pengajuan = FilePengajuan::where('id_pengajuan', Auth::id())->get();

                // Mengembalikan data dalam bentuk array 
                return [
                    $index + 1,
                    $surat->keperluan,
                    $status,
                    '<nobr>' . $btnActions . '</nobr>',
                ];
            })->toArray();
            // $dataSuratRaw = $dataTable->toArray();
        }
        // dd($dataTable);
        return view('mahasiswa.aktif-kuliah.index', compact('dataUser', 'prodi', 'dataSuratFormatted'));
    }

    // Fungsi untuk menampilkan halaman aktif kuliah role admin
    public function aktifKuliahAdmin()
    {

        $dataSurat = AktifKuliah::with('user')->get();

        // gak tau gimana cara menjelaskannya
        // yang penting untuk menampilkan data surat aktif kuliah beserta data mahasiswa
        // data yang ditampilkan sudah di golongkan atara surat yang sudah disetujui/tolak/penerbitan dan belum disetujui
        $data = collect();
        foreach ($dataSurat as $surat) {
            $mahasiswa = Mahasiswa::where('nim', $surat->user->id_user)->first();
            if ($mahasiswa) {
                $prodi = Prodi::where('id', $mahasiswa->id_prodi)->first();
                $mahasiswa->id = $surat->id_aktif_kuliah;
                $mahasiswa->keperluan = $surat->keperluan;
                $mahasiswa->status = $surat->status;
                $mahasiswa->deskripsi = $surat->deskripsi;
                $mahasiswa->prodi = $prodi ? $prodi->nama : '-';
                $mahasiswa->created_at = $surat->created_at;
                $data->push($mahasiswa);
            }
        }
        // dd($data);

        // data surat yang sudah disetujui dan ditolak
        $dataDisetujui = $data->filter(function ($item) {
            return $item->status !== 'Belum Diterima';
        })->map(function ($item, $index) {
            $status = '';
            $btnTerbit = '';
            $btnDetail = '';
            $btnUpload = '';

            // jika status ditolak maka hanya menampikan data dan status tanpa tombol aksi
            // jika status diterima maka menampilkan tombol aksi
            if ($item->status == 'Ditolak') {
                $status = '<div class="border border-danger btn-sm text-danger text-center">' . e($item->status) . '</div>';
            } else {
                $status = '<div class="border border-success btn-sm text-success text-center">' . e($item->status) . '</div>';
                $btnTerbit = '
                <form action="' . route('penerbitan-aktif-kuliah') . '" method="POST" class="d-inline">
                    ' . csrf_field() . '
                    <input type="hidden" name="id" value="' . e($item->id) . '" >
                    <input type="hidden" name="status" value="' . e($item->status) . '">
                    <button class="btn btn-primary btn-sm penerbitan " title="Terbitkan" type="button">
                        <i class="fa-solid fa-download"></i> Terbitkan
                    </button>
                </form>';

                // set button dengan data agar bisa di kirim ke modal
                // ada alternatif lain tetapi harus akses route untuk mendapatkan data
                $btnDetail = '<button class="btn btn-primary btn-detail-terima btn-sm mr-3"
                    data-toggle="modal"
                    data-target="#modalDetailTerima"
                    data-id="' . e($item->id) . '"
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
                        <i class="fa-solid fa-eye"></i> Detail
                    </button>';

                if ($item->status == 'Penerbitan') {
                    $btnUpload = '<button class="btn btn-success btn-sm btn-upload"
                        data-toggle="modal"
                        data-target="#modalUpload"
                        data-id="' . e($item->id) . '"
                            title="Upload">
                            <i class="fa-solid fa-upload"></i> Upload
                        </button>';
                }
            }

            // jika sudah di set untuk setiap variabel button maka tinggal mengembalikannya ke halaman view
            // dengan format array
            return [
                e($item->nim),
                e($item->nama),
                e($item->prodi),
                $status,
                $item->created_at->format('d-m-Y'),
                '<nobr>' . $btnDetail . $btnTerbit . '</nobr>',
                '<nobr>' . $btnUpload . '</nobr>',
            ];
        })->values()->toArray();
        // dd($data);

        // data surat yang belum disetujui
        //! sama seperti yang sebelumnya
        $dataBelumDisetujui = $data->filter(function ($item) {
            return $item->status === 'Belum Diterima';
        })->map(function ($item, $index) {
            $status = '<div class="border border-warning btn-sm text-warning text-center">' . e($item->status) . '</div>';
            $btnLihat = '<button class="btn btn-primary btn-edit btn-sm mr-3"
                    data-toggle="modal"
                    data-target="#modalLihat"
                    data-id="' . e($item->id) . '"
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
            $btnTolak = '<button class="btn btn-danger btn-tolak btn-sm"
                    data-toggle="modal"
                    data-target="#modalTolak"
                    data-id="' . e($item->id) . '"
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
    public function createSuratAktif(Request $request)
    {
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
            return redirect()->back()->with('success', 'Surat berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Surat gagal ditambahkan. Silakan coba lagi.');
        }
    }

    // Fungsi untuk terima surat aktif kuliah
    public function terimaAktifKuliah(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $deskripsi = $request->deskripsi;

        // update status aktif kuliah
        if ($deskripsi == null) {
            AktifKuliah::where('id_aktif_kuliah', $id)->update([
                'status' => 'Diterima',
            ]);
        } else {
            AktifKuliah::where('id_aktif_kuliah', $id)->update([
                'status' => 'Diterima',
                'alasan' => $deskripsi,
            ]);
        }

        return redirect()->route('Administrator/aktif-kuliah')->with('success', 'Status Aktif Kuliah Berhasil Diubah');
    }

    // Fungsi untuk menolak surat aktif kuliah
    public function tolakAktifKuliah(Request $request)
    {
        // dd($request->all());
        $validasi = $request->validate([
            'deskripsi' => 'required|string',
        ]);

        // update status aktif kuliah
        AktifKuliah::where('id_aktif_kuliah', $request->id)->update([
            'status' => 'Ditolak',
            'alasan' => $validasi['deskripsi'],
        ]);

        return redirect()->route('Administrator/aktif-kuliah')->with('success', 'Status Aktif Kuliah Berhasil Diubah');
    }

    // Fungsi untuk mengupload surat aktif kuliah
    public function penerbitanAktifKuliah(Request $request)
    {

        $dataStatus = AktifKuliah::where('id_aktif_kuliah', $request->id)->first();

        // mengecek apakah surat tersebut sudah di ubah atau belum untuk status penerbitan
        // jika sudah di ubah maka hanya bisa unduh surat
        // jika belum di ubah maka status akan di ubah dan akan mengunduh surat
        if ($dataStatus->status != 'Penerbitan') {
            AktifKuliah::where('id_aktif_kuliah', $request->id)->update([
                'status' => 'Penerbitan',
            ]);
            // Unduh surat aktif kuliah
        } else {
            // Unduh surat aktif kuliah
        }

        return back()->with('success', 'Status diperbaharui');
    }

    // Fungsi untuk mengupload surat aktif kuliah
    public function uploadAktifKuliah(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048', // Maks 2MB
        ]);

        $file = $request->file('file');

        if ($file) {
            $fileName = 'pengajuan_aktif_kuliah_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('public/aktif-kuliah', $fileName);

            FilePengajuan::create([
                'path' => $path,
                'id_pengajuan' => $request->id,
            ]);

            return back()->with('success', 'File telah diupload');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    // Fungsi untuk edit keperluan dan status surat aktif kuliah
    public function editPenolakanSurat(Request $request)
    {
        // dd($request->all());
        $validasi = $request->validate([
            'keperluan' => 'required|string',
        ]);

        AktifKuliah::where('id_aktif_kuliah', $request->id_edit)->update([
            'keperluan' => $validasi['keperluan'],
            'status' => 'Belum Diterima',
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }
}
