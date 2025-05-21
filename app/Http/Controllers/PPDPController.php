<?php

namespace App\Http\Controllers;

use App\Models\FilePermohonan;
use App\Models\PPDP;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// set format tanggal ke bahasa indonesia
Carbon::setLocale('id');

class PPDPController extends Controller
{
    // halaman index mahasiswa
    public function ppdpMahasiswa()
    {
        $permohonan = PPDP::where('user_id', Auth::id())->get();

        return view('mahasiswa.permohonan-pengambilan.index', compact('permohonan'));
    }

    // halaman index admin
    public function ppdpAdmin()
    {
        $draft = User::whereHas('permohonanPengambilan', function($query) {
            $query->where('status', 'Belum Diterima');
        })->with(['permohonanPengambilan' => function($query) {
            $query->where('status', 'Belum Diterima');
        }, 'dataMahasiswa'])->get();

        $diterima = User::whereHas('permohonanPengambilan', function($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        })->with(['permohonanPengambilan' => function($query) {
                $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        },'dataMahasiswa'])->get();

        return view('admin.permohonan-pengambilan.index', compact('draft', 'diterima'));
    }

    
    // halaman index koordinator
    public function ppdpKoordinator()
    {
        $diterima = User::whereHas('permohonanPengambilan', function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi);
        })->with(['permohonanPengambilan' => function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi);
        }, 'dataMahasiswa'])->get();

        return view('dosen.permohonan-pengambilan.index', compact('diterima'));;
    }

    // create permohonan - mahasiswa
    public function createPermohonan(Request $request)
    {
        $request->validate([
            'tujuan_surat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alamat_surat' => 'required',
            'judul_skripsi' => 'required'
        ]);

        $data = [
            'tujuan_surat' => $request->tujuan_surat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alamat_surat' => $request->alamat_surat,
            'judul_skripsi' => $request->judul_skripsi,
            'user_id' => Auth::user()->id,
            'id_prodi' => Auth::user()->data->id_prodi
        ];

        PPDP::create($data);

        return back()->with('success', 'Permohonan sudah dibuat');
    }

    // terima permohonan mahasiswa
    public function terimaPermohonan(PPDP $permohonan)
    {
        $permohonan->update([
            'status' => 'Diterima'
        ]);

        return back()->with('success', 'Status permohonan sudah diperbarui');
    }

    // penerbitan permohonan mahasiswa
    public function penerbitanPermohonan(PPDP $permohonan)
    {
        $permohonan->update([
            'status' => 'Penerbitan'
        ]);

        return back()->with('success', 'Status permohonan sudah diperbarui');
    }

    // tolak permohonan mahasiswa
    public function tolakPermohonan(Request $request, PPDP $permohonan)
    {
        $request->validate([
            'alasan_ditolak' => 'required'
        ]);

        $permohonan->update([
            'alasan_ditolak' => $request->alasan_ditolak,
            'status' => 'Ditolak'    
        ]);

        return back()->with('success', 'Status permohonan sudah diperbarui');
    }

    // ubah permohonan mahasiswa
    public function editPermohonan(Request $request, PPDP $permohonan)
    {
        $request->validate([
            'tujuan_surat' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'alamat_surat' => 'required',
            'judul_skripsi' => 'required'
        ]);

        $data = [
            'tujuan_surat' => $request->tujuan_surat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alamat_surat' => $request->alamat_surat,
            'judul_skripsi' => $request->judul_skripsi,
            'alasan_ditolak' => '',
            'status' => 'Belum Diterima'
        ];

        $permohonan->update($data);

        return back()->with('success', 'Status permohonan sudah diperbarui');
    }

    // fungsi generate permohonan untuk sementara
    public function generatePermohonan(Request $request, PPDP $permohonan)
    {
        $request->validate([
            'no_surat' => 'required'
        ]);

        $phpWord = new PhpWord();

        $section = $phpWord->addSection();

        $section->addText('File sementara buat simulasi', ['bold' => true, 'size' => 16]);

        $filename = 'surat-permohonan.docx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }

    // upload file permohonan
    public function uploadPermohonan(Request $request, PPDP $permohonan)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048', // Maks 2MB
        ]);

        $file = $request->file('file');
        
        if ($file) {
            $fileName = 'surat_permohonan_pengambilan_data_penelitian_' . time() . '.' . $file->getClientOriginalExtension();
            
            $path = $file->storeAs('public/permohonan-pengambilan', $fileName);

            FilePermohonan::create([
                'path' => $path,
                'id_permohonan' => $permohonan->id_permohonan
            ]);
            
            return back()->with('success', 'File telah diupload');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}
