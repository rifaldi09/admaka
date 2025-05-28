<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratRekomendasi;
use App\Models\Prodi;
use App\Models\FilePengajuan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;

Carbon::setLocale('id');

class RekomendasiController extends Controller
{
    public function rekomendasiMahasiswa()
    {
        $dataUser = Auth::user()->data;
        $prodiUser = Prodi::find($dataUser->id_prodi);
        $dataSurat = SuratRekomendasi::with('filePengajuan')->where('user_id', Auth::user()->id)->get();
        // dd($dataSurat);
        return view('mahasiswa.surat-rekomendasi.index', compact('dataSurat', 'dataUser', 'prodiUser'));
    }
    public function rekomendasiAdmin()
    {
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

        if ($validasi) {
            if (!empty($req->tempat_perihal)) {
                SuratRekomendasi::create([
                    'perihal' => $validasi['perihal'],
                    'tempat_perihal' => $req->tempat_perihal,
                    'user_id' => Auth::user()->id,
                ]);
            } else {
                SuratRekomendasi::create([
                    'perihal' => $validasi['perihal'],
                    'user_id' => Auth::user()->id,
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
            'status' => 'Diterima',
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
    public function penerbitanSuratRekomendasi(Request $req, $id)
    {
        // dd($req->all(),$id);
        $idRekomendasi = decrypt($id);
        $dataSurat = SuratRekomendasi::with('user.dataMahasiswa.prodi')->where('id_rekomendasi', $idRekomendasi)->first();

        $formatter = new \NumberFormatter('id', \NumberFormatter::SPELLOUT);
        $numberSemester = $dataSurat->user->dataMahasiswa->semester . ' (' . $formatter->format($dataSurat->user->dataMahasiswa->semester) . ')';

        $template = new TemplateProcessor(public_path('template/template-surat-rekomendasi.docx'));

        if ($dataSurat->status != 'Penerbitan') {
            $validasi = $req->validate(([
                'nomor_surat' => 'required',
                'konversi_sks' => 'required|integer',
            ]));

            if ($validasi) {
                SuratRekomendasi::where('id_rekomendasi', $idRekomendasi)->update([
                    'status' => 'Penerbitan',
                    'nomor_surat' => $validasi['nomor_surat'],
                    'konversi_sks' => $validasi['konversi_sks'],
                ]);
                $template->setValue('nomor_surat', $validasi['nomor_surat']);
                $template->setValue('konversi_sks', $validasi['konversi_sks']);
            } else {
                return redirect()->back()->with('error', 'Gagal menerbitkan surat');
            }
        } else {
            // $surat = SuratRekomendasi::where('id_rekomendasi', $idRekomendasi)->first();
            $template->setValue('nomor_surat', $dataSurat->nomor_surat);
            $template->setValue('konversi_sks', $dataSurat->konversi_sks);
        }

        $template->setValue('nama_mahasiswa', $dataSurat->user->dataMahasiswa->nama);
        $template->setValue('nim', $dataSurat->user->dataMahasiswa->nim);
        $template->setValue('prodi', $dataSurat->user->dataMahasiswa->prodi->nama);
        $template->setValue('semester', $numberSemester);
        $template->setValue('tahun_akademik', $dataSurat->user->dataMahasiswa->tahun_akademik);
        $template->setValue('ipk', $dataSurat->user->dataMahasiswa->ipk);
        $template->setValue('tanggal_now', Carbon::now()->translatedFormat('d F Y'));
        $template->setValue('perihal', $dataSurat->perihal);
        $template->setValue('tempat_perihal', $dataSurat->tempat_perihal);

        $fileName = 'surat_rekomendasi_' . $dataSurat->user->dataMahasiswa->nim . '.docx';


        $temp_file = tempnam(sys_get_temp_dir(), 'word_');
        $template->saveAs($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
    public function uploadSuratRekomendasi(Request $req){
        $req->validate([
            'file' => 'required|mimes:pdf', // Maks 2MB
        ]);

        $file = $req->file('file');
        $idRekomendasi = decrypt($req->id);

        if ($file) {
            $fileName = 'surat_rekomendasi_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('public/surat-rekomendasi/pdf', $fileName);

            FilePengajuan::create([
                'path' => 'app/' . $path,
                'id_pengajuan' => $idRekomendasi,
            ]);

            return back()->with('success', 'File telah diupload');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
    public function unduhSuratRekomendasi(Request $req){
        $idPengajuan = decrypt($req->id);
        $pathSurat = FilePengajuan::where('id_pengajuan', $idPengajuan)->first();
        $path = storage_path($pathSurat->path);
        return response()->download($path)->deleteFileAfterSend(false);
    }
}
