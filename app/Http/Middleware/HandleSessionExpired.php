<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HandleSessionExpired
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user belum login (session habis)
        if (Auth::guest()) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => 'Session expired'], 419);
            } else {
                return redirect()->route('login')->with('error', 'Session Anda telah habis.');
            }
        }

        return $next($request);
    }
}