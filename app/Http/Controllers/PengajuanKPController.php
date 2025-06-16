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

// set format tanggal ke bahasa indonesia
Carbon::setLocale('id');

class PengajuanKPController extends Controller
{
    // halaman pengajuan kp mahasiswa
    public function pengajuanKp() 
    {
        $pengajuan = PengajuanKP::with('filePengajuan')->where('user_id', Auth::id())->get();

        return view('mahasiswa.pengajuan-kp.index', compact('pengajuan'));
    }

    // halaman pengajuan kp admin
    public function pengajuanKpAdmin()
    {
        // ambil data pengajuanKp by status
        // with gunanya buat bawa relasi ke datanya, jadi harus where 2 kali
        // whereHas buat di cek aja biar user yang di ambil itu yang ada pengajuanKp + status nya belum diterima
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

        $cek_nomor_terakhir = PengajuanKP::orderByDesc('created_at')->value('no_surat');

        if ($cek_nomor_terakhir) {
            $nomorTerakhir = (int) substr($cek_nomor_terakhir, 3);
            $no_surat = 'KP' . str_pad($nomorTerakhir + 1, 4, '0', STR_PAD_LEFT); 
        } else {
            $no_surat = 'KP0001';
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
            'file' => 'required|mimes:pdf|max:2048', // Maks 2MB
        ]);

        $file = $request->file('file');
        
        if ($file) {
            $fileName = 'pengajuan_kerja_praktik_' . time() . '.' . $file->getClientOriginalExtension();
            
            $path = $file->storeAs('public/pengajuan-kp', $fileName);
            
            FilePengajuan::create([
                'path' => $path,
                'id_pengajuan' => $pengajuan->id_pengajuan
            ]);
            
            return back()->with('success', 'File telah diupload');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }


}
