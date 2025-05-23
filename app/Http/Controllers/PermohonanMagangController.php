<?php

namespace App\Http\Controllers;

use App\Models\PermohonanMagang;
use App\Models\FilePengajuan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;

// set format tanggal ke bahasa indonesia
Carbon::setLocale('id');

class PermohonanMagangController extends Controller
{
    public function PermohonanMagangMahasiswa(){
        $pengajuan = PermohonanMagang::with('filePengajuan')->where('user_id', Auth::id())->get();

        return view('mahasiswa.permohonan-magang.index', compact('pengajuan'));
    }

    public function PermohonanMagangAdmin(){
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

        $data = [
            'tujuan_surat' => $request->tujuan_surat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alamat_surat' => $request->alamat_surat,
            'user_id' => Auth::user()->id,
            'id_prodi' => Auth::user()->data->id_prodi
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

    // unduh + lihat pengajuan
    public function wordPermohonan(Request $request, $id)
    {
        $request->validate([
            'no_surat' => 'required|string'
        ]);

        PermohonanMagang::where('id_permohonan_magang', $id)->update([
            'no_surat' => $request->no_surat
        ]);

        $data = User::whereHas('permohonanMagang', function ($query) use ($id) {
            $query->where('status', 'Penerbitan')
                ->where('id_permohonan_magang', $id);
        })->with(['permohonanMagang' => function ($query) use ($id) {
            $query->where('status', 'Penerbitan')
                ->where('id_permohonan_magang', $id);
        }, 'dataMahasiswa.prodi'])->first();

        // dd($data->toArray());
        $template = new TemplateProcessor(public_path('template_permohonan_magang.docx'));

        foreach ($data->permohonanMagang as $kp) {
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

        $filename = 'Permohonan_Magang_' . $data->dataMahasiswa->nama . '.docx';
        $temp_file = tempnam(sys_get_temp_dir(), 'word_');
        $template->saveAs($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
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
