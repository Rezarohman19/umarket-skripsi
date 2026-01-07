<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - UMarket</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
<div class="flex">

    @auth
    <!-- SIDEBAR -->
    <aside class="bg-[#8E0D3C] fixed left-0 top-0 bottom-0 w-64 flex flex-col z-10 shadow-lg">
        <div class="p-4 flex items-center gap-3 border-b border-white/20">
            <div class="w-10 h-10 bg-[#1D1842] rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">U</span>
            </div>
            <span class="text-lg font-bold text-white">U Market</span>
        </div>

        <nav class="flex-1 p-4 space-y-2 text-white/90">
            <a href="/" class="block px-4 py-3 rounded-lg hover:bg-white/10">Beranda</a>
            <a href="/orders" class="block px-4 py-3 rounded-lg hover:bg-white/10">Pesanan Saya</a>
            <a href="/open-shop" class="block px-4 py-3 rounded-lg hover:bg-white/10">Buka Toko</a>
            <a href="/terms-and-conditions" class="block px-4 py-3 rounded-lg hover:bg-white/10">Syarat & Ketentuan</a>
            <a href="/contact-us" class="block px-4 py-3 rounded-lg bg-white/20 font-semibold">Hubungi Kami</a>
        </nav>

        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-[#EF3B33] text-white py-3 rounded-lg font-semibold">
                    Keluar
                </button>
            </form>
        </div>
    </aside>
    @endauth

    <!-- MAIN CONTENT -->
    <main
        class="
            flex-1 transition-all duration-300
            px-6 py-10
            {{ auth()->check() ? 'ml-64' : 'ml-0' }}
        "
    >
        <div class="max-w-6xl mx-auto">

            <div class="bg-white rounded-xl p-8 shadow-lg">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#8E0D3C] to-[#EF3B33]">
                        Hubungi Kami
                    </h1>
                    <p class="text-gray-600 mt-2">
                        Kami siap membantu Anda. Silakan hubungi kami kapan saja.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- INFO -->
                    <div class="border rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4 text-[#1D1842]">Informasi Kontak</h2>

                        <div class="space-y-4 text-sm">
                            <div>
                                <strong>Email</strong><br>
                                <a href="mailto:marketunila@gmail.com" class="text-[#8E0D3C]">
                                    marketunila@gmail.com
                                </a>
                            </div>

                            <div>
                                <strong>Telepon</strong><br>
                                <a href="tel:+6288286749573" class="text-[#8E0D3C]">
                                    +62 882 8674 9573
                                </a>
                            </div>

                            <div>
                                <strong>Alamat</strong><br>
                                Gg. By Pass Raya 1, Sepang Jaya, Kota Bandar Lampung
                            </div>

                            <div>
                                <strong>Jam Operasional</strong><br>
                                Senin–Jumat: 09.00–16.00 WIB<br>
                                Sabtu: 10.00–14.00 WIB<br>
                                Minggu: Tutup
                            </div>
                        </div>
                    </div>

                    <!-- FORM -->
                    <div class="border rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4 text-[#1D1842]">Kirim Pesan</h2>

                        @if(session('success'))
                            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                                <ul class="list-disc pl-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="/contact-us" class="space-y-4">
                            @csrf

                            <input type="text" name="name" placeholder="Nama"
                                   value="{{ old('name') }}"
                                   class="w-full border rounded px-3 py-2">

                            <input type="email" name="email" placeholder="Email"
                                   value="{{ old('email') }}"
                                   class="w-full border rounded px-3 py-2">

                            <input type="tel" name="phone" placeholder="Nomor Telepon"
                                   value="{{ old('phone') }}"
                                   class="w-full border rounded px-3 py-2">

                            <input type="text" name="subject" placeholder="Subjek"
                                   value="{{ old('subject') }}"
                                   class="w-full border rounded px-3 py-2">

                            <textarea name="message" placeholder="Pesan"
                                      class="w-full border rounded px-3 py-2 min-h-[140px]">{{ old('message') }}</textarea>

                            <button class="w-full bg-gradient-to-r from-[#8E0D3C] to-[#EF3B33] text-white py-2 rounded">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </main>

</div>
</body>
</html>
