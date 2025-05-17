<?php

namespace App\Http\Controllers;

use App\Models\FilePengajuan;
use App\Models\PengajuanKP;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
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

        $data = [
            'tujuan_surat' => $request->tujuan_surat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alamat_surat' => $request->alamat_surat,
            'user_id' => Auth::user()->id,
            'id_prodi' => Auth::user()->data->id_prodi
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
            'user_id' => Auth::user()->id,
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

    // unduh + lihat pengajuan
    public function wordPengajuan(Request $request, $id)
    {   
        $request->validate([
            'no_surat' => 'required|string'
        ]);

        PengajuanKP::where('id_pengajuan', $id)->update([
            'no_surat' => $request->no_surat
        ]);

        $data = User::whereHas('pengajuanKp', function($query) use ($id) {
            $query->where('status', 'Penerbitan')
            ->where('id_pengajuan', $id);
        })->with(['pengajuanKp' => function($query) use ($id) {
            $query->where('status', 'Penerbitan')
            ->where('id_pengajuan', $id);
        }, 'dataMahasiswa.prodi'])->first();

        // dd($data->toArray());
        $template = new TemplateProcessor(public_path('template_pengajuan_kp.docx'));

        foreach($data->pengajuanKp as $kp) {
            $tanggal = Carbon::parse($kp->created_at)->translatedFormat('j F Y');
            $tanggal_mulai = Carbon::parse($kp->tanggal_mulai)->translatedFormat('j F Y');
            $tanggal_selesai = Carbon::parse($kp->tanggal_selesai)->translatedFormat('j F Y');
            $template->setValue('created_at', $tanggal);
            $template->setValue('no_surat', $kp->no_surat);
            $template->setValue('tujuan_surat', $kp->tujuan_surat);
            $template->setValue('alamat_surat', $kp->alamat_surat);
            $template->setValue('tanggal_mulai', $tanggal_mulai);
            $template->setValue('tanggal_selesai', $tanggal_selesai);
        }

        $template->setValue('no', 1);
        $template->setValue('nama', $data->dataMahasiswa->nama);
        $template->setValue('id_user', $data->dataMahasiswa->nim);
        $template->setValue('prodi', $data->dataMahasiswa->prodi->nama);
        $template->setValue('no_hp', $data->dataMahasiswa->no_hp);

        $filename = 'Pengajuan_KP_' . $data->dataMahasiswa->nama . '.docx';
        $temp_file = tempnam(sys_get_temp_dir(), 'word_');
        $template->saveAs($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
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
