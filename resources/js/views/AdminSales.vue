<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="flex">
            <!-- Left Sidebar -->
            <aside
                class="w-64 bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm fixed left-0 top-0 bottom-0 flex flex-col z-10"
            >
                <!-- Logo -->
                <div
                    class="p-4 flex items-center justify-center border-b border-[#EF3B33]/30"
                >
                    <img
                        src="/images/logo-u-marketplace.png"
                        alt="U Marketplace"
                        class="h-20 w-auto object-contain"
                    />
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-2">
                    <a
                        href="/admin/dashboard"
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
                        Beranda
                    </a>

                    <a
                        href="/admin/products"
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
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                            />
                        </svg>
                        Produk
                    </a>

                    <a
                        href="/admin/users"
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
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                        Pengguna
                    </a>

                    <a
                        href="/admin/transactions"
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
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                            />
                        </svg>
                        Penjualan
                    </a>
                </nav>

                <!-- Logout Button -->
                <div class="mt-auto p-4 border-t border-[#EF3B33]/30">
                    <button
                        @click="handleLogout"
                        class="w-full bg-[#EF3B33]/30 text-white font-medium py-3 px-4 rounded-lg"
                    >
                        <span class="flex items-center justify-center">
                            <svg
                                class="w-5 h-5 mr-2"
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
                            Keluar
                        </span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 ml-64">
                <!-- Top Header (same style as dashboard) -->
                <header
                    class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm px-6 py-4 sticky top-0 z-10"
                >
                    <div class="flex items-center justify-between">
                        <!-- Logo -->
                        <img
                            src="/images/logo.png"
                            alt="U Marketplace"
                            class="w-10 h-10 object-contain"
                        />

                        <!-- Greeting -->
                        <div class="flex-1 mx-6">
                            <p class="text-[#1D1842] dark:text-[#FDA1A2]">
                                Halo, <span class="font-semibold">Admin</span>
                            </p>
                        </div>

                        <!-- Search Bar -->
                        <div class="flex-1 max-w-md mx-4">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari riwayat penjualan"
                                    class="w-full px-4 py-2 pl-10 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg text-[#1D1842] dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none"
                                />
                                <svg
                                    class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <!-- Profile Icon -->
                        <button
                            @click="handleProfile"
                            class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center border-2 border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40"
                            :class="
                                admin?.photo_url
                                    ? ''
                                    : 'bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20'
                            "
                        >
                            <img
                                v-if="admin?.photo_url"
                                :src="getPhotoUrl(admin.photo_url)"
                                alt="Admin"
                                class="w-full h-full object-cover"
                            />
                            <svg
                                v-else
                                class="w-6 h-6 text-gray-600 dark:text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                        </button>
                    </div>
                </header>

                <!-- Sales Table -->
                <div class="p-6">
                    <h2
                        class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                    >
                        Riwayat Penjualan
                    </h2>

                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm overflow-hidden"
                    >
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead
                                    class="bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#8E0D3C] dark:text-[#FDA1A2]"
                                >
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left font-semibold"
                                        >
                                            Nama Pembeli
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center font-semibold"
                                        >
                                            Produk Terjual
                                        </th>
                                        <th
                                            class="px-4 py-3 text-right font-semibold"
                                        >
                                            Pemasukan
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center font-semibold"
                                        >
                                            Status
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center font-semibold"
                                        >
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="sale in filteredSales"
                                        :key="sale.id"
                                        class="border-t border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                    >
                                        <td class="px-4 py-3 align-middle">
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-medium"
                                            >
                                                {{
                                                    sale.user?.name ||
                                                    "Pengguna"
                                                }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-center"
                                        >
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-medium"
                                            >
                                                {{ sale.products_sold }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-right"
                                        >
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-semibold"
                                            >
                                                Rp.
                                                {{ formatPrice(sale.total) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-center"
                                        >
                                            <span
                                                :class="[
                                                    'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium',
                                                    sale.status === 'paid' ||
                                                    sale.status === 'completed'
                                                        ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
                                                        : sale.status ===
                                                          'pending'
                                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'
                                                        : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                                ]"
                                            >
                                                {{ sale.status }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-center"
                                        >
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#8E0D3C] dark:text-[#FDA1A2]"
                                                @click="viewDetail(sale)"
                                            >
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr
                                        v-if="
                                            !loading &&
                                            filteredSales.length === 0
                                        "
                                    >
                                        <td
                                            colspan="5"
                                            class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            Tidak ada riwayat penjualan.
                                        </td>
                                    </tr>
                                    <tr v-if="loading">
                                        <td
                                            colspan="5"
                                            class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            Memuat riwayat penjualan...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import axios from "axios";
import Logo from "../components/Logo.vue";

const searchQuery = ref("");
const admin = ref(null);
const sales = ref([]);
const loading = ref(true);

const formatPrice = (price) =>
    new Intl.NumberFormat("id-ID").format(price || 0);

const getPhotoUrl = (photoUrl) => {
    if (!photoUrl) return null;
    if (photoUrl.includes("?")) {
        return photoUrl.split("?")[0] + "?t=" + Date.now();
    }
    return photoUrl + "?t=" + Date.now();
};

const checkAuth = async () => {
    try {
        const response = await axios.get("/api/user", {
            params: { _t: Date.now() },
        });
        admin.value = response.data;
    } catch (error) {
        admin.value = null;
        window.location.href = "/admin/login";
    }
};

const filteredSales = computed(() => {
    if (!searchQuery.value) return sales.value;
    const q = searchQuery.value.toLowerCase();
    return sales.value.filter((s) => {
        return (
            (s.user?.name || "").toLowerCase().includes(q) ||
            String(s.id).includes(q)
        );
    });
});

const fetchSales = async () => {
    try {
        loading.value = true;
        const response = await axios.get("/api/admin/transactions");
        sales.value = response.data || [];
    } catch (error) {
        console.error("Error fetching sales:", error);
        sales.value = [];
    } finally {
        loading.value = false;
    }
};

const viewDetail = (sale) => {
    alert(
        `Transaksi #${sale.id}\nPembeli: ${
            sale.user?.name || "Pengguna"
        }\nTotal: Rp. ${formatPrice(sale.total)}`
    );
};

const handleProfile = () => {
    window.location.href = "/admin/profile";
};

const handleLogout = async () => {
    if (confirm("Apakah Anda yakin ingin keluar?")) {
        try {
            await axios.post("/logout");
            window.location.href = "/admin/login";
        } catch (error) {
            console.error("Error logging out:", error);
            window.location.href = "/admin/login";
        }
    }
};

const handleUserUpdated = async () => {
    await checkAuth();
};

onMounted(async () => {
    await checkAuth();
    await fetchSales();
    window.addEventListener("userUpdated", handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener("userUpdated", handleUserUpdated);
});
</script>
