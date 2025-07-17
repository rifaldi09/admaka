<?php

namespace App\Http\Controllers;

use App\Models\FilePengajuan;
use App\Models\Transkrip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NomorSuratHistory;

class TranskripController extends Controller
{
    public function transkripMahasiswa()
    {
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Mahasiswa')) {
            abort(403, 'Akses ditolak.');
        }
        $transkrip = Transkrip::where('user_id', Auth::user()->id)->get();

        return view('mahasiswa.transkrip-nilai.index', compact('transkrip'));
    }

    public function transkripAdmin()
    {
        $user = auth()->user();

        if (Auth::check() && !$user->roles->contains('name_role', 'Administrator')) {
            abort(403, 'Akses ditolak.');
        }

        $draft = User::select('id', 'id_user')->whereHas('transkrip', function ($query) {
            $query->where('status', 'Belum Diterima');
        })->with(['transkrip' => function ($query) {
            $query->where('status', 'Belum Diterima');
        }, 'dataMahasiswa'])->get();

        $diterima = User::select('id', 'id_user')->whereHas('transkrip', function ($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        })->with(['transkrip' => function ($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        }, 'dataMahasiswa'])->get();

        return view('admin.transkrip-nilai.index', compact('draft', 'diterima'));
    }

    public function transkripSuperAdmin()
    {
        $user = auth()->user();

        if (Auth::check() && !$user->roles->contains('name_role', 'Super-Administrator')) {
            abort(403, 'Akses ditolak.');
        }

        $draft = User::select('id', 'id_user')->whereHas('transkrip', function ($query) {
            $query->where('status', 'Belum Diterima');
        })->with(['transkrip' => function ($query) {
            $query->where('status', 'Belum Diterima');
        }, 'dataMahasiswa'])->get();

        $diterima = User::select('id', 'id_user')->whereHas('transkrip', function ($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        })->with(['transkrip' => function ($query) {
            $query->whereIn('status', ['Diterima', 'Ditolak', 'Penerbitan']);
        }, 'dataMahasiswa'])->get();

        return view('admin.transkrip-nilai.index', compact('draft', 'diterima'));
    }

    public function transkripWD()
    {
        $user = auth()->user();
        if (Auth::check() && !$user->roles->contains('name_role', 'Wakil-Dekan-1')) {
            abort(403, 'Akses ditolak.');
        }
        $diterima = User::select('id', 'id_user')->whereHas('transkrip', function ($query) {
            $query->where('status', 'Diterima');
        })->with(['transkrip' => function ($query) {
            $query->where('status', 'Diterima');
        }, 'dataMahasiswa'])->get();

        return view('dosen.transkrip-nilai.index', compact('diterima'));
    }

    public function createTranskrip(Request $request)
    {
        $request->validate([
            'keperluan' => 'required'
        ]);
        
      $hasIncomplete = \App\Models\Mahasiswa::where('nim', Auth::user()->id_user)
        ->where(function ($query) {
            $query->whereNull('nama')->orWhere('nama', '')
                ->orWhereNull('email')->orWhere('email', '')
                ->orWhereNull('id_prodi')
                ->orWhereNull('tempat_lahir')->orWhere('tempat_lahir', '')
                ->orWhereNull('tanggal_lahir')
                ->orWhereNull('no_hp')->orWhere('no_hp', '')
                ->orWhereNull('jenjang')->orWhere('jenjang', '')
                ->orWhereNull('semester')
                ->orWhereNull('tahun_akademik')->orWhere('tahun_akademik', '')
                ->orWhereNull('ipk')
                ->orWhereNull('sks');
        })->exists();

        if ($hasIncomplete) {
            return redirect()->back()->with('error', 'Data mahasiswa belum lengkap. Mohon lengkapi dulu.');
        }
        
        Transkrip::create([
            'keperluan' => $request->keperluan,
            'user_id' => Auth::user()->id
        ]);

        return back()->with('success', 'Transkrip telah dibuat');
    }

    public function terimaTranskrip(Transkrip $transkrip)
    {
        $transkrip->update([
            'status' => 'diterima'
        ]);

        return back()->with('success', 'Status transkrip telah diperbarui');
    }

    public function penerbitanTranskrip(Transkrip $transkrip)
    {
        $tahun = date('Y');
        $lastHistory = NomorSuratHistory::where('tahun', $tahun)
                ->where('id_surat', $transkrip->id_transkrip)
                ->orderByDesc('created_at') // atau orderByDesc('no_surat') kalau urutan berdasarkan nomor
                ->first();
        if ($lastHistory) {
            $nomorSurat = $lastHistory->no_surat;
        } else {
            $nomorSurat = generateNomorSurat('Transkrip Nilai', $transkrip->id_transkrip);
        }
        
     
        $transkrip->update([
            'status' => 'Penerbitan',
            'no_surat'=> $nomorSurat
        ]);

        return back()->with('success', 'Status transkrip telah diperbarui');
    }

    public function tolakTranskrip(Request $request, Transkrip $transkrip)
    {
        $request->validate([
            'alasan_ditolak' => 'required'
        ]);

        $transkrip->update([
            'status' => 'Ditolak',
            'alasan_ditolak' => $request->alasan_ditolak
        ]);

        return back()->with('success', 'Status transkrip telah diperbarui');
    }

    public function editTranskrip(Request $request, Transkrip $transkrip)
    {
        $request->validate([
            'keperluan' => 'required'
        ]);

        $transkrip->update([
            'keperluan' => $request->keperluan,
            'status' => "Belum Diterima",
            'alasan_ditolak' => ''
        ]);

        return back()->with('success', 'Transkrip telah diperbarui');
    }

    public function uploadTranskrip(Request $request, Transkrip $transkrip)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');

        if ($file) {
            $fileName = 'transkrip' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('public/transkrip', $fileName);

            FilePengajuan::create([
                'path' => $path,
                'id_pengajuan' => $transkrip->id_transkrip
            ]);

            return back()->with('success', 'File telah diupload');
        }

        return back()->with('error', 'File tidak ditemukan.');
    }
}