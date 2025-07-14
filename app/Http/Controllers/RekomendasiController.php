<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratRekomendasi;
use App\Models\Prodi;
use App\Models\FilePengajuan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

Carbon::setLocale('id');

class RekomendasiController extends Controller
{
    public function rekomendasiMahasiswa()
    {
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Mahasiswa')) {
            abort(403, 'Akses ditolak.');
        }
        $dataUser = Auth::user()->data;
        $prodiUser = Prodi::find($dataUser->id_prodi);
        $dataSurat = SuratRekomendasi::with('filePengajuan')->where('user_id', Auth::user()->id)->get();
        // dd($dataSurat);
        return view('mahasiswa.surat-rekomendasi.index', compact('dataSurat', 'dataUser', 'prodiUser'));
    }

    public function rekomendasiAdmin()
    {
        $user = auth()->user();

        if (Auth::check() && !$user->roles->contains('name_role', 'Administrator')) {
            abort(403, 'Akses ditolak.');
        }

        $dataSurat = SuratRekomendasi::with('user.dataMahasiswa.prodi')->get();
        // dd($dataSurat);

        return view('admin.surat-rekomendasi.index', compact('dataSurat'));
    }

    public function rekomendasiSuperAdmin()
    {
        $user = auth()->user();

        if (Auth::check() && !$user->roles->contains('name_role', 'Super-Administrator')) {
            abort(403, 'Akses ditolak.');
        }

        $dataSurat = SuratRekomendasi::with('user.dataMahasiswa.prodi')->get();
        // dd($dataSurat);

        return view('admin.surat-rekomendasi.index', compact('dataSurat'));
    }

    public function createRekomendasi(Request $req)
    {
        // dd($req->all());
        $validasi = $req->validate([
            'perihal' => 'required',
        ]);
        $cek_nomor_terakhir = SuratRekomendasi::where('status', '!=', 'Ditolak')
            ->orderByDesc('created_at')
            ->first();
        // dd($cek_nomor_terakhir);
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
            $no_surat = '0001';
        }

        // $cek_nomor_terakhir = SuratRekomendasi::orderByDesc('created_at')->value('nomor_surat');

        // if ($cek_nomor_terakhir) {
        //     $nomorTerakhir = (int) substr($cek_nomor_terakhir, 3);
        //     $no_surat = 'AKT' . str_pad($nomorTerakhir + 1, 4, '0', STR_PAD_LEFT);
        // } else {
        //     $no_surat = 'AKT0001';
        // }

        if ($validasi) {
            if (!empty($req->tempat_perihal)) {
                SuratRekomendasi::create([
                    'perihal' => $validasi['perihal'],
                    'tempat_perihal' => $req->tempat_perihal,
                    'user_id' => Auth::user()->id,
                    'nomor_surat' => $no_surat
                ]);
            } else {
                SuratRekomendasi::create([
                    'perihal' => $validasi['perihal'],
                    'user_id' => Auth::user()->id,
                    'nomor_surat' => $no_surat
                ]);
            }
            return redirect()->back()->with('success', 'Berhasil menambahkan surat');
        } else {
            return redirect()->back()->with('error', 'Silahkan Lengkapi data');
        }
    }

    public function editRekomendasiMahasiswa(Request $req)
    {
        // dd($req->all());
        $validasi = $req->validate([
            'perihal' => 'required',
            'id_edit' => 'required',
        ]);

        if ($validasi) {
            if (!empty($req->tempat_perihal)) {
                SuratRekomendasi::where('id_rekomendasi', $validasi['id_edit'])->update([
                    'perihal' => $validasi['perihal'],
                    'tempat_perihal' => $req->tempat_perihal,
                    'status' => 'Belum Diterima',
                ]);
            } else {
                SuratRekomendasi::where('user_id', $validasi['id_edit'])->update([
                    'perihal' => $validasi['perihal'],
                    'status' => 'Belum Diterima',
                ]);
            }
            return redirect()->back()->with('success', 'Surat berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Silahkan lengkapi data');
        }
    }

    public function terimaSuratRekomendasi(Request $req)
    {
        $validasi = SuratRekomendasi::where('id_rekomendasi', $req->id)->update([
            'status' => 'Penerbitan',
        ]);
        if ($validasi) {
            return redirect()->back()->with('success', 'Berhasil mengubah status');
        } else {
            return redirect()->back()->with('error', 'gagal mengubah status');
        }
    }

    public function tolakSuratRekomendasi(Request $req)
    {
        $validasi = $req->validate([
            'alasan_ditolak' => 'required',
            'id' => 'required',
        ]);
        if ($validasi) {
            SuratRekomendasi::where('id_rekomendasi', $validasi['id'])->update([
                'alasan_ditolak' => $validasi['alasan_ditolak'],
                'status' => 'Ditolak',
            ]);
        } else {
            return redirect()->back()->with('error', 'Gagal menolak surat');
        }
        return redirect()->back()->with('success', 'Berhasil menolak surat');
    }

    public function konversiSksRekomendasi(Request $request, $id)
    {
        $idRekomendasi = decrypt($id);
        $request->validate([
            'konversi_sks' => 'required|integer'
        ]);

        SuratRekomendasi::where('id_rekomendasi', $idRekomendasi)->update([
            'status' => 'Penerbitan',
            'konversi_sks' => $request->konversi_sks,
        ]);

        return redirect()->route('penerbitan-surat-rekomendasi', ['id' => encrypt($idRekomendasi)]);
    }

    public function penerbitanSuratRekomendasi($id)
    {
        $idRekomendasi = decrypt($id);
        $dataSurat = SuratRekomendasi::with('user.dataMahasiswa.prodi')->where('id_rekomendasi', $idRekomendasi)->first();

        $formatter = new \NumberFormatter('id', \NumberFormatter::SPELLOUT);
        $numberSemester = $dataSurat->user->dataMahasiswa->semester . ' (' . $formatter->format($dataSurat->user->dataMahasiswa->semester) . ')';

        $pdf = Pdf::loadView('pdf.surat-rekomendasi.pdf-surat-rekom', [
            'nomor_surat'     => $dataSurat->nomor_surat . '/UN53.01/DT.01.01/' . $dataSurat->created_at->format('Y'),
            'konversi_sks'    => $dataSurat->konversi_sks,
            'nama_mahasiswa'  => $dataSurat->user->dataMahasiswa->nama,
            'nim'             => $dataSurat->user->dataMahasiswa->nim,
            'prodi'           => $dataSurat->user->dataMahasiswa->prodi->nama,
            'semester'        => $numberSemester,
            'tahun_akademik'  => $dataSurat->user->dataMahasiswa->tahun_akademik,
            'ipk'             => $dataSurat->user->dataMahasiswa->ipk,
            'tanggal_now'     => Carbon::now()->translatedFormat('d F Y'),
            'perihal'         => $dataSurat->perihal,
            'tempat_perihal'  => $dataSurat->tempat_perihal,
        ]);

        return $pdf->download('surat_rekomendasi_' . $dataSurat->user->dataMahasiswa->nim . '.pdf');
    }

    public function uploadSuratRekomendasi(Request $req)
    {
        $req->validate([
            'file' => 'required|mimes:pdf', // Maks 2MB
        ]);
        $file = $req->file('file');
        $idRekomendasi = decrypt($req->id);

        if ($file) {
            $fileName = 'surat_rekomendasi_' . $idRekomendasi . '.' . $file->getClientOriginalExtension();
            $relativePath = 'surat-rekomendasi/pdf/' . $fileName;

            // Cek data lama
            $existingFile = FilePengajuan::where('id_pengajuan', $idRekomendasi)->first();

            if ($existingFile) {
                // Hapus file lama di storage
                Storage::delete('public/' . $existingFile->path);

                // Hapus data lama di database
                $existingFile->delete();
            }

            // Upload file baru (akan overwrite file jika nama sama)
            $path = $file->storeAs('public/surat-rekomendasi/pdf', $fileName);

            // Simpan data baru di database
            FilePengajuan::create([
                'path' => $relativePath,
                'id_pengajuan' => $idRekomendasi,
            ]);

            return back()->with('success', 'File berhasil diupload ');
        }
        return back()->with('error', 'File tidak ditemukan.');
    }

    public function unduhSuratRekomendasi(Request $req)
    {
        $idPengajuan = decrypt($req->id);
        $fileRecord = FilePengajuan::where('id_pengajuan', $idPengajuan)->first();

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
        // $idPengajuan = decrypt($req->id);
        // $pathSurat = FilePengajuan::where('id_pengajuan', $idPengajuan)->first();
        // $path = storage_path($pathSurat->path);
        // return response()->download($path)->deleteFileAfterSend(false);
    }
}
