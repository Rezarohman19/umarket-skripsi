<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    // Jika user belum login, redirect ke halaman login
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('welcome');
});

// Login page - Frontend only, tidak mengubah backend
Route::get('/login', function () {
    // Jika sudah login, redirect ke dashboard atau home
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('login');
})->name('login');

// Authentication routes - Form submission tradisional Laravel (langsung ke database)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $remember = $request->boolean('remember', false);

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau kata sandi salah.',
    ])->onlyInput('email');
});

// Dashboard - sementara menggunakan blade, nanti bisa diganti dengan halaman dashboard Vue.js
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    return view('dashboard');
})->name('dashboard');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Route untuk logout via GET (untuk memudahkan testing)
Route::get('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
