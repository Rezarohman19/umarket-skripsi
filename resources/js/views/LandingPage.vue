<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
        <div class="flex">
            <!-- Left Sidebar -->
            <aside 
                :class="[
                    'bg-white dark:bg-gray-900 border-r border-gray-300 dark:border-gray-800 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                    sidebarCollapsed ? 'w-16' : 'w-64'
                ]"
            >
                <div class="p-4 flex items-center justify-between">
                    <button
                        @click="toggleSidebar"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                </div>

                <nav class="px-4 space-y-2">
                    <a
                        href="#"
                        class="flex items-center px-4 py-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium border border-blue-200 dark:border-blue-800"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span v-if="!sidebarCollapsed">Beranda</span>
                    </a>

                    <a
                        href="#"
                        @click.prevent="handleMyOrders"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span v-if="!sidebarCollapsed">Pesanan Saya</span>
                    </a>

                    <a
                        href="#"
                        @click.prevent="handleOpenShop"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
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
                        class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-medium py-3 px-4 rounded-lg transition-colors"
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
                        <!-- Logo -->
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">U</span>
                        </div>

                        <!-- Greeting -->
                        <div class="flex-1 mx-6">
                            <p class="text-gray-700 dark:text-gray-300">
                                Halo, <span class="font-semibold">{{ user?.name || 'Pengunjung' }}</span>
                            </p>
                        </div>

                        <!-- Search Bar -->
                        <div class="flex-1 max-w-md mx-4">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari"
                                    class="w-full px-4 py-2 pl-10 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                />
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Cart Icon -->
                        <button
                            @click="handleCart"
                            class="relative p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span v-if="cartCount > 0" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ cartCount }}
                            </span>
                        </button>

                        <!-- Profile Icon -->
                        <button
                            @click="handleProfile"
                            class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </button>
                    </div>
                </header>

                <!-- Products Grid -->
                <div class="p-6">
                    <div v-if="loading" class="text-center py-12">
                        <p class="text-gray-600 dark:text-gray-400">Memuat produk...</p>
                    </div>

                    <div v-else-if="filteredProducts.length === 0" class="text-center py-12">
                        <p class="text-gray-600 dark:text-gray-400">Tidak ada produk ditemukan.</p>
                    </div>

                    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="product in filteredProducts"
                            :key="product.id"
                            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                        >
                            <!-- Product Image -->
                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center overflow-hidden">
                                <svg v-if="!product.image" class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <img v-else :src="product.image" :alt="product.name" class="w-full h-full object-cover" />
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <p class="text-xs font-medium text-blue-600 dark:text-blue-400 mb-1 uppercase tracking-wide">{{ getProductCategory(product.name) }}</p>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ product.name }}</h3>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-4">
                                    Rp. {{ formatPrice(product.price) }}
                                </p>

                                <!-- Quantity Selector & Add to Cart -->
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center border-2 border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800">
                                        <button
                                            @click="decreaseQuantity(product.id)"
                                            class="px-3 py-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <span class="px-4 py-1 text-gray-900 dark:text-white font-medium">
                                            {{ getQuantity(product.id) }}
                                        </span>
                                        <button
                                            @click="increaseQuantity(product.id)"
                                            class="px-3 py-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>

                                    <button
                                        @click="handleAddToCart(product)"
                                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-[0.98]"
                                    >
                                        Tambah Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Notification Toast -->
        <transition name="fade">
            <div
                v-if="notification.show"
                :class="[
                    'fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm',
                    notification.type === 'success' 
                        ? 'bg-green-500 text-white' 
                        : 'bg-red-500 text-white'
                ]"
            >
                <div class="flex items-center gap-3">
                    <svg v-if="notification.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <p class="font-medium">{{ notification.message }}</p>
                </div>
            </div>
        </transition>

        <!-- Login Required Modal -->
        <transition name="modal">
            <div
                v-if="showLoginModal"
                class="fixed inset-0 bg-white bg-opacity-10 dark:bg-gray-900 dark:bg-opacity-10 flex items-center justify-center z-50 p-4 backdrop-blur-md"
                @click.self="closeLoginModal"
            >
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full transform transition-all modal-content">
                    <!-- Card Header dengan gradient -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-t-2xl p-6">
                        <div class="flex items-center justify-center mb-2">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white text-center">Login Diperlukan</h3>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <p class="text-gray-700 dark:text-gray-300 text-center mb-6 leading-relaxed">
                            Anda harus melakukan <span class="font-semibold text-blue-600 dark:text-blue-400">login</span> sebelum melakukan aksi lebih lanjut.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button
                                @click="closeLoginModal"
                                class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]"
                            >
                                Batal
                            </button>
                            <button
                                @click="goToLogin"
                                class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl"
                            >
                                Login
                            </button>
                        </div>
                    </div>

                    <!-- Decorative bottom border -->
                    <div class="h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-b-2xl"></div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const sidebarCollapsed = ref(false);
const products = ref([]);
const loading = ref(true);
const searchQuery = ref('');
const quantities = ref({});
const user = ref(null);
const cartCount = ref(0);
const notification = ref({ show: false, message: '', type: 'success' });
const showLoginModal = ref(false);

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const filteredProducts = computed(() => {
    if (!searchQuery.value) {
        return products.value;
    }
    const query = searchQuery.value.toLowerCase();
    return products.value.filter(product => 
        product.name.toLowerCase().includes(query) ||
        (product.description && product.description.toLowerCase().includes(query))
    );
});

const getQuantity = (productId) => {
    return quantities.value[productId] || 1;
};

const increaseQuantity = (productId) => {
    if (!quantities.value[productId]) {
        quantities.value[productId] = 1;
    }
    quantities.value[productId]++;
};

const decreaseQuantity = (productId) => {
    if (!quantities.value[productId] || quantities.value[productId] <= 1) {
        quantities.value[productId] = 1;
        return;
    }
    quantities.value[productId]--;
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID').format(price);
};

const getProductCategory = (name) => {
    // Simple category extraction from product name
    const categories = ['Mochi', 'Risol', 'Pie', 'Kue', 'Snack'];
    for (const category of categories) {
        if (name.toLowerCase().includes(category.toLowerCase())) {
            return category;
        }
    }
    return 'Produk';
};

const checkAuth = async () => {
    try {
        const response = await axios.get('/api/user');
        user.value = response.data;
    } catch (error) {
        user.value = null;
    }
};

const fetchProducts = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/api/products');
        products.value = response.data;
        
        // Jika tidak ada produk dari API, gunakan dummy data untuk testing
        if (products.value.length === 0) {
            products.value = getDummyProducts();
        }
    } catch (error) {
        console.error('Error fetching products:', error);
        // Gunakan dummy data jika API error
        products.value = getDummyProducts();
    } finally {
        loading.value = false;
    }
};

const getDummyProducts = () => {
    return [
        {
            id: 1,
            name: 'Mochi Coklat',
            description: 'Mochi lembut dengan isian coklat yang lumer',
            price: 2500,
            stock: 50,
            image: null,
        },
        {
            id: 2,
            name: 'Risol Ayam Suwir',
            description: 'Risol goreng dengan isian ayam suwir yang gurih',
            price: 1500,
            stock: 30,
            image: null,
        },
        {
            id: 3,
            name: 'Pie Coklat',
            description: 'Pie dengan isian coklat yang manis dan lezat',
            price: 3500,
            stock: 25,
            image: null,
        },
        {
            id: 4,
            name: 'Mochi Stroberi',
            description: 'Mochi dengan isian stroberi yang segar',
            price: 2500,
            stock: 40,
            image: null,
        },
        {
            id: 5,
            name: 'Risol Sayur',
            description: 'Risol goreng dengan isian sayuran yang sehat',
            price: 1500,
            stock: 35,
            image: null,
        },
        {
            id: 6,
            name: 'Pie Keju',
            description: 'Pie dengan isian keju yang gurih dan lezat',
            price: 3500,
            stock: 20,
            image: null,
        },
        {
            id: 7,
            name: 'Mochi Matcha',
            description: 'Mochi dengan rasa matcha yang khas',
            price: 3000,
            stock: 30,
            image: null,
        },
        {
            id: 8,
            name: 'Risol Daging',
            description: 'Risol goreng dengan isian daging yang lezat',
            price: 2000,
            stock: 25,
            image: null,
        },
        {
            id: 9,
            name: 'Pie Apel',
            description: 'Pie dengan isian apel yang manis dan segar',
            price: 4000,
            stock: 15,
            image: null,
        },
    ];
};

const handleAddToCart = async (product) => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    const quantity = getQuantity(product.id);
    
    try {
        // Cek apakah ini dummy product (id < 100 untuk dummy)
        if (product.id < 100) {
            // Untuk dummy product, simpan di localStorage sebagai fallback
            const cartData = JSON.parse(localStorage.getItem('dummy_cart') || '[]');
            const existingItem = cartData.find(item => item.product_id === product.id);
            
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cartData.push({
                    product_id: product.id,
                    product_name: product.name,
                    quantity: quantity,
                    price: product.price
                });
            }
            
            localStorage.setItem('dummy_cart', JSON.stringify(cartData));
            
            // Update cart count dari localStorage
            const totalQty = cartData.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.value = totalQty;
            
            // Reset quantity
            quantities.value[product.id] = 1;
            
            showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
            return;
        }
        
        // Untuk produk dari API (real product)
        await axios.post('/api/cart/add', {
            product_id: product.id,
            quantity: quantity
        });
        
        // Reset quantity
        quantities.value[product.id] = 1;
        
        // Update cart count
        await fetchCartCount();
        
        // Show success notification
        showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
    } catch (error) {
        console.error('Error adding to cart:', error);
        const message = error.response?.data?.message || 'Gagal menambahkan produk ke keranjang';
        showNotification(message, 'error');
    }
};

const fetchCartCount = async () => {
    if (!user.value) {
        cartCount.value = 0;
        return;
    }

    try {
        // Cek dummy cart dari localStorage dulu
        const dummyCart = JSON.parse(localStorage.getItem('dummy_cart') || '[]');
        const dummyCount = dummyCart.reduce((sum, item) => sum + item.quantity, 0);
        
        // Cek real cart dari API
        const response = await axios.get('/api/cart/count');
        const apiCount = response.data.count || 0;
        
        // Total dari kedua sumber
        cartCount.value = dummyCount + apiCount;
    } catch (error) {
        // Jika API error, gunakan dummy cart saja
        const dummyCart = JSON.parse(localStorage.getItem('dummy_cart') || '[]');
        cartCount.value = dummyCart.reduce((sum, item) => sum + item.quantity, 0);
    }
};

const handleMyOrders = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = '/orders';
};

const handleOpenShop = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = '/open-shop';
};

const handleCart = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = '/cart';
};

const handleProfile = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = '/profile';
};

const handleLogout = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin keluar?')) {
        window.location.href = '/logout';
    }
};

const closeLoginModal = () => {
    showLoginModal.value = false;
};

const goToLogin = () => {
    window.location.href = '/login';
};

const showNotification = (message, type = 'success') => {
    notification.value = {
        show: true,
        message: message,
        type: type
    };
    
    setTimeout(() => {
        notification.value.show = false;
    }, 3000);
};

onMounted(async () => {
    await checkAuth();
    await fetchProducts();
    await fetchCartCount();
});
</script>

<style scoped>
/* Sidebar sudah menggunakan fixed positioning */

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

/* Modal Animation */
.modal-enter-active {
    transition: opacity 0.3s ease;
}

.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-active .modal-content {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
}

.modal-leave-active .modal-content {
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.modal-enter-from {
    opacity: 0;
}

.modal-leave-to {
    opacity: 0;
}

.modal-enter-from .modal-content {
    transform: scale(0.8) translateY(-30px);
    opacity: 0;
}

.modal-leave-to .modal-content {
    transform: scale(0.95) translateY(10px);
    opacity: 0;
}
</style>

