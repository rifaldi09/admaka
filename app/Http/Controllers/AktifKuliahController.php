<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\AktifKuliah;
use App\Models\User;
use App\Models\FilePengajuan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpWord\Shared\Validate;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\NumberFormatter;

Carbon::setLocale('id');

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
        $dataSurat = AktifKuliah::with('filePengajuan')->where('user_id', Auth::user()->id)->get();
        // dd($dataTable);

        // dd($dataTable);
        return view('mahasiswa.aktif-kuliah.index', compact('dataUser', 'prodi', 'dataSurat'));
    }

    // Fungsi untuk menampilkan halaman aktif kuliah role admin
    public function aktifKuliahAdmin()
    {

        $dataSurat = AktifKuliah::with('user.dataMahasiswa.prodi')->get();
        // dd($dataSurat);

        return view('admin.aktif-kuliah.index', compact('dataSurat'));
    }

    // Fungsi untuk input pengajuan surat aktif kuliah dari mahasiswa
    public function createSuratAktif(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'keperluan' => 'required|string',
            // 'semester_awal' => 'required',
            // 'semester_akhir' => 'required',
        ]);

        $cek_nomor_terakhir = AktifKuliah::where('status', '!=', 'Ditolak')
            ->orderByDesc('created_at')
            ->first();
        $tahunSekarang = Carbon::now()->year;

        if ($cek_nomor_terakhir) {

            $tahunTerakhir = Carbon::parse($cek_nomor_terakhir->created_at)->year;

            // Ambil nomor surat terakhir
            preg_match('/^\d+/', $cek_nomor_terakhir->nomor_surat, $matchNomor);
            $nomorTerakhir = isset($matchNomor[0]) ? (int) $matchNomor[0] : 0;

            if ($tahunTerakhir != $tahunSekarang) {
                $no_surat = '0001'; // Tahun berganti, mulai dari awal
            } else {
                $no_surat = str_pad($nomorTerakhir + 1, 4, '0', STR_PAD_LEFT); // Lanjut nomor
            }
        } else {
            $no_surat = '0001'; // Tidak ada data, mulai dari awal
        }

        // Cek apakah surat aktif kuliah sudah ada
        $validasi = AktifKuliah::create([
            'keperluan' => $request->keperluan,
            // 'semester_awal' => $request->semester_awal,
            // 'semester_akhir' => $request->semester_akhir,
            'user_id' => Auth::user()->id,
            'nomor_surat' => $no_surat
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
        $validasi = $request->validate(['status_mahasiswa' => 'required']);
        $id = $request->id;

        // update status aktif kuliah

        AktifKuliah::where('id_aktif_kuliah', $id)->update([
            'status' => 'Diterima',
            'status_kuliah' => $validasi['status_mahasiswa'],
        ]);

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
    public function penerbitanAktifKuliah($id)
    {
        $idAktifKuliah = decrypt($id);
        $dataSurat = AktifKuliah::with('user.dataMahasiswa.prodi')->where('id_aktif_kuliah', $idAktifKuliah)->first();

        $mahasiswa = $dataSurat->user->dataMahasiswa;

        $genapGanjil = $mahasiswa->semester % 2 == 0 ? 'Genap' : 'Ganjil';

        $formatter = new \NumberFormatter('id', \NumberFormatter::SPELLOUT);
        $numberSemester = $mahasiswa->semester . ' (' . $formatter->format($mahasiswa->semester) . ')';

        $dataSurat->update([
            'status' => 'Penerbitan',
        ]);

        $nomorSurat = $dataSurat->nomor_surat;

        $data = [
            'nomor_surat'     => $nomorSurat . '/UN53.01/DT.01.01/' . $dataSurat->created_at->format('Y'),
            'nama'            => $mahasiswa->nama,
            'status'          => $dataSurat->status_kuliah,
            'semester_awal'   => $dataSurat->semester_awal,
            'semester_akhir'  => $dataSurat->semester_akhir,
            'keperluan'       => $dataSurat->keperluan,
            'nim'             => $mahasiswa->nim,
            'tempat_lahir'    => $mahasiswa->tempat_lahir,
            'tanggal_lahir'   => $mahasiswa->tanggal_lahir,
            'prodi'           => $mahasiswa->prodi->nama,
            'jenjang'         => $mahasiswa->jenjang,
            'semester'        => $numberSemester,
            'genap_ganjil'    => $genapGanjil,
            'tahun_akademik'  => $mahasiswa->tahun_akademik,
            'no_hp'           => $mahasiswa->no_hp,
            'sks'             => $mahasiswa->sks,
            'ipk'             => $mahasiswa->ipk,
            'tahun_now'       => now()->format('Y'),
            'tanggal_now'     => Carbon::now()->translatedFormat('d F Y'),
        ];

        $pdf = Pdf::loadView('pdf.aktif-kuliah.pdf-aktif-kuliah', $data);

        return $pdf->download('aktif_kuliah_' . $mahasiswa->nim . '.pdf');
    }

    // Fungsi untuk mengupload surat aktif kuliah
    public function uploadAktifKuliah(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $idAktifKuliah = decrypt($request->id);

        if ($file) {
            $fileName = 'surat_aktif_kuliah_' . $idAktifKuliah . '.' . $file->getClientOriginalExtension();
            $relativePath = 'aktif-kuliah/pdf/' . $fileName;

            // Cek data lama
            $existingFile = FilePengajuan::where('id_pengajuan', $idAktifKuliah)->first();

            if ($existingFile) {
                // Hapus file lama di storage
                Storage::delete('public/' . $existingFile->path);

                // Hapus data lama di database
                $existingFile->delete();
            }

            // Upload file baru (akan overwrite file jika nama sama)
            $path = $file->storeAs('public/aktif-kuliah/pdf', $fileName);

            // Simpan data baru di database
            FilePengajuan::create([
                'path' => $relativePath,
                'id_pengajuan' => $idAktifKuliah,
            ]);

            return back()->with('success', 'File berhasil diupload ');
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

    public function unduhPDF(Request $request)
    {
        $idAktifKuliah = decrypt($request->id);
        $fileRecord = FilePengajuan::where('id_pengajuan', $idAktifKuliah)->first();

        if (!$fileRecord) {
            return back()->with('error', 'File tidak ditemukan di database.');
        }

        // Pastikan path sesuai lokasi file di storage
        $storagePath = 'public/' . $fileRecord->path;

        if (!Storage::exists($storagePath)) {
            return back()->with('error', 'File fisik tidak ditemukan di penyimpanan.');
        }

        $filePath = storage_path('app/public/' . $fileRecord->path);
        $fileName = basename($filePath);

        return response()->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
