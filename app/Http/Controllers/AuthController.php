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
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.regex'     => 'Kata sandi wajib mengandung minimal 1 huruf kapital dan 1 nomor.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
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
            return redirect()->route('verification.notice')->with('success', 'Email verifikasi telah berhasil dikirim ke ' . $user->email . '! Silakan periksa Kotak Masuk (Inbox) email Anda.');
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim email verifikasi: '.$e->getMessage());
            return redirect()->route('verification.notice')->with('error', 'Gagal mengirim email verifikasi otomatis: ' . $e->getMessage() . '. Silakan klik tombol "Kirim Ulang Email Verifikasi".');
        }
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
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.regex'     => 'Kata sandi wajib mengandung minimal 1 huruf kapital dan 1 nomor.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
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

        // Simpan token ke database dengan enkripsi Bcrypt (Standar Resmi OWASP & Laravel)
        // Permintaan baru otomatis menganulir (menghapus) keabsahan token sebelumnya
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Mengirimkan notifikasi email resmi berisi link token terbaru
        try {
            $user->sendPasswordResetNotification($token);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email reset password: '.$e->getMessage());
            return back()->withErrors(['email' => 'Gagal mengirim email reset password. Silakan periksa konfigurasi email Anda.']);
        }

        // Bersihkan cache redirect lama untuk email ini
        \Illuminate\Support\Facades\Cache::forget('reset_redirect_' . md5($request->email));

        return back()->with('success', 'Link reset password telah dikirim ke email Anda.')
                     ->with('reset_email', $request->email);
    }

    /**
     * Menampilkan form reset password
     */
    public function resetPasswordForm(Request $request, $token)
    {
        // Validasi Standar Resmi: pastikan token cocok dengan token terbaru di database & belum kadaluarsa
        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        $isValid = $reset 
            && Hash::check($token, $reset->token) 
            && !Carbon::parse($reset->created_at)->addMinutes(60)->isPast();

        if (!$isValid) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Link reset password ini sudah tidak berlaku karena Anda telah meminta link baru atau sudah lewat dari 60 menit. Silakan buka email TERBARU atau minta link baru di bawah ini.'
            ]);
        }

        // Catat di Cache agar layar laptop otomatis berpindah ke form ini secara real-time
        if ($request->filled('email')) {
            \Illuminate\Support\Facades\Cache::put(
                'reset_redirect_' . md5($request->email),
                route('password.reset', ['token' => $token, 'email' => $request->email], false),
                now()->addMinutes(10)
            );
        }

        return view('reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*[0-9]).+$/'],
        ], [
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.regex'     => 'Kata sandi wajib mengandung minimal 1 huruf kapital dan 1 nomor.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // 1. Verifikasi kecocokan token dengan hash Bcrypt di database
        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa. Pastikan Anda membuka link dari email TERBARU yang kami kirimkan.']);
        }

        // 2. Verifikasi batas waktu (kedaluwarsa 60 menit)
        if (Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['email' => 'Token reset password sudah kadaluarsa (lebih dari 60 menit). Silakan minta link reset baru.']);
        }

        // 3. Update password user dengan hash Bcrypt yang aman
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // 4. Prinsip Sekali Pakai (One-Time Use): Hapus token seketika dari database setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Bersihkan cache redirect
        if ($request->filled('email')) {
            \Illuminate\Support\Facades\Cache::forget('reset_redirect_' . md5($request->email));
        }

        // 5. Logout jika user sedang dalam sesi login agar bisa login bersih dengan password baru
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk dengan kata sandi baru.');
    }
}
