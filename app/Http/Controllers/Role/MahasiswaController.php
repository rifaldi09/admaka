<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Prodi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MahasiswaController extends Controller
{
    // Mahasiswa profile page
    public function lihatProfilMhs()
    {
        // Get data
        $user = auth()->user()->data;
        $dataProdis = Prodi::all();

        return view('dashboard.profileMhs', compact('user', 'dataProdis'), ['titleHeader' => 'Profil Mahasiswa']);
    }

    // Mahasiswa profile update
    public function updateProfilMhs(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
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
            $mahasiswa->update($validated);
        } else {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }

        return redirect()->back()->with('success', 'Update profile berhasil');
    }

    // Mahasiswa password update
    public function updatePasswordMhs(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini salah.',
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Update password berhasil');
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
