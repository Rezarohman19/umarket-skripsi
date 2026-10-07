<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Berhasil - {{ config('app.name', 'U-Market') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#FDA1A2]/20 dark:bg-[#1D1842] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white dark:bg-[#1D1842] rounded-3xl shadow-xl shadow-gray-300/30 dark:shadow-[#1D1842]/50 p-8 md:p-10 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/30 text-center">
        
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <a href="/" class="cursor-pointer hover:opacity-80 transition-opacity">
                <img src="/images/logo-u.png" alt="U Marketplace" class="h-20 w-auto object-contain">
            </a>
        </div>

        <!-- Success Animated Icon -->
        <div class="w-20 h-20 mx-auto mb-5 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/20 ring-8 ring-emerald-50 dark:ring-emerald-950/30">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <!-- Title -->
        <h1 class="text-2xl md:text-3xl font-bold text-[#8E0D3C] dark:text-[#FDA1A2] mb-3">
            Verifikasi Email Berhasil!
        </h1>

        <!-- Subtitle & Email Info -->
        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
            Alamat email
            <span class="font-semibold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800 px-2.5 py-0.5 rounded-lg inline-block my-1">
                {{ $user->email }}
            </span>
            <br>
            telah berhasil diverifikasi. Akun Anda kini aktif sepenuhnya.
        </p>

        <!-- CTA Button -->
        <a
            href="/"
            id="redirect-btn"
            class="w-full inline-flex items-center justify-center gap-2 bg-[#8E0D3C] hover:bg-[#a01246] text-white font-semibold py-3.5 px-6 rounded-xl shadow-md shadow-[#8E0D3C]/20 transition-all duration-200 cursor-pointer"
        >
            <span>Mulai Belanja di U-Market</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </a>

        <!-- Countdown Notice -->
        <p class="mt-4 text-xs text-gray-400 dark:text-gray-500">
            Mengalihkan otomatis ke beranda dalam <span id="countdown" class="font-semibold text-[#8E0D3C] dark:text-[#FDA1A2]">3</span> detik...
        </p>
    </div>

    <script>
        let seconds = 3;
        const countdownEl = document.getElementById('countdown');
        const timer = setInterval(() => {
            seconds--;
            if (countdownEl) countdownEl.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = '/';
            }
        }, 1000);
    </script>
</body>
</html>
