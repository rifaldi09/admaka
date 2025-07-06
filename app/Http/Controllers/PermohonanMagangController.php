<?php

namespace App\Http\Controllers;

use App\Models\PermohonanMagang;
use App\Models\FilePengajuan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;

// set format tanggal ke bahasa indonesia
Carbon::setLocale('id');

class PermohonanMagangController extends Controller
{
    public function PermohonanMagangMahasiswa(){
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Mahasiswa')) {
            abort(403, 'Akses ditolak.');
        }
        $pengajuan = PermohonanMagang::with('filePengajuan')->where('user_id', Auth::id())->get();

        return view('mahasiswa.permohonan-magang.index', compact('pengajuan'));
    }

    public function PermohonanMagangAdmin(){
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Administrator')) {
            abort(403, 'Akses ditolak.');
        }
        // ambil data permohonanMagang by status
        // with gunanya buat bawa relasi ke datanya, jadi harus where 2 kali
        // whereHas buat di cek aja biar user yang di ambil itu yang ada permohonanMagang + status nya belum diterima
        $draft = User::whereHas('permohonanMagang', function ($query) {
            $query->where('status', 'Belum Diterima');
        })->with(['permohonanMagang' => function ($query) {
            $query->where('status', 'Belum Diterima');
        }, 'dataMahasiswa.prodi'])->get();

        $diterima = User::whereHas('permohonanMagang', function ($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        })->with([
            'permohonanMagang' => function ($query) {
                $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
            },
            'dataMahasiswa'
        ])->get();

        return view('admin.permohonan-magang.index', compact('draft', 'diterima'));
    }

    public function PermohonanMagangKKP(){
        $diterima = User::whereHas('permohonanMagang', function ($query) {
            $query->where('status', 'Diterima')
                ->where('id_prodi', Auth::user()->data->id_prodi);
        })->with(['permohonanMagang' => function ($query) {
            $query->where('status', 'Diterima')
                ->where('id_prodi', Auth::user()->data->id_prodi);
        }, 'dataMahasiswa'])->get();

        return view('dosen.permohonan-magang.index', compact('diterima'));
    }

    // buat pengajuan kp untuk mahasiswa
    public function createPermohonan(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tujuan_surat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alamat_surat' => 'required'
        ]);

        $cek_nomor_terakhir = PermohonanMagang::orderByDesc('created_at')->value('no_surat');

        if ($cek_nomor_terakhir) {
            $nomorTerakhir = (int) substr($cek_nomor_terakhir, 3);
            $no_surat = 'PM' . str_pad($nomorTerakhir + 1, 4, '0', STR_PAD_LEFT); 
        } else {
            $no_surat = 'PM0001';
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

        PermohonanMagang::create($data);

        return back()->with('success', 'Pengajuan sudah dibuat');
    }

    // terima pengajuan
    public function terimaPermohonan($id)
    {
        PermohonanMagang::where('id_permohonan_magang', $id)->update([
            'status' => 'Diterima',
            'alasan_ditolak' => ''
        ]);

        return back()->with('success', 'Status diperbaharaui');
    }

    // edit pengajuan
    public function editPermohonan(Request $request, $id)
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

        PermohonanMagang::where('id_permohonan_magang', $id)->update($data);

        return back()->with('success', 'Pengajuan sudah diperbaharui');
    }

    // tolak pengajuan
    public function tolakPermohonan(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required'
        ]);

        PermohonanMagang::where('id_permohonan_magang', $id)->update([
            'status' => 'Ditolak',
            'alasan_ditolak' => $request->alasan_ditolak
        ]);

        return back()->with('success', 'Status diperbaharaui');
    }

    // penerbitan pengajuan
    public function penerbitanPermohonan($id)
    {
        PermohonanMagang::where('id_permohonan_magang', $id)->update([
            'status' => 'Penerbitan'
        ]);

        return back()->with('success', 'Status diperbaharui');
    }

    public function pdfPermohonan($id)
    {
        $data = User::whereHas('permohonanMagang', function ($query) use ($id) {
            $query->where('status', 'Penerbitan')
                ->where('id_permohonan_magang', $id);
        })
        ->with([
            'permohonanMagang' => function ($query) use ($id) {
                $query->where('status', 'Penerbitan')
                    ->where('id_permohonan_magang', $id);
            },
            'dataMahasiswa.prodi'
        ])
        ->firstOrFail();

        $kp = $data->permohonanMagang->first();

        $tanggal = Carbon::parse($kp->created_at)->translatedFormat('j F Y');
        $tanggal_mulai = Carbon::parse($kp->tanggal_mulai)->translatedFormat('j F Y');
        $tanggal_selesai = Carbon::parse($kp->tanggal_selesai)->translatedFormat('j F Y');

        $pdf = Pdf::loadView('pdf.permohonan-magang.pdf-magang', [
            'no_surat'        => $kp->no_surat.'/UN53.01/DT.01.01/'.$kp->created_at->format('Y'),
            'created_at'      => $tanggal,
            'tujuan_surat'    => $kp->tujuan_surat,
            'alamat_surat'    => $kp->alamat_surat,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'no'              => 1,
            'nama'            => $data->dataMahasiswa->nama,
            'id_user'         => $data->dataMahasiswa->nim,
            'prodi'           => $data->dataMahasiswa->prodi->nama ?? '-',
            'no_hp'           => $data->dataMahasiswa->no_hp,
        ]);

        $filename = 'Permohonan_Magang_' . str_replace(' ', '_', $data->dataMahasiswa->nama) . '.pdf';
        return $pdf->download($filename);
    }

    // upload file pengajuan untuk mahasiswa
    public function uploadPermohonan(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048', // Maks 2MB
        ]);

        $file = $request->file('file');

        if ($file) {
            $fileName = 'permohonan_magang_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('public/permohonan-magang', $fileName);

            FilePengajuan::create([
                'path' => $path,
                'id_pengajuan' => $id,
            ]);

            return back()->with('success', 'File telah diupload');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}