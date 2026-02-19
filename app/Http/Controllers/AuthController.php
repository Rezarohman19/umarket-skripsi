<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function loginForm()
    {
        return view('login');
    }

    /**
     * Proses login user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            // Jika email belum terverifikasi, arahkan ke halaman verifikasi
            if (!Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Redirect intensi awal atau default ke beranda
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    /**
     * Menampilkan form register
     */
    public function registerForm()
    {
        return view('register');
    }

    /**
     * Proses registrasi user
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pengguna', // default role
        ]);

        Auth::login($user);

        // Kirim email verifikasi
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            // Optional: log error pengiriman email
            \Log::error('Gagal mengirim email verifikasi: '.$e->getMessage());
        }

        return redirect()->route('verification.notice');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * API Login - Return Bearer Token (untuk client/SPA terpisah)
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Jika email belum terverifikasi
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Silakan verifikasi email Anda terlebih dahulu.',
            ], 403);
        }

        // Login ke Web Session
        Auth::login($user, true);

        // Generate token (Sanctum - opsional jika masih ada yang pakai)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    /**
     * API Register - Return Bearer Token
     */
    public function apiRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pengguna',
        ]);

        // Auto login ke session
        Auth::login($user);

        // Generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kirim email verifikasi
        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim email verifikasi: '.$e->getMessage());
        }

        return response()->json([
            'message' => 'Registration success',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    /**
     * API Logout - Revoke semua tokens
     */
    public function apiLogout(Request $request)
    {
        // Revoke current token if using Sanctum token
        if ($request->user() && method_exists($request->user(), 'currentAccessToken') && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        // Logout from Web Session (Blade)
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logout success',
        ]);
    }

    /**
     * Get authenticated user profile (JSON)
     */
    public function profile()
    {
        return response()->json(Auth::user());
    }

    /**
     * Menampilkan form lupa password
     */
    public function forgotPasswordForm()
    {
        return view('forgot-password');
    }

    /**
     * Mengirim link reset password ke email
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Laravel standard reset password notification
        $user = User::where('email', $request->email)->first();
        
        // Generate Token Manual jika ingin kontrol lebih (tapi Laravel punya facade Password)
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Kebutuhan reset password Laravel biasanya menggunakan Notification
        // Namun kita bisa menggunakan cara manual untuk kemudahan visual di demo
        // Redirect dengan token agar user bisa "melihat" simulasi jika email lambat
        
        // Menggunakan Notification standar Laravel:
        try {
            $user->sendPasswordResetNotification($token);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email reset password: '.$e->getMessage());
            return back()->withErrors(['email' => 'Gagal mengirim email reset password. Silakan cek konfigurasi email Anda.']);
        }

        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }

    /**
     * Menampilkan form reset password
     */
    public function resetPasswordForm(Request $request, $token)
    {
        return view('reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.']);
        }

        // Cek waktu (opsional, Laravel default 60 menit)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
             return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password Anda berhasil diperbarui. Silakan login.');
    }
}
