<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verifikasi Email - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#FDA1A2]/20 dark:bg-[#1D1842] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white/98 dark:bg-[#1D1842] rounded-3xl shadow-md shadow-gray-300/30 dark:shadow-[#1D1842]/50 p-8 md:p-10 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/30">
        <div class="flex justify-center mb-6">
            <a href="/" class="cursor-pointer hover:opacity-80 transition-opacity">
                <img src="/images/logo-u.png" alt="U Marketplace" class="h-20 w-auto object-contain">
            </a>
        </div>

        <h1 class="text-2xl font-bold text-center text-[#8E0D3C] dark:text-[#FDA1A2] mb-4">
            Verifikasi Email Anda
        </h1>

        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-sm text-gray-700 dark:text-gray-300 mb-6 leading-relaxed text-center">
            Kami telah mengirim link verifikasi ke alamat email <span class="font-semibold">{{ auth()->user()->email }}</span>.
            Silakan cek email Anda dan klik link verifikasi sebelum melanjutkan.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
            @csrf
            <button
                type="submit"
                class="w-full bg-[#8E0D3C] dark:bg-[#8E0D3C] text-white font-semibold py-3.5 px-4 rounded-xl shadow-md shadow-[#8E0D3C]/20 dark:shadow-[#8E0D3C]/20 flex items-center justify-center"
            >
                Kirim Ulang Email Verifikasi
            </button>
        </form>



        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Jika Anda merasa tidak mendaftar di U Market, Anda dapat mengabaikan email tersebut.
            </p>
        </div>
    </div>

    <script>
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
