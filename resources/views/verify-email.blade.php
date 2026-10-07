<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verifikasi Email - {{ config('app.name', 'U-Market') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#FDA1A2]/20 dark:bg-[#1D1842] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white/98 dark:bg-[#1D1842] rounded-3xl shadow-xl shadow-gray-300/30 dark:shadow-[#1D1842]/50 p-8 md:p-10 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/30">
        <div class="flex justify-center mb-6">
            <a href="/" class="cursor-pointer hover:opacity-80 transition-opacity">
                <img src="/images/logo-u.png" alt="U Marketplace" class="h-20 w-auto object-contain">
            </a>
        </div>

        <div class="text-center mb-6">
            <div class="w-16 h-16 mx-auto mb-4 bg-[#8E0D3C]/10 dark:bg-[#8E0D3C]/25 rounded-2xl flex items-center justify-center text-[#8E0D3C] dark:text-[#FDA1A2]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-[#8E0D3C] dark:text-[#FDA1A2] mb-2">
                Verifikasi Email Anda
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                Tautan verifikasi telah dikirim ke:
                <br>
                <span class="font-semibold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-lg inline-block mt-1">
                    {{ auth()->user()->email ?? 'email Anda' }}
                </span>
            </p>
        </div>

        @if (session('success'))
            <div class="mb-5 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/50 flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-emerald-800 dark:text-emerald-200 leading-relaxed font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/50 flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-red-800 dark:text-red-200 leading-relaxed">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Informasi dan Tips Penting -->
        <div class="mb-6 p-4 rounded-2xl bg-amber-50/80 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/40 text-xs text-amber-900 dark:text-amber-200 space-y-2">
            <div class="flex items-center gap-1.5 font-semibold text-amber-800 dark:text-amber-300">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Tips jika email belum masuk:</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-amber-800/90 dark:text-amber-200/90 pl-1 leading-relaxed">
                <li>Periksa folder <strong>Spam</strong> atau <strong>Junk</strong> di email Anda.</li>
                <li>Email dikirim dari <strong>marketunila@gmail.com</strong> dengan nama <strong>U-Market</strong>.</li>
                <li>Jika membuka link dari HP, pastikan HP terhubung ke internet.</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('verification.send') }}" id="resend-form" class="space-y-4">
            @csrf
            <button
                type="submit"
                id="resend-btn"
                class="w-full bg-[#8E0D3C] hover:bg-[#a01246] dark:bg-[#8E0D3C] dark:hover:bg-[#a01246] text-white font-semibold py-3.5 px-4 rounded-xl shadow-md shadow-[#8E0D3C]/20 transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span id="btn-text">Kirim Ulang Email Verifikasi</span>
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span>Salah alamat email?</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-[#EF3B33] dark:text-[#FDA1A2] font-semibold hover:underline cursor-pointer">
                    Keluar / Daftar Ulang
                </button>
            </form>
        </div>
    </div>

    <script>
        const resendForm = document.getElementById('resend-form');
        const resendBtn = document.getElementById('resend-btn');
        const btnText = document.getElementById('btn-text');

        if (resendForm && resendBtn) {
            resendForm.addEventListener('submit', function() {
                resendBtn.disabled = true;
                resendBtn.classList.add('opacity-70', 'cursor-not-allowed');
                btnText.textContent = 'Mengirim email...';
            });
        }

        // Live polling: jika email diverifikasi via browser HP / tab lain, langsung auto-redirect
        const checkVerification = setInterval(async () => {
            try {
                const response = await fetch('/api/user');
                if (response.ok) {
                    const user = await response.json();
                    if (user && user.email_verified_at) {
                        clearInterval(checkVerification);
                        window.location.href = '/?verified=1';
                    }
                }
            } catch (error) {
                console.error('Gagal memeriksa status verifikasi:', error);
            }
        }, 3000);
    </script>
</body>
</html>
