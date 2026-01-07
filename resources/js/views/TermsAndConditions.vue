<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 flex">
        <!-- SIDEBAR -->
        <aside
            :class="[
                'bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                sidebarCollapsed ? 'w-16' : 'w-64',
            ]"
        >
            <div class="p-4 flex items-center justify-between">
                <button @click="toggleSidebar" class="p-2 rounded-lg">
                    <svg
                        class="w-5 h-5 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </button>
            </div>

            <nav class="px-4 space-y-2">
                <a
                    href="/"
                    class="flex items-center px-4 py-3 rounded-lg text-white/80"
                >
                    <svg
                        class="w-5 h-5 text-white mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Beranda</span>
                </a>

                <a
                    href="/orders"
                    class="flex items-center px-4 py-3 rounded-lg text-white/80"
                >
                    <svg
                        class="w-5 h-5 text-white mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Pesanan Saya</span>
                </a>

                <a
                    href="/open-shop"
                    class="flex items-center px-4 py-3 rounded-lg text-white/80"
                >
                    <svg
                        class="w-5 h-5 text-white mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Buka Toko</span>
                </a>
            </nav>

            <nav class="px-4 space-y-2 border-t border-[#EF3B33]/30 pt-4 mt-4">
                <a
                    href="#"
                    class="flex items-center px-4 py-3 rounded-lg bg-[#FDA1A2]/30 text-white font-medium"
                >
                    <svg
                        class="w-5 h-5 text-white mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Syarat & Ketentuan</span>
                </a>

                <a
                    href="/contact-us"
                    class="flex items-center px-4 py-3 rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition"
                >
                    <svg
                        class="w-5 h-5 text-white mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Hubungi Kami</span>
                </a>
            </nav>

            <div class="mt-auto p-4">
                <button
                    @click="handleLogout"
                    class="w-full bg-[#EF3B33]/30 text-white font-medium py-3 px-4 rounded-lg"
                >
                    <span v-if="!sidebarCollapsed">Keluar</span>
                    <span v-else class="flex justify-center">
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>
                    </span>
                </button>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main
            class="flex-1 transition-all duration-300 px-6 py-10"
            :class="sidebarCollapsed ? 'ml-20' : 'ml-64'"
        >
            <div class="max-w-3xl mx-auto bg-white rounded-xl p-8 shadow-lg">
                <div class="text-center mb-8">
                    <h1
                        class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-[#8E0D3C] to-[#EF3B33]"
                    >
                        Syarat dan Ketentuan
                    </h1>
                    <p class="text-gray-600 mt-2">
                        Mohon baca dengan seksama sebelum menggunakan UMarket
                    </p>
                </div>
                <div class="space-y-6 text-sm text-gray-700">
                    <section>
                        <h2 class="text-lg font-semibold text-[#1D1842]">
                            1. Pendahuluan
                        </h2>
                        <p>
                            Dengan mengakses dan menggunakan UMarket, Anda
                            setuju untuk terikat oleh seluruh syarat dan
                            ketentuan yang berlaku.
                        </p>
                    </section>
                    <section>
                        <h2 class="text-lg font-semibold text-[#1D1842]">
                            2. Akun & Penggunaan
                        </h2>
                        <ul class="list-disc pl-5">
                            <li>Pengguna wajib memberikan data yang benar.</li>
                            <li>
                                Keamanan akun sepenuhnya tanggung jawab
                                pengguna.
                            </li>
                            <li>
                                Dilarang menggunakan platform untuk aktivitas
                                ilegal.
                            </li>
                        </ul>
                    </section>
                    <section>
                        <h2 class="text-lg font-semibold text-[#1D1842]">
                            3. Produk & Transaksi
                        </h2>
                        <ul class="list-disc pl-5">
                            <li>
                                Penjual bertanggung jawab atas keaslian produk.
                            </li>
                            <li>Pembeli wajib menyelesaikan pembayaran.</li>
                            <li>Harga dan ketersediaan dapat berubah.</li>
                        </ul>
                    </section>
                    <section>
                        <h2 class="text-lg font-semibold text-[#1D1842]">
                            4. Pembayaran
                        </h2>
                        <ul class="list-disc pl-5">
                            <li>
                                Pembayaran diproses melalui mitra resmi
                                (Midtrans).
                            </li>
                            <li>
                                UMarket tidak menyimpan data kartu pengguna.
                            </li>
                        </ul>
                    </section>
                    <section>
                        <h2 class="text-lg font-semibold text-[#1D1842]">
                            5. Privasi
                        </h2>
                        <p>
                            Data pribadi pengguna dilindungi dan digunakan
                            sesuai kebijakan privasi.
                        </p>
                    </section>
                    <section>
                        <h2 class="text-lg font-semibold text-[#1D1842]">
                            6. Hukum
                        </h2>
                        <p>
                            Syarat dan ketentuan ini tunduk pada hukum Republik
                            Indonesia.
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
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

/* sidebar */
const sidebarCollapsed = ref(false);
const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

/* logout */
const logout = async () => {
    await axios.post("/logout");
    window.location.href = "/login";
};
</script>

<!-- Reusable Sidebar Link -->
<script>
export default {
    components: {
        SidebarLink: {
            props: ["to", "label", "collapsed", "active"],
            template: `
        <a
          :href="to"
          class="flex items-center px-4 py-3 rounded-lg text-white/80"
          :class="active ? 'bg-[#FDA1A2]/30 font-medium' : ''"
        >
          <span v-if="!collapsed">{{ label }}</span>
        </a>
      `,
        },
    },
};
</script>
