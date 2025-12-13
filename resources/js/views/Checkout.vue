<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 pb-24">
        <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6">
            <!-- Back Button -->
            <button
                @click="goBack"
                class="mb-6 flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali ke Keranjang</span>
            </button>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Checkout</h1>

            <div v-if="loading" class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">Memuat data checkout...</p>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Alamat Pengiriman -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Alamat Pengiriman</h2>
                            <button
                                @click="showAddressModal = true"
                                class="text-sm text-blue-600 dark:text-blue-400 hover:underline"
                            >
                                Ubah
                            </button>
                        </div>
                        <div class="space-y-2">
                            <p class="text-gray-900 dark:text-white font-medium">{{ shippingAddress.name }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ shippingAddress.phone }}</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ shippingAddress.address || 'Alamat belum diisi' }}</p>
                        </div>
                    </div>

                    <!-- Daftar Produk -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Produk yang Dipesan</h2>
                        <div class="space-y-4">
                            <div
                                v-for="item in checkoutItems"
                                :key="item.id"
                                class="flex items-start gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0"
                            >
                                <!-- Product Image -->
                                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-md flex items-center justify-center overflow-hidden flex-shrink-0">
                                    <img
                                        v-if="item.image_url"
                                        :src="item.image_url"
                                        :alt="item.product_name"
                                        class="w-full h-full object-cover"
                                    />
                                    <svg v-else class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">{{ item.store_name }}</p>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1 line-clamp-2">{{ item.product_name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ item.product_description || 'Tidak ada deskripsi' }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Jumlah: {{ item.qty }} pcs</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Rp. {{ formatPrice(item.price * item.qty) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Metode Pembayaran</h2>
                        <div class="space-y-3">
                            <label
                                v-for="method in paymentMethods"
                                :key="method.id"
                                :class="[
                                    'flex items-center gap-4 p-4 border-2 rounded-lg cursor-pointer transition-all',
                                    selectedPayment === method.id
                                        ? 'border-blue-600 dark:border-blue-500 bg-blue-50 dark:bg-blue-900/20'
                                        : 'border-gray-300 dark:border-gray-700 hover:border-gray-400 dark:hover:border-gray-600'
                                ]"
                            >
                                <input
                                    type="radio"
                                    :value="method.id"
                                    v-model="selectedPayment"
                                    class="w-5 h-5 text-blue-600 focus:ring-blue-500"
                                />
                                <div class="flex items-center gap-3 flex-1">
                                    <div :class="[
                                        'w-12 h-12 rounded-lg flex items-center justify-center',
                                        method.bgColor
                                    ]">
                                        <svg v-if="method.id === 'bank_transfer'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        <svg v-else-if="method.id === 'e_wallet'" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <svg v-else class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ method.name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ method.description }}</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Ringkasan -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6 sticky top-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-white">Rp. {{ formatPrice(subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Ongkos Kirim</span>
                                <span class="text-gray-900 dark:text-white">Rp. {{ formatPrice(shippingCost) }}</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex justify-between">
                                <span class="font-semibold text-gray-900 dark:text-white">Total</span>
                                <span class="font-bold text-lg text-blue-600 dark:text-blue-400">Rp. {{ formatPrice(totalPrice) }}</span>
                            </div>
                        </div>

                        <button
                            @click="handleConfirmPayment"
                            :disabled="processing || !shippingAddress.address"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] disabled:cursor-not-allowed"
                        >
                            <span v-if="processing">Memproses...</span>
                            <span v-else>Konfirmasi Pembayaran</span>
                        </button>

                        <p v-if="!shippingAddress.address" class="text-xs text-red-500 dark:text-red-400 mt-2 text-center">
                            Lengkapi alamat pengiriman terlebih dahulu
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Modal -->
        <transition name="modal">
            <div
                v-if="showAddressModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showAddressModal = false"
            >
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Ubah Alamat Pengiriman</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Penerima</label>
                            <input
                                v-model="shippingAddress.name"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No. Telepon</label>
                            <input
                                v-model="shippingAddress.phone"
                                type="text"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                            <textarea
                                v-model="shippingAddress.address"
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button
                                @click="showAddressModal = false"
                                class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                            >
                                Batal
                            </button>
                            <button
                                @click="saveAddress"
                                class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition"
                            >
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const loading = ref(true);
const processing = ref(false);
const checkoutItems = ref([]);
const user = ref(null);
const shippingAddress = ref({
    name: '',
    phone: '',
    address: '',
});
const selectedPayment = ref('bank_transfer');
const showAddressModal = ref(false);

// Payment methods
const paymentMethods = [
    {
        id: 'bank_transfer',
        name: 'Transfer Bank',
        description: 'BCA, Mandiri, BRI, BNI',
        bgColor: 'bg-blue-600',
    },
    {
        id: 'e_wallet',
        name: 'E-Wallet',
        description: 'GoPay, OVO, DANA, LinkAja',
        bgColor: 'bg-green-600',
    },
    {
        id: 'cod',
        name: 'Bayar di Tempat',
        description: 'Cash on Delivery',
        bgColor: 'bg-orange-600',
    },
];

const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);

const goBack = () => {
    window.location.href = '/cart';
};

const subtotal = computed(() => {
    return checkoutItems.value.reduce((sum, item) => sum + (item.price * item.qty), 0);
});

const shippingCost = computed(() => {
    // Ongkir bisa dihitung berdasarkan alamat atau fixed
    return 15000; // Default ongkir
});

const totalPrice = computed(() => {
    return subtotal.value + shippingCost.value;
});

const fetchCheckoutItems = async () => {
    try {
        loading.value = true;
        
        // Ambil item dari URL params atau localStorage
        const urlParams = new URLSearchParams(window.location.search);
        const itemIds = urlParams.get('items')?.split(',') || [];
        
        if (itemIds.length === 0) {
            // Jika tidak ada di URL, ambil dari localStorage (fallback)
            const savedItems = localStorage.getItem('checkout_items');
            if (savedItems) {
                checkoutItems.value = JSON.parse(savedItems);
                loading.value = false;
                return;
            }
            // Jika tidak ada, redirect ke cart
            window.location.href = '/cart';
            return;
        }

        // Ambil cart items dari API
        const response = await axios.get('/api/cart');
        const allItems = response.data.items || [];
        
        // Filter hanya item yang dipilih
        const selectedItems = allItems.filter(item => itemIds.includes(item.id.toString()));
        
        // Map ke format checkout
        checkoutItems.value = selectedItems.map((item) => ({
            id: item.id,
            product_id: item.product_id,
            product_name: item.product?.name || 'Produk',
            product_description: item.product?.description || '',
            price: item.product?.price || item.price || 0,
            qty: item.qty || item.quantity || 0,
            store_name: item.store_name || item.product?.user?.name || 'Toko',
            image_url: item.product?.image_url || null,
        }));

        // Simpan ke localStorage sebagai backup
        localStorage.setItem('checkout_items', JSON.stringify(checkoutItems.value));
    } catch (error) {
        console.error('Error fetching checkout items:', error);
        alert('Gagal memuat data checkout');
        window.location.href = '/cart';
    } finally {
        loading.value = false;
    }
};

const fetchUserProfile = async () => {
    try {
        const response = await axios.get('/api/user');
        user.value = response.data;
        
        // Set shipping address dari profile
        shippingAddress.value = {
            name: response.data.name || '',
            phone: response.data.phone || '',
            address: response.data.address || '',
        };
    } catch (error) {
        console.error('Error fetching user profile:', error);
    }
};

const saveAddress = () => {
    showAddressModal.value = false;
    // Bisa juga simpan ke backend jika perlu
};

const handleConfirmPayment = async () => {
    if (!shippingAddress.value.address) {
        alert('Lengkapi alamat pengiriman terlebih dahulu');
        return;
    }

    if (checkoutItems.value.length === 0) {
        alert('Tidak ada produk yang dipilih');
        return;
    }

    try {
        processing.value = true;

        // Siapkan data checkout
        const checkoutData = {
            items: checkoutItems.value.map(item => ({
                cart_item_id: item.id,
                product_id: item.product_id,
                quantity: item.qty,
            })),
            shipping_address: shippingAddress.value,
            payment_method: selectedPayment.value,
        };

        // Panggil API checkout
        const response = await axios.post('/api/checkout', checkoutData);

        if (response.data) {
            // Hapus checkout items dari localStorage
            localStorage.removeItem('checkout_items');
            
            // Redirect ke halaman sukses atau orders
            alert('Pembayaran berhasil! Pesanan Anda sedang diproses.');
            window.location.href = '/orders';
        }
    } catch (error) {
        console.error('Error during checkout:', error);
        const message = error.response?.data?.message || 'Gagal melakukan checkout';
        alert(message);
    } finally {
        processing.value = false;
    }
};

onMounted(async () => {
    await fetchUserProfile();
    await fetchCheckoutItems();
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

