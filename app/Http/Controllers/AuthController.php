<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        //validasi data kosong
        $data = $request->validate([
            'username' => 'required|min:8',
            'password' => 'required',
        ]);
    }
}
