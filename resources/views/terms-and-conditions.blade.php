<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat dan Ketentuan - UMarket</title>
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
            <a href="/terms-and-conditions" class="block px-4 py-3 rounded-lg bg-white/20 font-semibold">
                Syarat & Ketentuan
            </a>
            <a href="/contact-us" class="block px-4 py-3 rounded-lg hover:bg-white/10">Hubungi Kami</a>
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
        <div class="max-w-3xl mx-auto bg-white rounded-xl p-8 shadow-lg">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#8E0D3C] to-[#EF3B33]">
                    Syarat dan Ketentuan
                </h1>
                <p class="text-gray-600 mt-2">
                    Mohon baca dengan seksama sebelum menggunakan UMarket
                </p>
            </div>

            <div class="space-y-6 text-sm text-gray-700">

                <section>
                    <h2 class="text-lg font-semibold text-[#1D1842]">1. Pendahuluan</h2>
                    <p>
                        Dengan mengakses dan menggunakan UMarket, Anda setuju untuk terikat
                        oleh seluruh syarat dan ketentuan yang berlaku.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-[#1D1842]">2. Akun & Penggunaan</h2>
                    <ul class="list-disc pl-5">
                        <li>Pengguna wajib memberikan data yang benar.</li>
                        <li>Keamanan akun sepenuhnya tanggung jawab pengguna.</li>
                        <li>Dilarang menggunakan platform untuk aktivitas ilegal.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-[#1D1842]">3. Produk & Transaksi</h2>
                    <ul class="list-disc pl-5">
                        <li>Penjual bertanggung jawab atas keaslian produk.</li>
                        <li>Pembeli wajib menyelesaikan pembayaran.</li>
                        <li>Harga dan ketersediaan dapat berubah.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-[#1D1842]">4. Pembayaran</h2>
                    <ul class="list-disc pl-5">
                        <li>Pembayaran diproses melalui mitra resmi (Midtrans).</li>
                        <li>UMarket tidak menyimpan data kartu pengguna.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-[#1D1842]">5. Privasi</h2>
                    <p>
                        Data pribadi pengguna dilindungi dan digunakan sesuai kebijakan privasi.
                    </p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-[#1D1842]">6. Hukum</h2>
                    <p>
                        Syarat dan ketentuan ini tunduk pada hukum Republik Indonesia.
                    </p>
                </section>

            </div>

            <div class="text-center mt-10 text-xs text-gray-500">
                <p>Terakhir diperbarui: 7 Januari 2026</p>
                <p>&copy; 2026 UMarket</p>
            </div>

        </div>
    </main>

</div>
</body>
</html>