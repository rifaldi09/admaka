<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard Page
    public function dashboard()
    {
        return view('dashboard.home');
    }

    // User profile page
    public function lihatProfil()
    {
        $user = auth()->user()->data;
        $userLog = auth()->user();

        return view('dashboard.profile', compact('user', 'userLog'));
    }
}
