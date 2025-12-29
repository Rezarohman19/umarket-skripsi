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
                            class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors mr-1"
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

                        <!-- Profile Icon -->
                        <button
                            @click="handleProfile"
                            class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center hover:ring-2 hover:ring-blue-500 transition-all ml-2"
                            :class="user?.photo_url ? 'ring-2 ring-blue-500' : 'bg-gray-200 dark:bg-gray-700'"
                        >
                            <img
                                v-if="user?.photo_url"
                                :src="getPhotoUrl(user.photo_url)"
                                :alt="user.name"
                                class="w-full h-full object-cover"
                            />
                            <svg v-else class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            v-for="order in getFilteredOrders(section.key)"
                            :key="order.id"
                            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-4 md:p-5"
                        >
                            <div class="flex items-start gap-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-md flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <img
                                        v-if="order.image_url"
                                        :src="order.image_url"
                                        :alt="order.product"
                                        class="w-full h-full object-cover"
                                    />
                                    <svg v-else class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                <div class="flex-1 space-y-1">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1">
                                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                {{ order.store }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                                Dari Toko
                                            </p>
                                        </div>
                                        <span :class="[
                                            'px-2 py-1 rounded-full text-xs font-medium',
                                            getStatusBadgeClass(order.status)
                                        ]">
                                            {{ getStatusLabel(order.status) }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mt-2">
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ order.product }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ order.category || '' }}</p>
                                        </div>
                                        <div class="flex flex-col md:items-end text-sm text-gray-700 dark:text-gray-300">
                                            <span>{{ order.qty }} pcs</span>
                                            <span class="font-semibold">Rp. {{ formatPrice(order.price) }}</span>
                                            <span class="font-semibold text-blue-600 dark:text-blue-400">Total: Rp. {{ formatPrice(order.total) }}</span>
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

                        <div v-if="getFilteredOrders(section.key).length === 0" class="text-sm text-gray-500 dark:text-gray-400 py-4 text-center">
                            Tidak ada pesanan di status ini.
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
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

const orders = ref([]); // Pembelian saja
const loading = ref(true);

const getFilteredOrders = (status) => {
    return orders.value
        .filter((order) => order.status === status)
        .filter((order) => {
            if (!searchQuery.value) return true;
            const q = searchQuery.value.toLowerCase();
            return (
                (order.store || '').toLowerCase().includes(q) ||
                (order.product || '').toLowerCase().includes(q) ||
                (order.category || '').toLowerCase().includes(q)
            );
        });
};

const getStatusLabel = (status) => {
    const statusMap = {
        'belum_bayar': 'Belum Bayar',
        'dikemas': 'Dikemas',
        'dikirim': 'Dikirim',
        'riwayat': 'Selesai',
        'pending': 'Menunggu Pembayaran',
        'paid': 'Sudah Dibayar',
        'processing': 'Diproses',
        'shipping': 'Dikirim',
        'completed': 'Selesai',
        'failed': 'Gagal'
    };
    return statusMap[status] || status;
};

const getStatusBadgeClass = (status) => {
    const classMap = {
        'belum_bayar': 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
        'dikemas': 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
        'dikirim': 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300',
        'riwayat': 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
        'pending': 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
        'paid': 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
        'processing': 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
        'shipping': 'bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300',
        'completed': 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
        'failed': 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300'
    };
    return classMap[status] || 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300';
};

const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);

const fetchTransactions = async () => {
    if (!user.value) {
        loading.value = false;
        return;
    }
    
    try {
        loading.value = true;
        
        // Fetch pembelian (transaksi sebagai pembeli)
        const purchaseResponse = await axios.get('/api/transactions');
        const purchaseTransactions = purchaseResponse.data || [];
        
        // Map transactions pembelian ke format yang diharapkan oleh UI
        orders.value = purchaseTransactions.flatMap(transaction => {
            // Jika transaction punya items, map setiap item
            if (transaction.items && transaction.items.length > 0) {
                // Filter out items yang product-nya sudah dihapus (null atau undefined)
                // Pastikan product ada dan punya id
                return transaction.items
                    .filter(item => {
                        return item.product !== null && 
                               item.product !== undefined && 
                               item.product.id !== null &&
                               item.product.id !== undefined;
                    })
                    .map(item => {
                        const status = mapTransactionStatus(transaction.status);
                        const actions = getPurchaseActions(status, transaction);
                        
                        return {
                            id: `${transaction.id}-${item.id}`,
                            transaction_id: transaction.id,
                            status: status,
                            store: item.product?.user?.name || transaction.store_name || 'Toko',
                            product: item.product?.name || 'Produk',
                            category: item.product?.description || '',
                            qty: item.qty || 1,
                            price: item.price || item.product?.price || 0,
                            total: (item.price || item.product?.price || 0) * (item.qty || 1),
                            image_url: item.product?.image_url || null,
                            actions: actions,
                            transaction: transaction,
                        };
                    });
            } else {
                // Fallback jika tidak ada items
                const status = mapTransactionStatus(transaction.status);
                const actions = getPurchaseActions(status, transaction);
                
                return [{
                    id: transaction.id,
                    transaction_id: transaction.id,
                    status: status,
                    store: transaction.store_name || 'Toko',
                    product: 'Produk',
                    category: '',
                    qty: 1,
                    price: transaction.total_price || 0,
                    total: transaction.total_price || 0,
                    image_url: null,
                    actions: actions,
                    transaction: transaction,
                }];
            }
        });
        
    } catch (error) {
        console.error('Error fetching transactions:', error);
        orders.value = [];
    } finally {
        loading.value = false;
    }
};

const mapTransactionStatus = (status) => {
    const statusMap = {
        'pending': 'belum_bayar',
        'unpaid': 'belum_bayar',
        'paid': 'dikemas',
        'processing': 'dikemas',
        'packing': 'dikemas',
        'shipping': 'dikirim',
        'sent': 'dikirim',
        'completed': 'riwayat',
        'delivered': 'riwayat',
        'failed': 'riwayat'
    };
    return statusMap[status] || 'riwayat';
};

const getPurchaseActions = (status, transaction) => {
    const actions = [];
    if (status === 'belum_bayar' && transaction?.snap_token) {
        actions.push({ label: 'Lanjutkan Pembayaran', type: 'continue_payment', variant: 'primary' });
    }
    if (status === 'dikemas' || status === 'dikirim') {
        actions.push({ label: 'Hubungi Penjual', type: 'contact', variant: 'secondary' });
    }
    return actions;
};


const handleAction = (type, order) => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    
    if (type === 'continue_payment') {
        handleContinuePayment(order);
    } else if (type === 'contact') {
        alert(`Hubungi penjual untuk pesanan ${order.product}`);
    }
};

const handleContinuePayment = (order) => {
    const snapToken = order.transaction?.snap_token;
    
    if (!snapToken) {
        alert('Token pembayaran tidak tersedia. Silakan hubungi customer service.');
        return;
    }
    
    // Cek apakah Midtrans Snap SDK sudah dimuat
    if (window.snap) {
        // Langsung buka halaman pembayaran Midtrans
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                // Refresh halaman untuk update status
                setTimeout(() => {
                    fetchTransactions();
                }, 2000);
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                // Refresh halaman untuk update status
                setTimeout(() => {
                    fetchTransactions();
                }, 2000);
            },
            onError: function(result) {
                console.error('Payment error:', result);
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                console.log('Payment modal closed');
            }
        });
    } else {
        // Load Midtrans Snap SDK terlebih dahulu
        const script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', 'Mid-client-t4gCXBa6b1_ar6Ji');
        script.onload = () => {
            // Setelah SDK dimuat, buka halaman pembayaran
            if (window.snap) {
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        setTimeout(() => {
                            fetchTransactions();
                        }, 2000);
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        setTimeout(() => {
                            fetchTransactions();
                        }, 2000);
                    },
                    onError: function(result) {
                        console.error('Payment error:', result);
                        alert('Pembayaran gagal. Silakan coba lagi.');
                    },
                    onClose: function() {
                        console.log('Payment modal closed');
                    }
                });
            }
        };
        document.head.appendChild(script);
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

const getPhotoUrl = (photoUrl) => {
    if (!photoUrl) return null;
    // Tambahkan cache busting jika belum ada
    if (photoUrl.includes('?')) {
        return photoUrl.split('?')[0] + '?t=' + Date.now();
    }
    return photoUrl + '?t=' + Date.now();
};

const checkAuth = async () => {
    try {
        // Tambahkan cache busting untuk memastikan data terbaru
        const response = await axios.get('/api/user', {
            params: { _t: Date.now() }
        });
        user.value = response.data;
    } catch (error) {
        user.value = null;
    }
};

// Handler untuk update user data (setelah edit profil)
const handleUserUpdated = async (event) => {
    // Refresh user data untuk update foto profil
    await checkAuth();
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
    
    // Load Midtrans Snap SDK untuk tombol "Lanjutkan Pembayaran"
    if (!window.snap) {
        const script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', 'Mid-client-t4gCXBa6b1_ar6Ji');
        document.head.appendChild(script);
    }
    
    // Listen untuk user update event (setelah edit profil)
    window.addEventListener('userUpdated', handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener('userUpdated', handleUserUpdated);
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

