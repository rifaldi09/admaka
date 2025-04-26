<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    // fungsi proses login
    public function loginProcess(Request $request)
    {
        //validasi data kosong
        $data = $request->validate([
            'username' => 'required|min:8',
            'password' => 'required',
        ]);

        // ambil kredensial user dari request
        $credentials = $request->only('username', 'password');

        // lakukan login
        if(FacadesAuth::attempt($credentials)) {
            // sementara untuk urlnya arahin ke admin
            return redirect()->to('admin')->with('success_login', 'Login telah berhasil');
        } else {
            return back()->with('failed_login', 'Login gagal dilakukan');
        }
    }
}
