<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        return view('homepage.index');
    }

    // untuk kehalaman admin LTE (sementara)
    public function admin()
    {
        return view('layout.admin.home');
    }
}
