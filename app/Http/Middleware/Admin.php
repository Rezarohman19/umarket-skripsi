<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Middleware untuk cek apakah user adalah admin
     * Digunakan untuk melindungi admin routes
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        return $next($request);
    }
}
