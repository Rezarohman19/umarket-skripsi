<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
        <div class="flex">
            <!-- Left Sidebar -->
            <aside class="w-64 bg-white dark:bg-gray-900 border-r border-gray-300 dark:border-gray-800 shadow-sm fixed left-0 top-0 bottom-0 flex flex-col z-10">
                <!-- Logo -->
                <div class="p-4 flex items-center gap-3 border-b border-gray-300 dark:border-gray-800">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">U</span>
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">U Market</span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 p-4 space-y-2">
                    <a
                        href="/admin/dashboard"
                        class="flex items-center px-4 py-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium border border-blue-200 dark:border-blue-800"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Beranda
                    </a>

                    <a
                        href="/admin/products"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Produk
                    </a>

                    <a
                        href="/admin/users"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Pengguna
                    </a>

                    <a
                        href="/admin/transactions"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Penjualan
                    </a>
                </nav>

                <!-- Logout Button -->
                <div class="p-4 border-t border-gray-300 dark:border-gray-800">
                    <button
                        @click="handleLogout"
                        class="w-full flex items-center px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors font-medium"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 ml-64">
                <!-- Top Header -->
                <header class="bg-white dark:bg-gray-900 border-b border-gray-300 dark:border-gray-800 shadow-sm px-6 py-4 sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <!-- Search Bar -->
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari"
                                    class="w-full px-4 py-2 pl-10 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                />
                                <svg class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Filter & Profile -->
                        <div class="flex items-center gap-4">
                            <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                </svg>
                            </button>
                            <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Dashboard Content -->
                <div class="p-6">
                    <div class="flex gap-6">
                        <!-- Main Content Area -->
                        <div class="flex-1 space-y-6">
                            <!-- Stats Cards -->
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Jumlah Pengguna -->
                                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Jumlah Pengguna</h3>
                                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ stats.totalUsers }}</p>
                                </div>

                                <!-- Riwayat Transaksi -->
                                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                                    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Riwayat Transaksi</h3>
                                    <p class="text-4xl font-bold text-gray-900 dark:text-white">Rp. {{ formatPrice(stats.totalTransactions) }}</p>
                                </div>
                            </div>

                            <!-- Diagram Penjualan -->
                            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Diagram Penjualan</h3>
                                    <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="h-64 flex items-center justify-center text-gray-400 dark:text-gray-600">
                                    <p class="text-sm">Chart akan ditampilkan di sini</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Sidebar - Produk Populer -->
                        <aside class="w-80 bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6 h-fit">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Produk Populer</h3>
                            </div>
                            <div class="space-y-4">
                                <div
                                    v-for="product in popularProducts"
                                    :key="product.id"
                                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors cursor-pointer"
                                >
                                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <img v-if="product.image_url" :src="product.image_url" :alt="product.name" class="w-full h-full object-cover rounded-lg" />
                                        <svg v-else class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ product.name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ product.description || 'Tidak ada deskripsi' }}</p>
                                    </div>
                                </div>
                            </div>
                            <button class="w-full mt-4 px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors text-sm font-medium">
                                Lihat Semua
                            </button>
                        </aside>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const searchQuery = ref('');
const stats = ref({
    totalUsers: 0,
    totalTransactions: 0
});
const popularProducts = ref([]);

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID').format(price || 0);
};

const fetchStats = async () => {
    try {
        // Fetch jumlah pengguna
        const usersResponse = await axios.get('/api/admin/users');
        stats.value.totalUsers = usersResponse.data?.length || 0;

        // Fetch total transaksi
        const transactionsResponse = await axios.get('/api/admin/transactions');
        const transactions = transactionsResponse.data || [];
        stats.value.totalTransactions = transactions.reduce((sum, t) => sum + (parseFloat(t.total_price || t.total) || 0), 0);
    } catch (error) {
        console.error('Error fetching stats:', error);
    }
};

const fetchPopularProducts = async () => {
    try {
        const response = await axios.get('/api/products');
        const products = response.data || [];
        // Ambil 4 produk teratas
        popularProducts.value = products.slice(0, 4);
    } catch (error) {
        console.error('Error fetching popular products:', error);
    }
};

const handleLogout = async () => {
    if (confirm('Apakah Anda yakin ingin keluar?')) {
        try {
            await axios.post('/logout');
            window.location.href = '/admin/login';
        } catch (error) {
            console.error('Error logging out:', error);
            window.location.href = '/admin/login';
        }
    }
};

onMounted(async () => {
    await fetchStats();
    await fetchPopularProducts();
});
</script>

