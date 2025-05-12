<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login', ['title' => 'ADMAKA Login']);
    }

    // fungsi proses login
    public function loginProcess(Request $request)
    {
        //validasi data kosong
        $data = $request->validate([
            'id_user' => 'required',
            'password' => 'required',
        ]);

        // ambil kredensial user dari request
        $credentials = $request->only('id_user', 'password');

        // lakukan login
        if(FacadesAuth::attempt($credentials)) {
            return redirect()->to('dashboard')->with('success', 'Login telah berhasil');
        } else {
            return back()->with('error', 'Login gagal dilakukan');
        }
    }

    public function logout()
    {
        FacadesAuth::logout();

        return redirect()->to('login')->with('success', 'Logout telah berhasil');
    }
}
