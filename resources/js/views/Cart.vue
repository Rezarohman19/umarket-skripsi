<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 pb-24">
        <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 space-y-4">
            <!-- Back -->
            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300 cursor-pointer hover:underline" @click="goBack">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali</span>
            </div>

            <!-- Title -->
            <h1 class="text-xl font-semibold text-center text-gray-900 dark:text-white">Keranjang Saya</h1>

            <!-- Loading -->
            <div v-if="loading" class="text-center py-8">
                <p class="text-gray-500 dark:text-gray-400">Memuat keranjang...</p>
            </div>

            <!-- Empty Cart -->
            <div v-else-if="cartItems.length === 0" class="text-center py-12">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Keranjang Anda kosong</p>
                <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">Tambahkan produk ke keranjang untuk melihatnya di sini</p>
            </div>

            <!-- Cart List -->
            <div v-else class="space-y-4">
                <!-- Pilih Semua -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-4 flex items-center gap-3">
                    <input
                        type="checkbox"
                        :checked="isAllSelected"
                        @change="toggleSelectAll"
                        class="w-5 h-5 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 cursor-pointer"
                    />
                    <label class="text-sm font-semibold text-gray-900 dark:text-white cursor-pointer" @click="toggleSelectAll">
                        Pilih Semua
                    </label>
                </div>

                <!-- Cart Items -->
                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-4 flex items-center gap-4"
                >
                    <!-- Checkbox -->
                    <input
                        type="checkbox"
                        :checked="selectedItems.includes(item.id)"
                        @change="toggleItem(item.id)"
                        class="w-5 h-5 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 cursor-pointer"
                    />

                    <!-- Image -->
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center rounded-md overflow-hidden">
                        <img
                            v-if="item.image_url"
                            :src="item.image_url"
                            :alt="item.product_name"
                            class="w-full h-full object-cover"
                        />
                        <svg v-else class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ item.store_name }}</p>
                        <p class="text-sm text-gray-800 dark:text-gray-100 font-semibold">{{ item.product_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ item.product_description || 'Tidak ada deskripsi' }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">Rp. {{ formatPrice(item.price) }}</p>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center gap-3">
                        <button
                            class="w-8 h-8 border border-gray-300 dark:border-gray-700 rounded-md text-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                            @click="decrease(item)"
                        >-</button>
                        <div class="w-10 text-center text-gray-900 dark:text-white font-semibold">{{ item.qty }}</div>
                        <button
                            class="w-8 h-8 border border-gray-300 dark:border-gray-700 rounded-md text-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                            @click="increase(item)"
                        >+</button>
                    </div>

                    <!-- Delete Button -->
                    <button
                        @click="removeItem(item)"
                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                        title="Hapus dari keranjang"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Checkout Footer (Sticky) -->
        <div
            v-if="!loading && cartItems.length > 0 && selectedItems.length > 0"
            class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-300 dark:border-gray-800 shadow-lg z-50"
        >
            <div class="max-w-5xl mx-auto px-4 sm:px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Total -->
                    <div class="flex-1">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Harga</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">Rp. {{ formatPrice(totalPrice) }}</p>
                    </div>

                    <!-- Checkout Button -->
                    <button
                        @click="handleCheckout"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg ml-4"
                    >
                        Checkout ({{ selectedItems.length }})
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const cartItems = ref([]);
const loading = ref(true);
const selectedItems = ref([]);

const goBack = () => window.history.back();

const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);

// Total harga dari item yang dicentang
const totalPrice = computed(() => {
    return cartItems.value
        .filter(item => selectedItems.value.includes(item.id))
        .reduce((total, item) => total + (item.price * item.qty), 0);
});

// Cek apakah semua item tercentang
const isAllSelected = computed(() => {
    return cartItems.value.length > 0 && selectedItems.value.length === cartItems.value.length;
});

// Toggle checkbox item
const toggleItem = (itemId) => {
    const index = selectedItems.value.indexOf(itemId);
    if (index > -1) {
        selectedItems.value.splice(index, 1);
    } else {
        selectedItems.value.push(itemId);
    }
};

// Toggle pilih semua
const toggleSelectAll = () => {
    if (isAllSelected.value) {
        // Jika semua sudah tercentang, hapus semua
        selectedItems.value = [];
    } else {
        // Jika belum semua tercentang, centang semua
        selectedItems.value = cartItems.value.map(item => item.id);
    }
};

const fetchCartItems = async () => {
    try {
        loading.value = true;
        
        // Ambil dummy cart dari localStorage (semua dummy products, baik ID negatif maupun positif)
        const dummyCart = JSON.parse(localStorage.getItem('dummy_cart') || '[]');
        
        // Ambil real cart dari API jika user sudah login
        let apiItems = [];
        try {
            const response = await axios.get('/api/cart');
            apiItems = response.data.items || [];
        } catch (error) {
            // Jika tidak login atau error, gunakan dummy cart saja
            console.log('API cart error, using dummy cart only');
        }
        
        // Gabungkan dummy cart dengan API cart
        const allItems = [];
        
        // Tambahkan dummy items (semua dummy products)
        dummyCart.forEach((item, index) => {
            allItems.push({
                id: `dummy_${item.product_id}_${index}`,
                product_id: item.product_id,
                product_name: item.product_name,
                product_description: item.product_description || item.category || '',
                price: item.price,
                qty: item.quantity,
                store_name: item.store_name || 'Toko',
                image_url: null,
                is_dummy: true,
            });
        });
        
        // Tambahkan API items (produk real dari database)
        apiItems.forEach((item) => {
            allItems.push({
                ...item,
                is_dummy: false,
            });
        });
        
        cartItems.value = allItems;
    } catch (error) {
        console.error('Error fetching cart items:', error);
        cartItems.value = [];
    } finally {
        loading.value = false;
    }
};

const increase = async (item) => {
    if (item.is_dummy) {
        // Update dummy cart di localStorage
        const dummyCart = JSON.parse(localStorage.getItem('dummy_cart') || '[]');
        const cartItem = dummyCart.find(i => i.product_id === item.product_id);
        if (cartItem) {
            cartItem.quantity += 1;
            localStorage.setItem('dummy_cart', JSON.stringify(dummyCart));
            item.qty += 1;
        }
    } else {
        // Update via API
        try {
            // TODO: Buat endpoint untuk update quantity
            // Untuk sekarang, update lokal dulu
            item.qty += 1;
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }
};

const decrease = async (item) => {
    if (item.qty <= 1) return;
    
    if (item.is_dummy) {
        // Update dummy cart di localStorage
        const dummyCart = JSON.parse(localStorage.getItem('dummy_cart') || '[]');
        const cartItem = dummyCart.find(i => i.product_id === item.product_id);
        if (cartItem && cartItem.quantity > 1) {
            cartItem.quantity -= 1;
            localStorage.setItem('dummy_cart', JSON.stringify(dummyCart));
            item.qty -= 1;
        }
    } else {
        // Update via API
        try {
            // TODO: Buat endpoint untuk update quantity
            // Untuk sekarang, update lokal dulu
            item.qty -= 1;
        } catch (error) {
            console.error('Error updating quantity:', error);
        }
    }
};

const removeItem = async (item) => {
    if (!confirm(`Hapus "${item.product_name}" dari keranjang?`)) {
        return;
    }

    try {
        if (item.is_dummy) {
            // Hapus dari localStorage untuk dummy products
            // Gunakan index untuk menghapus item yang tepat (karena bisa ada beberapa item dengan product_id sama)
            const dummyCart = JSON.parse(localStorage.getItem('dummy_cart') || '[]');
            // Extract index dari item.id (format: dummy_productId_index)
            const match = item.id.match(/dummy_(-?\d+)_(\d+)/);
            if (match) {
                const productId = parseInt(match[1]);
                const itemIndex = parseInt(match[2]);
                // Hapus item berdasarkan index di array
                dummyCart.splice(itemIndex, 1);
                localStorage.setItem('dummy_cart', JSON.stringify(dummyCart));
            } else {
                // Fallback: hapus berdasarkan product_id
                const filteredCart = dummyCart.filter(cartItem => 
                    cartItem.product_id !== item.product_id
                );
                localStorage.setItem('dummy_cart', JSON.stringify(filteredCart));
            }
        } else {
            // Hapus dari database untuk real products
            await axios.delete(`/api/cart/remove/${item.id}`);
        }

        // Hapus dari selectedItems jika sedang terpilih
        const index = selectedItems.value.indexOf(item.id);
        if (index > -1) {
            selectedItems.value.splice(index, 1);
        }

        // Refresh cart items
        await fetchCartItems();
        
        // Trigger custom event untuk update cart count di halaman lain
        window.dispatchEvent(new CustomEvent('cartUpdated'));
    } catch (error) {
        console.error('Error removing item:', error);
        alert('Gagal menghapus produk dari keranjang: ' + (error.response?.data?.message || error.message));
    }
};

const handleCheckout = () => {
    if (selectedItems.value.length === 0) {
        alert('Pilih minimal satu produk untuk checkout');
        return;
    }
    
    // TODO: Implementasi checkout
    const selectedProducts = cartItems.value.filter(item => selectedItems.value.includes(item.id));
    console.log('Checkout items:', selectedProducts);
    alert(`Checkout ${selectedItems.value.length} produk dengan total Rp. ${formatPrice(totalPrice.value)}`);
};

onMounted(async () => {
    await fetchCartItems();
});
</script>

<style scoped>
</style>

