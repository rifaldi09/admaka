<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Prodi;

class MahasiswaController extends Controller
{
    // Mahasiswa profile page
    public function lihatProfilMhs()
    {
        // Get data
        $user = auth()->user()->data;
        $dataProdis = Prodi::all();

        return view('dashboard.profileMhs', compact('user', 'dataProdis'), ['titleHeader' => 'Profile Mahasiswa']);
    }

    // Mahasiswa profile update
    public function updateMhs(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'nim' => 'required|min:3',
            'nama' => 'required|string|min:3',
            'email' => 'required|email|min:5',
            'id_prodi' => 'required',
            'tempat_lahir' => 'required|string|min:5',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|string|min:6',
            'jenjang' => 'required|in:Strata 1,Strata 2',
            'semester' => 'required|integer',
            'tahun_akademik' => 'required|string',
            'ipk' => 'required',
            'sks' => 'required|integer',
        ]);

        // Get user login
        $user = auth()->user();

        $mahasiswa = Mahasiswa::where('nim', $user->id_user)->first();

        if ($mahasiswa) {
            // $mahasiswa->update([
            //     'nama' => $validated['nama'],
            //     'email' => $validated['email'],
            //     'id_prodi' => $validated['id_prodi'],
            //     'tempat_lahir' => $validated['tempat_lahir'],
            //     'tanggal_lahir' => $validated['tanggal_lahir'],
            //     'no_hp' => $validated['no_hp'],
            //     'jenjang' => $validated['jenjang'],
            //     'semester' => $validated['semester'],
            //     'tahun_akademik' => $validated['tahun_akademik'],
            //     'ipk' => $validated['ipk'],
            //     'sks' => $validated['sks'],
            // ]);
            $mahasiswa->update($validated);
        } else {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }

        return redirect()->back()->with('success', 'Update profile berhasil');
    }

    // surat aktif kuliah
    public function aktifKuliah()
    {
        // return view('');
    }

    // surat kerja praktik
    public function lihatProfkerjaPraktikil()
    {
        // return view('');
    }
    public function menuMahasiswa()
    {
        $menuSurat = Menu::where('header', 'Surat')->get();
        return view('mahasiswa.menu', compact('menuSurat'));
    }
}
