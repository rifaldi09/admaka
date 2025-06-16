<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\FilePermohonan;
use App\Models\PPDP;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


// set format tanggal ke bahasa indonesia
Carbon::setLocale('id');

class PPDPController extends Controller
{
    // halaman index mahasiswa
    public function ppdpMahasiswa()
    {
        $permohonan = PPDP::where('user_id', Auth::id())->get();
        $dosen = User::whereHas('roles', function($query) {
            $query->where('role.id', 2);
        })->with(['dataDosen:nidn,nama'])->get();

        return view('mahasiswa.permohonan-pengambilan.index', compact('permohonan', 'dosen'));
    }

    // halaman index admin
    public function ppdpAdmin()
    {
        $draft = User::select('id', 'id_user')->whereHas('permohonanPengambilan', function($query) {
            $query->where('status', 'Belum Diterima');
        })->with(['permohonanPengambilan' => function($query) {
            $query->where('status', 'Belum Diterima')
            ->with(['dosen:nidn,nama']);
        }, 'dataMahasiswa'])->get();

        $diterima = User::select('id', 'id_user')->whereHas('permohonanPengambilan', function($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        })->with(['permohonanPengambilan' => function($query) {
                $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan'])
                ->with(['dosen:nidn,nama']);
        },'dataMahasiswa'])->get();

        return view('admin.permohonan-pengambilan.index', compact('draft', 'diterima'));
    }

    
    // halaman index koordinator
    public function ppdpKoordinator()
    {
        $diterima = User::whereHas('permohonanPengambilan', function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi)
            ->where('keperluan', 'skripsi');
        })->with(['permohonanPengambilan' => function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi)
            ->where('keperluan', 'skripsi');
        }, 'dataMahasiswa'])->get();


        return view('dosen.permohonan-pengambilan.index', compact('diterima'));;
    }

    // halaman index dosen
    public function ppdpDosen()
    {
        $diterima = User::whereHas('permohonanPengambilan', function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi)
            ->where('keperluan', 'mata_kuliah')
            ->where('nidn', Auth::user()->id_user);
        })->with(['permohonanPengambilan' => function($query) {
            $query->where('status', 'Diterima')
            ->where('id_prodi', Auth::user()->data->id_prodi)
            ->where('keperluan', 'mata_kuliah')
            ->where('nidn', Auth::user()->id_user)
            ->with(['dosen:nidn,nama']);
        }, 'dataMahasiswa'])->get();
        

        return view('dosen.permohonan-pengambilan.index', compact('diterima'));;
    }

    // create permohonan - mahasiswa
    public function createPermohonan(Request $request)
    {
        $request->validate([
            'tujuan_surat' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alamat_surat' => 'required',
            'keperluan' => 'required|in:skripsi,mata_kuliah',
            'judul_skripsi' => 'required_if:keperluan,skripsi',
            'dosen' => 'required_if:keperluan,mata_kuliah',
        ]);

        // buat ngakalin no_surat biar ga pakai id
        $cek_nomor_terakhir = PPDP::orderByDesc('created_at')->value('no_surat');

        if ($cek_nomor_terakhir) {
            $nomorTerakhir = (int) substr($cek_nomor_terakhir, 3);
            $no_surat = 'PPDP' . str_pad($nomorTerakhir + 1, 4, '0', STR_PAD_LEFT); 
        } else {
            $no_surat = 'PPDP0001';
        }

        $data = $request->only([
            'tujuan_surat',
            'tanggal_mulai',
            'tanggal_selesai',
            'alamat_surat',
            'keperluan'
        ]);

        $data['judul_skripsi'] = $request->keperluan === 'skripsi' ? $request->judul_skripsi : '';
        $data['nidn'] = $request->keperluan === 'mata_kuliah' ? $request->dosen : null;
        $data['user_id'] = Auth::id();
        $data['id_prodi'] = Auth::user()->data->id_prodi;
        $data['no_surat'] = $no_surat;


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
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alamat_surat' => 'required',
            'keperluan' => 'required',
            'judul_skripsi' => 'required_if:keperluan,skripsi',
            'dosen' => 'required_if:keperluan,mata_kuliah',
        ]);

        $data = $request->only([
            'tujuan_surat',
            'tanggal_mulai',
            'tanggal_selesai',
            'alamat_surat',
            'keperluan',
        ]);

        $data['judul_skripsi'] = $request->keperluan === 'skripsi' ? $request->judul_skripsi : '';
        $data['nidn'] = $request->keperluan === 'mata_kuliah' ? $request->dosen : null;
        $data['user_id'] = Auth::id();
        $data['id_prodi'] = Auth::user()->data->id_prodi;

        $permohonan->update($data);

        return back()->with('success', 'Status permohonan sudah diperbarui');
    }

    public function generatePermohonan(PPDP $permohonan)
    {
        if ($permohonan->keperluan == 'mata_kuliah') {
            $data = User::whereHas('permohonanPengambilan', function ($query) use ($permohonan) {
                $query->where('status', 'Penerbitan')
                    ->where('keperluan', 'mata_kuliah')
                    ->where('id_permohonan', $permohonan->id_permohonan);
            })->with(['permohonanPengambilan' => function ($query) use ($permohonan) {
                $query->where('status', 'Penerbitan')
                    ->where('keperluan', 'mata_kuliah')
                    ->where('id_permohonan', $permohonan->id_permohonan)
                    ->with(['dosen:nidn,nama']);
            }, 'dataMahasiswa.prodi'])->first();

            $pp = $data->permohonanPengambilan->first();

            $viewData = [
                'no_surat' => $pp->no_surat.'/UN53.01/DT.01.01/'.$pp->created_at->format('Y'),
                'tujuan_surat' => $pp->tujuan_surat,
                'alamat_surat' => $pp->alamat_surat,
                'created_at' => Carbon::parse($pp->created_at)->translatedFormat('j F Y'),
                'nama_dosen' => $pp->dosen->nama ?? '-',
                'nama' => $data->dataMahasiswa->nama,
                'nim' => $data->dataMahasiswa->nim,
                'prodi' => $data->dataMahasiswa->prodi->nama,
                'no_hp' => $data->dataMahasiswa->no_hp,
                'tempat' => $data->dataMahasiswa->tempat_lahir,
                'tanggal_lahir' => Carbon::parse($data->dataMahasiswa->tanggal_lahir)->translatedFormat('j F Y'),
            ];

            $view = 'pdf.permohonan-pengambilan.pdf-mk'; 

        } else {
            $data = User::whereHas('permohonanPengambilan', function ($query) use ($permohonan) {
                $query->where('status', 'Penerbitan')
                    ->where('keperluan', 'skripsi')
                    ->where('id_permohonan', $permohonan->id_permohonan);
            })->with(['permohonanPengambilan' => function ($query) use ($permohonan) {
                $query->where('status', 'Penerbitan')
                    ->where('keperluan', 'skripsi')
                    ->where('id_permohonan', $permohonan->id_permohonan);
            }, 'dataMahasiswa.prodi'])->first();

            $pp = $data->permohonanPengambilan->first();

            $viewData = [
                'no_surat' => $pp->no_surat.'/UN53.01/DT.01.01/'.$pp->created_at->format('Y'),
                'tujuan_surat' => $pp->tujuan_surat,
                'alamat_surat' => $pp->alamat_surat,
                'judul_skripsi' => $pp->judul_skripsi,
                'created_at' => Carbon::parse($pp->created_at)->translatedFormat('j F Y'),
                'nama' => $data->dataMahasiswa->nama,
                'nim' => $data->dataMahasiswa->nim,
                'prodi' => $data->dataMahasiswa->prodi->nama,
                'no_hp' => $data->dataMahasiswa->no_hp,
                'tempat' => $data->dataMahasiswa->tempat_lahir,
                'tanggal_lahir' => Carbon::parse($data->dataMahasiswa->tanggal_lahir)->translatedFormat('j F Y'),
            ];

            $view = 'pdf.permohonan-pengambilan.pdf-skripsi';
        }

        $pdf = Pdf::loadView($view, $viewData);
        $filename = 'Permohonan_Pengambilan_Data_' . $viewData['nama'] . '.pdf';
        return $pdf->download($filename);
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
