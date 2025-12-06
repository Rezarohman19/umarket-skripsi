<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header dengan Logout -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Dashboard
            </h1>
            <div class="flex gap-4 items-center">
                <span class="text-sm text-gray-600 dark:text-gray-400">
                    Selamat datang, <strong>{{ Auth::user()->name }}</strong>!
                </span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Info User -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Informasi Akun</h2>
            <div class="space-y-2">
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Nama:</strong> {{ Auth::user()->name }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Email:</strong> {{ Auth::user()->email }}
                </p>
                <p class="text-gray-700 dark:text-gray-300">
                    <strong>Role:</strong> 
                    <span class="px-2 py-1 rounded {{ Auth::user()->role === 'admin' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                        {{ Auth::user()->role === 'admin' ? 'Admin' : 'Pengguna' }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Pesan -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <p class="text-blue-800 dark:text-blue-200">
                ✅ <strong>Login berhasil!</strong> Halaman dashboard ini sementara. 
                Nanti bisa diganti dengan halaman dashboard Vue.js sesuai kebutuhan.
            </p>
        </div>
    </div>
</body>
</html>

