<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DosenController extends Controller
{
    // Dosen profile page
    public function lihatProfilDosen()
    {
        // Get data
        $user = auth()->user()->data;
        $dataProdis = Prodi::all();

        return view('dashboard.profileDosen', compact('user', 'dataProdis'), ['titleHeader' => 'Profil Dosen']);
    }

    // Dosen profile update
    public function updateProfilDosen(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|min:5|max:18',
            'nama' => 'required|string|min:3',
            'email' => 'required|email|min:5',
            'tempat_lahir' => 'required|string|min:5',
            'tanggal_lahir' => 'required',
            'id_prodi' => 'required',
            'no_hp' => 'required|string|min:6',
        ]);

        // Get user login
        $user = auth()->user();
        $dosen = Dosen::where('nidn', $user->id_user)->first();

        if ($dosen) {
            $dosen->update($validated);
        } else {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }

        return redirect()->back()->with('success', 'Update profile berhasil');
    }

    // Dosen password update
    public function updatePasswordDosen(Request $request)
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
}
