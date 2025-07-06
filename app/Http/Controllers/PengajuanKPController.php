<?php

namespace App\Http\Controllers;

use App\Models\FilePengajuan;
use App\Models\PengajuanKP;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
// set format tanggal ke bahasa indonesia
Carbon::setLocale('id');

class PengajuanKPController extends Controller
{
    // halaman pengajuan kp mahasiswa
    public function pengajuanKp() 
    {
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Mahasiswa')) {
            abort(403, 'Akses ditolak.');
        }
        $pengajuan = PengajuanKP::with('filePengajuan')->where('user_id', Auth::id())->get();

        return view('mahasiswa.pengajuan-kp.index', compact('pengajuan'));
    }

    // halaman pengajuan kp admin
    public function pengajuanKpAdmin()
    {
        // ambil data pengajuanKp by status
        // with gunanya buat bawa relasi ke datanya, jadi harus where 2 kali
        // whereHas buat di cek aja biar user yang di ambil itu yang ada pengajuanKp + status nya belum diterima
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Administrator')) {
            abort(403, 'Akses ditolak.');
        }
        $draft = User::whereHas('pengajuanKp', function($query) {
            $query->where('status', 'Belum Diterima');
        })->with(['pengajuanKp' => function($query) {
            $query->where('status', 'Belum Diterima');
        }, 'dataMahasiswa.prodi'])->get();

        $diterima = User::whereHas('pengajuanKp', function($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        })->with([
            'pengajuanKp' => function($query) {
                $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
            },
            'dataMahasiswa'
        ])->get();

        return view('admin.pengajuan-kp.index', compact('draft', 'diterima'));
    }

    // halaman pengajuan kp koordinator
    public function pengajuanKpKoordinator()
    {
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Koordinator Kerja Praktik')) {
            abort(403, 'Akses ditolak.');
        }
        $diterima = User::whereHas('pengajuanKp', function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi);
        })->with(['pengajuanKp' => function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi);
        }, 'dataMahasiswa'])->get();

        return view('dosen.pengajuan-kp.index', compact('diterima'));
    }

    // buat pengajuan kp untuk mahasiswa
    public function createPengajuan(Request $request)
    {
        $request->validate([
            'tujuan_surat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alamat_surat' => 'required'
        ]);

        $cek_nomor_terakhir = PengajuanKP::where('status', '!=','Ditolak')
        ->orderByDesc('created_at')
        ->first();
        
        // if ($cek_nomor_terakhir) {
        //     $nomorTerakhir = (int) substr($cek_nomor_terakhir, 3);
        //     $no_surat = 'KP' . str_pad($nomorTerakhir + 1, 4, '0', STR_PAD_LEFT); 
        // } else {
        //     $no_surat = '0001';
        // }

        $tahunSekarang = Carbon::now()->year;

        if ($cek_nomor_terakhir) {
       
            $tahunTerakhir = Carbon::parse( $cek_nomor_terakhir->created_at)->year;

            // Ambil nomor surat terakhir
            preg_match('/^\d+/', $cek_nomor_terakhir->no_surat, $matchNomor);
            $nomorTerakhir = isset($matchNomor[0]) ? (int) $matchNomor[0] : 0;

            if ($tahunTerakhir != $tahunSekarang) {
                $no_surat = '0001'; // Tahun berganti, mulai dari awal
            } else {
                $no_surat = str_pad($nomorTerakhir + 1, 4, '0', STR_PAD_LEFT); // Lanjut nomor
            }
        } else {
            $no_surat = '0001'; // Tidak ada data, mulai dari awal
        }


        $data = [
            'tujuan_surat' => $request->tujuan_surat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alamat_surat' => $request->alamat_surat,
            'user_id' => Auth::user()->id,
            'id_prodi' => Auth::user()->data->id_prodi,
            'no_surat' => $no_surat
        ];

        PengajuanKP::create($data);

        return back()->with('success', 'Pengajuan sudah dibuat');
    }

    // terima pengajuan
    public function terimaPengajuan($id)
    {
        PengajuanKP::where('id_pengajuan', $id)->update([
            'status' => 'Diterima',
            'alasan_ditolak' => ''
        ]);

        return back()->with('success', 'Status diperbaharaui');
    }

    // edit pengajuan
    public function editPengajuan(Request $request, $id)
    {
        $request->validate([
            'tujuan_surat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alamat_surat' => 'required'
        ]);

        $data = [
            'tujuan_surat' => $request->tujuan_surat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alamat_surat' => $request->alamat_surat,
            'alasan_ditolak' => '',
            'status' => 'Belum Diterima'
        ];

        PengajuanKP::where('id_pengajuan', $id)->update($data);

        return back()->with('success', 'Pengajuan sudah diperbaharui');
    }

    // tolak pengajuan
    public function tolakPengajuan(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required'
        ]);

        PengajuanKP::where('id_pengajuan', $id)->update([
            'status' => 'Ditolak',
            'alasan_ditolak' => $request->alasan_ditolak
        ]);

        return back()->with('success', 'Status diperbaharaui');
    }

    // penerbitan pengajuan
    public function penerbitanPengajuan($id)
    {
        PengajuanKP::where('id_pengajuan', $id)->update([
            'status' => 'Penerbitan'
        ]);

        return back()->with('success', 'Status diperbaharui');
    }

    public function generatePengajuan(PengajuanKP $pengajuan)
    {
        $user = User::whereHas('pengajuanKp', function($query) use ($pengajuan) {
            $query->where('status', 'Penerbitan')
                ->where('id_pengajuan', $pengajuan->id_pengajuan);
        })->with([
            'pengajuanKp' => function($query) use ($pengajuan) {
                $query->where('status', 'Penerbitan')
                ->where('id_pengajuan', $pengajuan->id_pengajuan);
            },
            'dataMahasiswa.prodi'
        ])->first();

        if (!$user) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        $kp = $user->pengajuanKp->first();

        $data = [
            'no' => 1,
            'nama' => $user->dataMahasiswa->nama,
            'nim' => $user->dataMahasiswa->nim,
            'prodi' => $user->dataMahasiswa->prodi->nama,
            'no_hp' => $user->dataMahasiswa->no_hp,
            'created_at' => Carbon::parse($kp->created_at)->translatedFormat('j F Y'),
            'no_surat' => $kp->no_surat.'/UN53.01/DT.01.01/'.$kp->created_at->format('Y'),
            'tujuan_surat' => $kp->tujuan_surat,
            'alamat_surat' => $kp->alamat_surat,
            'tanggal_mulai' => Carbon::parse($kp->tanggal_mulai)->translatedFormat('j F Y'),
            'tanggal_selesai' => Carbon::parse($kp->tanggal_selesai)->translatedFormat('j F Y')
        ];

        $pdf = Pdf::loadView('pdf.pengajuan-kp.pdf-kp', $data);
        return $pdf->download('pengajuan-kp-'.$user->dataMahasiswa->nama.'.pdf');
    }

    // upload file pengajuan untuk mahasiswa
    public function uploadPengajuan(Request $request, PengajuanKP $pengajuan)
    {

        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $idPengajuanKp= $pengajuan->id_pengajuan;

        if ($file) {
            $fileName = 'pengajuan_kerja_praktik_' . $idPengajuanKp . '.' . $file->getClientOriginalExtension();
            $relativePath = 'pengajuan-kp/pdf/' . $fileName;

            // Cek data lama
            $existingFile = FilePengajuan::where('id_pengajuan', $idPengajuanKp)->first();

            if ($existingFile) {
                // Hapus file lama di storage
                Storage::delete('public/' . $existingFile->path);

                // Hapus data lama di database
                $existingFile->delete();
            }

            // Upload file baru (akan overwrite file jika nama sama)
            $path = $file->storeAs('public/pengajuan-kp/pdf', $fileName);

            // Simpan data baru di database
            FilePengajuan::create([
                'path' => $relativePath,
                'id_pengajuan' => $idPengajuanKp,
            ]);

            return back()->with('success', 'File berhasil diupload ');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    public function unduhPDF(Request $request)
    {
        $idPengajuanKp = decrypt($request->id);
        $fileRecord = FilePengajuan::where('id_pengajuan', $idPengajuanKp)->first();

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