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
                        href="/orders"
                        class="flex items-center px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                    >
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <span v-if="!sidebarCollapsed">Pesanan Saya</span>
                    </a>

                    <a
                        href="#"
                        class="flex items-center px-4 py-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-medium border border-blue-200 dark:border-blue-800"
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
                            <span v-if="cartCount > 0" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ cartCount }}
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

                <!-- Store Overview -->
                <div class="p-6 space-y-8">
                    <!-- Store Overview -->
                    <section class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-800 rounded-full flex items-center justify-center text-gray-600 dark:text-gray-300">
                                    Foto
                                </div>
                                <div>
                                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ store.name }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.incoming }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Pesanan Masuk</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.needShip }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Perlu Dikirim</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.shipped }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Dikirim</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.history }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Riwayat Penjualan</p>
                            </div>
                        </div>
                    </section>

                    <!-- Product Table -->
                    <section class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Produk</h2>
                            <button
                                class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-medium rounded-lg shadow hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
                                @click="toggleForm"
                            >
                                + Tambah Produk
                            </button>
                        </div>

                        <transition name="fade">
                            <div v-if="showForm" class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 space-y-3 border border-dashed border-gray-300 dark:border-gray-700">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Produk</label>
                                        <input v-model="form.name" type="text" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori</label>
                                        <input v-model="form.category" type="text" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga</label>
                                        <input v-model.number="form.price" type="number" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stok</label>
                                        <input v-model.number="form.stock" type="number" min="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Produk</label>
                                        <div class="flex items-center gap-3">
                                            <label class="w-28 h-28 border border-dashed border-gray-300 dark:border-gray-700 rounded-lg flex items-center justify-center bg-white dark:bg-gray-900 cursor-pointer hover:border-blue-500">
                                                <input type="file" accept="image/*" class="hidden" @change="onImageChange" />
                                                <template v-if="form.imagePreview">
                                                    <img :src="form.imagePreview" alt="preview" class="w-full h-full object-cover rounded-lg" />
                                                </template>
                                                <template v-else>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Upload</span>
                                                </template>
                                            </label>
                                            <button
                                                v-if="form.imagePreview"
                                                class="text-xs text-red-500 hover:text-red-600"
                                                @click="removeImage"
                                            >
                                                Hapus Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition" @click="cancelForm">
                                        Batal
                                    </button>
                                    <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg shadow hover:from-blue-700 hover:to-purple-700 transition" @click="submitForm">
                                        {{ form.id ? 'Simpan Perubahan' : 'Simpan Produk' }}
                                    </button>
                                </div>
                            </div>
                        </transition>

                        <div class="overflow-x-auto">
                            <div class="min-w-full">
                                <div class="grid grid-cols-6 bg-gray-100 dark:bg-gray-800 text-sm font-semibold text-gray-700 dark:text-gray-200 rounded-lg px-4 py-3">
                                    <div>Nama Toko</div>
                                    <div>Nama</div>
                                    <div>Kategori</div>
                                    <div>Stok</div>
                                    <div>Harga</div>
                                    <div class="text-right">Aksi</div>
                                </div>

                                <div class="space-y-2 mt-2" v-if="products.length">
                                    <div
                                        v-for="p in products"
                                        :key="p.id"
                                        class="grid grid-cols-6 items-center bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg px-4 py-4 gap-2"
                                    >
                                        <div class="text-sm text-gray-700 dark:text-gray-300">{{ store.name }}</div>
                                        <div class="text-sm text-gray-800 dark:text-gray-100 font-semibold">{{ p.name }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ p.description || '-' }}</div>
                                        <div class="text-sm text-gray-700 dark:text-gray-300">{{ p.stock }}</div>
                                        <div class="text-sm text-gray-800 dark:text-gray-100 font-semibold">Rp. {{ formatPrice(p.price) }}</div>
                                        <div class="flex justify-end gap-2">
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700"
                                                @click="editProduct(p)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-900/50"
                                                @click="deleteProduct(p.id)"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="text-sm text-gray-500 dark:text-gray-400 mt-3">Belum ada produk.</div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const sidebarCollapsed = ref(false);
const user = ref(null);
const cartCount = ref(0);
const searchQuery = ref('');

const store = ref({
    name: 'Nama Toko',
    stats: {
        incoming: 0,
        needShip: 0,
        shipped: 0,
        history: 0,
    },
});

const products = ref([]);
const showForm = ref(false);
const form = ref({
    id: null,
    name: '',
    category: '',
    price: 0,
    stock: 0,
    imageFile: null,
    imagePreview: null,
});

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const handleLogout = () => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    window.location.href = '/logout';
};

const handleCart = () => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    alert('Halaman Keranjang akan segera tersedia');
};

const handleProfile = () => {
    if (!user.value) {
        window.location.href = '/login';
        return;
    }
    alert('Halaman Profil akan segera tersedia');
};

const toggleForm = () => {
    showForm.value = !showForm.value;
    if (!showForm.value) resetForm();
};

const resetForm = () => {
    form.value = {
        id: null,
        name: '',
        category: '',
        price: 0,
        stock: 0,
        imageFile: null,
        imagePreview: null,
    };
};

const cancelForm = () => {
    resetForm();
    showForm.value = false;
};

const editProduct = (p) => {
    form.value = {
        id: p.id,
        name: p.name,
        category: p.description || '',
        price: p.price,
        stock: p.stock,
        imageFile: null,
        imagePreview: p.image_url || null,
    };
    showForm.value = true;
};

const deleteProduct = async (id) => {
    if (!confirm('Hapus produk ini?')) return;
    try {
        await axios.delete(`/api/products/${id}`);
        await fetchProducts();
    } catch (error) {
        alert('Gagal menghapus produk');
    }
};

const submitForm = async () => {
    if (!form.value.name || form.value.price < 0 || form.value.stock < 0) {
        alert('Nama, harga, dan stok wajib diisi dengan benar');
        return;
    }
    const payload = new FormData();
    payload.append('name', form.value.name);
    payload.append('category', form.value.category || '');
    payload.append('price', form.value.price);
    payload.append('stock', form.value.stock);
    if (form.value.imageFile) {
        payload.append('image', form.value.imageFile);
    } else if (form.value.imagePreview === null && form.value.id) {
        payload.append('remove_image', '1');
    }

    try {
        if (form.value.id) {
            await axios.post(`/api/products/${form.value.id}`, payload);
        } else {
            await axios.post('/api/products', payload);
        }
        await fetchProducts();
        resetForm();
        showForm.value = false;
    } catch (error) {
        alert('Gagal menyimpan produk');
    }
};

const onImageChange = (event) => {
    const file = event.target.files?.[0];
    if (file) {
        form.value.imageFile = file;
        form.value.imagePreview = URL.createObjectURL(file);
    }
};

const removeImage = () => {
    form.value.imageFile = null;
    form.value.imagePreview = null;
};

const fetchProducts = async () => {
    if (!user.value) return;
    try {
        const response = await axios.get('/api/my-products');
        products.value = response.data;
    } catch (error) {
        products.value = [];
    }
};

const checkAuth = async () => {
    try {
        const response = await axios.get('/api/user');
        user.value = response.data;
        store.value.name = response.data.name || 'Nama Toko';
    } catch (error) {
        user.value = null;
        window.location.href = '/login';
    }
};

const fetchCartCount = async () => {
    if (!user.value) {
        cartCount.value = 0;
        return;
    }
    try {
        const response = await axios.get('/api/cart/count');
        cartCount.value = response.data.count || 0;
    } catch (error) {
        cartCount.value = 0;
    }
};

onMounted(async () => {
    await checkAuth();
    await fetchCartCount();
    await fetchProducts();
});
</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
    opacity: 0;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.25s, transform 0.25s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(-6px);
}
</style>

