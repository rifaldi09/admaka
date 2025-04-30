<?php

namespace App\Http\Controllers;

class HomepageController extends Controller
{
    public function index()
    {
        return view('homepage.index');
    }

    // untuk kehalaman dashboard
    public function dashboard()
    {
        return view('dashboard.home');
    }
}
