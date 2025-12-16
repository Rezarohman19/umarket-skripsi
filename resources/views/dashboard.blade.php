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

        <!-- Info User dengan Photo -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="flex gap-6 items-start">
                <!-- Profile Photo -->
                <div class="flex-shrink-0">
                    @if(Auth::user()->photo)
                        <img 
                            src="{{ \Illuminate\Support\Facades\Storage::url(Auth::user()->photo) }}?t={{ time() }}" 
                            alt="Foto Profil" 
                            style="width: 96px; height: 96px; border-radius: 50%; object-fit: cover; border: 2px solid #d1d5db;"
                        />
                    @else
                        <div style="width: 96px; height: 96px; border-radius: 50%; background-color: #d1d5db; display: flex; align-items: center; justify-content: center; border: 2px solid #d1d5db;">
                            <svg style="width: 48px; height: 48px; color: #6b7280;" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- User Info -->
                <div class="flex-1">
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
                        @if(Auth::user()->phone)
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Telepon:</strong> {{ Auth::user()->phone }}
                            </p>
                        @endif
                        @if(Auth::user()->address)
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>Alamat:</strong> {{ Auth::user()->address }}
                            </p>
                        @endif
                        <div class="mt-4">
                            <a href="{{ route('profile') }}" class="inline-block px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
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

