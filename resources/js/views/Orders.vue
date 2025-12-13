<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
        <div class="flex">
            <!-- Sidebar -->
            <aside
                :class="[
                    'bg-white dark:bg-gray-900 border-r border-gray-300 dark:border-gray-800 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                    sidebarCollapsed ? 'w-16' : 'w-64'
                ]"
            >
                <div class="p-4 flex items-center justify-between">
                    <button
                        @click="toggleSidebar"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    >
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>

                <nav class="px-4 space-y-2">
                    <a
                        href="/"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span v-if="!sidebarCollapsed">Beranda</span>
                    </a>

                    <a
                        href="#"
                        class="flex items-center px-4 py-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium border border-blue-200 dark:border-blue-800"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span v-if="!sidebarCollapsed">Pesanan Saya</span>
                    </a>

                    <a
                        href="#"
                        @click.prevent="handleOpenShop"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span v-if="!sidebarCollapsed">Buka Toko</span>
                    </a>
                </nav>

                <div class="mt-auto p-4">
                    <button
                        @click="handleLogout"
                        class="w-full bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-medium py-3 px-4 rounded-lg transition-colors"
                    >
                        <span v-if="!sidebarCollapsed">Keluar</span>
                        <span v-else class="flex justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <main :class="['flex-1 transition-all duration-300', sidebarCollapsed ? 'ml-16' : 'ml-64']">
                <!-- Header -->
                <header class="bg-white dark:bg-gray-900 border-b border-gray-300 dark:border-gray-800 shadow-sm px-6 py-4 sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">U</span>
                        </div>

                        <div class="flex-1 mx-6">
                            <p class="text-gray-700 dark:text-gray-300">
                                Halo, <span class="font-semibold">{{ user?.name || 'Pengunjung' }}</span>
                            </p>
                        </div>

                        <div class="flex-1 max-w-md mx-4">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari"
                                    class="w-full px-4 py-2 pl-10 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                />
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <button
                            @click="handleCart"
                            class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span v-if="cartCount > 0" :class="[
                                'absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-semibold',
                                cartCount > 9 ? 'w-6 h-6 -mt-1 -mr-1' : 'w-5 h-5'
                            ]">
                                {{ cartCount > 99 ? '99+' : cartCount }}
                            </span>
                        </button>

                        <button
                            @click="handleProfile"
                            class="w-10 h-10 bg-gray-200 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                    </div>
                </header>

                <!-- Loading -->
                <div v-if="loading" class="p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Memuat pesanan...</p>
                </div>

                <!-- Orders Sections -->
                <div v-else class="p-6 space-y-8">
                    <section v-for="section in sections" :key="section.key" class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ section.title }}</h2>

                        <div
                            v-for="order in filteredOrdersByStatus(section.key)"
                            :key="order.id"
                            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-4 md:p-5"
                        >
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-md flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                <div class="flex-1 space-y-1">
                                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ order.store }}</p>
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ order.product }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">{{ order.category }}</p>
                                        </div>
                                        <div class="flex flex-col md:items-end text-sm text-gray-700 dark:text-gray-300">
                                            <span>{{ order.qty }} pcs</span>
                                            <span class="font-semibold">Rp. {{ formatPrice(order.price) }}</span>
                                            <span class="font-semibold">Total Harga : Rp. {{ formatPrice(order.total) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 flex flex-wrap gap-3" v-if="order.actions && order.actions.length">
                                <button
                                    v-for="action in order.actions"
                                    :key="action.label"
                                    @click="handleAction(action.type, order)"
                                    :class="[
                                        'px-4 py-2 rounded-full text-sm font-medium transition-all duration-200',
                                        action.variant === 'primary'
                                            ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow hover:from-blue-700 hover:to-purple-700'
                                            : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'
                                    ]"
                                >
                                    {{ action.label }}
                                </button>
                            </div>
                        </div>

                        <div v-if="filteredOrdersByStatus(section.key).length === 0" class="text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada pesanan di status ini.
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const sidebarCollapsed = ref(false);
const user = ref(null);
const cartCount = ref(0);
const searchQuery = ref('');

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const sections = [
    { key: 'belum_bayar', title: 'Belum Bayar' },
    { key: 'dikemas', title: 'Dikemas' },
    { key: 'dikirim', title: 'Dikirim' },
    { key: 'riwayat', title: 'Riwayat' },
];

const orders = ref([]);
const loading = ref(true);

const filteredOrdersByStatus = (status) => {
    return orders.value
        .filter((order) => order.status === status)
        .filter((order) => {
            if (!searchQuery.value) return true;
            const q = searchQuery.value.toLowerCase();
            return (
                order.store.toLowerCase().includes(q) ||
                order.product.toLowerCase().includes(q) ||
                order.category.toLowerCase().includes(q)
            );
        });
};

const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);

const fetchTransactions = async () => {
    if (!user.value) {
        loading.value = false;
        return;
    }
    
    try {
        loading.value = true;
        const response = await axios.get('/api/transactions');
        const transactions = response.data || [];
        
        // Map transactions ke format yang diharapkan oleh UI
        orders.value = transactions.map(transaction => {
            // Tentukan status berdasarkan status transaction
            let status = 'riwayat';
            if (transaction.status === 'pending' || transaction.status === 'unpaid') {
                status = 'belum_bayar';
            } else if (transaction.status === 'processing' || transaction.status === 'packing') {
                status = 'dikemas';
            } else if (transaction.status === 'shipping' || transaction.status === 'sent') {
                status = 'dikirim';
            } else if (transaction.status === 'completed' || transaction.status === 'delivered') {
                status = 'riwayat';
            }
            
            // Tentukan actions berdasarkan status
            const actions = [];
            if (status === 'dikemas' || status === 'dikirim') {
                actions.push({ label: 'Hubungi Penjual', type: 'contact', variant: 'secondary' });
            }
            
            return {
                id: transaction.id,
                status: status,
                store: transaction.store_name || transaction.seller_name || 'Toko',
                product: transaction.product_name || 'Produk',
                category: transaction.product_description || transaction.category || 'Kategori',
                qty: transaction.quantity || transaction.qty || 1,
                price: transaction.price || 0,
                total: transaction.total_price || transaction.total || (transaction.price * (transaction.quantity || 1)),
                actions: actions,
                transaction: transaction, // Simpan data asli untuk referensi
            };
        });
    } catch (error) {
        console.error('Error fetching transactions:', error);
        orders.value = [];
    } finally {
        loading.value = false;
    }
};

const handleAction = (type, order) => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    if (type === 'contact') {
        alert(`Hubungi penjual untuk pesanan ${order.product}`);
    }
};

const handleOpenShop = () => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    window.location.href = '/open-shop';
};

const handleCart = () => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    window.location.href = '/cart';
};

const handleProfile = () => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    window.location.href = '/profile';
};

const handleLogout = async () => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin keluar?')) {
        try {
            await axios.post('/logout');
            window.location.href = '/login';
        } catch (error) {
            console.error('Error logging out:', error);
            // Tetap redirect meskipun ada error
            window.location.href = '/login';
        }
    }
};

const checkAuth = async () => {
    try {
        const response = await axios.get('/api/user');
        user.value = response.data;
    } catch (error) {
        user.value = null;
    }
};

const fetchCartCount = async () => {
    if (!user.value) {
        cartCount.value = 0;
        return;
    }
    try {
        const response = await axios.get('/api/cart');
        const apiItems = response.data.items || [];
        cartCount.value = apiItems.reduce((sum, item) => sum + (item.qty || item.quantity || 0), 0);
    } catch (error) {
        if (error.response?.status !== 401) {
            console.error('Error fetching cart count:', error);
        }
        cartCount.value = 0;
    }
};

onMounted(async () => {
    await checkAuth();
    await fetchCartCount();
    await fetchTransactions();
});
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
    opacity: 0;
}
</style>

