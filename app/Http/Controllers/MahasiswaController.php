<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function lihatProfil()
    {
        return view('mahasiswa.profile');
    }

    
    //tempat crud mahasiswa
    public function storeMhs(Request $request)
    {
       
        // validasi input
        
        $validasi = $request->validate([
            'nim'            => 'required|string|unique:mahasiswa,nim',
            'nama'           => 'required|string|max:255',
            'email'          => 'required|email|unique:mahasiswa,email',
            'prodi'          => 'required|exists:prodi,id',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'no_hp'          => 'required|string|max:20',
        ]);
        
        try {
            // Simpan ke database
            Mahasiswa::create([
                'nim'            => $validasi['nim'],
                'nama'           => $validasi['nama'],
                'email'          => $validasi['email'],
                'id_prodi'       => $validasi['prodi'],
                'tempat_lahir'   => $validasi['tempat_lahir'],
                'tanggal_lahir'  => $validasi['tanggal_lahir'],
                'no_hp'          => $validasi['no_hp'],
            ]);
            
            User::create([
                'id_user'        => $validasi['nim'],
                'password'       => Hash::make($validasi['nim']),
                'id_role'        => 1,
            ]);
    
            // Jika berhasil
            return redirect()->route('data-master')->with('success', 'Data Mahasiswa berhasil ditambahkan');
        } catch (QueryException $e) {
            // Log error untuk debugging
            Log::error('Gagal menambahkan data mahasiswa: ' . $e->getMessage());
    
            // Redirect balik dengan error message
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data Mahasiswa. Silakan coba lagi.');
        }
    
    }
}