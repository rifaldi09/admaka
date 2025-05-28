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
            'semester_awal' => 'required',
            'semester_akhir' => 'required',
        ]);

        // Cek apakah surat aktif kuliah sudah ada
        $validasi = AktifKuliah::create([
            'keperluan' => $request->keperluan,
            'semester_awal' => $request->semester_awal,
            'semester_akhir' => $request->semester_akhir,
            'user_id' => Auth::user()->id,
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
    public function penerbitanAktifKuliah(Request $request, $id)
    {
        // dd($request->all());
        $idAktifKuliah = decrypt($id);
        $dataSurat = AktifKuliah::with('user.dataMahasiswa.prodi')->where('id_aktif_kuliah', $idAktifKuliah)->first();

        $genapGanjil = $dataSurat->user->dataMahasiswa->semester % 2 == 0 ? 'Genap' : 'Ganjil';

        $formatter = new \NumberFormatter('id', \NumberFormatter::SPELLOUT);
        $numberSemester = $dataSurat->user->dataMahasiswa->semester . ' (' . $formatter->format($dataSurat->user->dataMahasiswa->semester) . ')';

        $template = new TemplateProcessor(public_path('template/template-surat-aktif-kuliah.docx'));

        if ($dataSurat->status != 'Penerbitan') {
            $validasi = $request->validate([
                'nomor_surat' => 'required',
            ]);

            AktifKuliah::where('id_aktif_kuliah', $idAktifKuliah)->update([
                'status' => 'Penerbitan',
                'nomor_surat' => $validasi['nomor_surat'],
            ]);
            $template->setValue('nomor_surat', $validasi['nomor_surat']);
        } else {
            $nomorSurat = AktifKuliah::where('id_aktif_kuliah', $idAktifKuliah)->first();
            $template->setValue('nomor_surat', $nomorSurat->nomor_surat);
        }

        $template->setValue('nama', $dataSurat->user->dataMahasiswa->nama);
        $template->setValue('status', $dataSurat->status_kuliah);
        $template->setValue('semester_awal', $dataSurat->semester_awal);
        $template->setValue('semester_akhir', $dataSurat->semester_akhir);
        $template->setValue('nim', $dataSurat->user->dataMahasiswa->nim);
        $template->setValue('tempat_lahir', $dataSurat->user->dataMahasiswa->tempat_lahir);
        $template->setValue('tanggal_lahir', $dataSurat->user->dataMahasiswa->tanggal_lahir);
        $template->setValue('prodi', $dataSurat->user->dataMahasiswa->prodi->nama);
        $template->setValue('jenjang', $dataSurat->user->dataMahasiswa->jenjang);
        $template->setValue('semester', $numberSemester);
        $template->setValue('genap_ganjil', $genapGanjil);
        $template->setValue('tahun_akademik', $dataSurat->user->dataMahasiswa->tahun_akademik);
        $template->setValue('no_hp', $dataSurat->user->dataMahasiswa->no_hp);
        $template->setValue('sks', $dataSurat->user->dataMahasiswa->sks);
        $template->setValue('ipk', $dataSurat->user->dataMahasiswa->ipk);
        $template->setValue('tahun_now', now()->format('Y'));
        $template->setValue('tanggal_now', Carbon::now()->translatedFormat('d F Y'));

        $fileName = 'aktif_kuliah_' . $dataSurat->user->dataMahasiswa->nim . '.docx';


        $temp_file = tempnam(sys_get_temp_dir(), 'word_');
        $template->saveAs($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    // Fungsi untuk mengupload surat aktif kuliah
    public function uploadAktifKuliah(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:pdf', // Maks 2MB
        ]);

        $file = $request->file('file');
        $idAktifKuliah = decrypt($request->id);

        if ($file) {
            $fileName = 'surat_aktif_kuliah_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('public/aktif-kuliah/pdf', $fileName);

            FilePengajuan::create([
                'path' => 'app/' . $path,
                'id_pengajuan' => $idAktifKuliah,
            ]);

            return back()->with('success', 'File telah diupload');
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
        $idPengajuan = decrypt($request->id);
        $pathSurat = FilePengajuan::where('id_pengajuan', $idPengajuan)->first();
        $path = storage_path($pathSurat->path);
        return response()->download($path)->deleteFileAfterSend(false);
    }
}
