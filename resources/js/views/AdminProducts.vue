<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="flex">
            <!-- Left Sidebar -->
            <aside
                class="w-64 bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm fixed left-0 top-0 bottom-0 flex flex-col z-10"
            >
                <!-- Logo -->
                <div
                    class="p-4 flex items-center gap-3 border-b border-[#EF3B33]/30"
                >
                    <div
                        class="w-10 h-10 bg-[#1D1842] rounded-lg flex items-center justify-center"
                    >
                        <span class="text-white font-bold text-lg">U</span>
                    </div>
                    <span
                        class="text-lg font-bold text-white"
                        >U Market</span
                    >
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
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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
                        <div
                            class="w-10 h-10 bg-[#1D1842] rounded-full flex items-center justify-center"
                        >
                            <span class="text-white font-bold">U</span>
                        </div>

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
                                    placeholder="Cari produk"
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

                <!-- Products Table -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2
                            class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                        >
                            Daftar Produk
                        </h2>
                        <button
                            @click="openCreateModal"
                            class="px-4 py-2 bg-[#EF3B33] text-white rounded-lg text-sm font-medium shadow"
                        >
                            + Tambah Produk
                        </button>
                    </div>

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
                                            Nama Toko
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left font-semibold"
                                        >
                                            Nama
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left font-semibold"
                                        >
                                            Kategori / Deskripsi
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center font-semibold"
                                        >
                                            Stok
                                        </th>
                                        <th
                                            class="px-4 py-3 text-right font-semibold"
                                        >
                                            Harga
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
                                        v-for="product in filteredProducts"
                                        :key="product.id"
                                        class="border-t border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                    >
                                        <td class="px-4 py-3 align-middle">
                                            <span
                                                class="text-gray-800 dark:text-gray-200 text-xs font-medium"
                                            >
                                                {{
                                                    product.user?.name || "Toko"
                                                }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-medium"
                                            >
                                                {{ product.name }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span
                                                class="block text-gray-600 dark:text-gray-400 truncate max-w-xs"
                                            >
                                                {{ product.description || "-" }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-center"
                                        >
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-medium"
                                            >
                                                {{ product.stock }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-right"
                                        >
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-semibold"
                                            >
                                                Rp.
                                                {{ formatPrice(product.price) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-center"
                                        >
                                            <div class="inline-flex gap-2">
                                                <button
                                                    class="px-3 py-1 text-xs rounded-full bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#8E0D3C] dark:text-[#FDA1A2]"
                                                    @click="
                                                        openEditModal(product)
                                                    "
                                                >
                                                    Edit
                                                </button>
                                                <button
                                                    class="px-3 py-1 text-xs rounded-full bg-[#EF3B33]/20 dark:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#EF3B33]"
                                                    @click="
                                                        confirmDelete(product)
                                                    "
                                                >
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr
                                        v-if="
                                            !loading &&
                                            filteredProducts.length === 0
                                        "
                                    >
                                        <td
                                            colspan="6"
                                            class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            Tidak ada produk yang cocok.
                                        </td>
                                    </tr>
                                    <tr v-if="loading">
                                        <td
                                            colspan="6"
                                            class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            Memuat produk...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Tambah / Edit Produk -->
                <div
                    v-if="showModal"
                    class="fixed inset-0 z-20 flex items-center justify-center bg-black/40"
                >
                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-xl w-full max-w-lg p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                    >
                        <h3
                            class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                        >
                            {{
                                editingProduct ? "Edit Produk" : "Tambah Produk"
                            }}
                        </h3>

                        <div class="space-y-4 text-sm">
                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Nama Produk</label
                                >
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Kategori</label
                                >
                                <input
                                    v-model="form.category"
                                    type="text"
                                    placeholder="Masukkan kategori produk"
                                    class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Deskripsi</label
                                >
                                <textarea
                                    v-model="form.description"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                        >Harga</label
                                    >
                                    <input
                                        v-model="priceInput"
                                        type="text"
                                        placeholder="Contoh: Rp 10.000 atau 10000"
                                        @input="handlePriceInput"
                                        @blur="formatPriceInput"
                                        class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                        >Stok</label
                                    >
                                    <input
                                        v-model.number="form.stock"
                                        type="number"
                                        min="0"
                                        class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Gambar Produk</label
                                >
                                <input
                                    type="file"
                                    accept="image/*"
                                    @change="onImageChange"
                                    class="block w-full text-sm text-[#1D1842] dark:text-[#FDA1A2]"
                                />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <button
                                class="px-4 py-2 rounded-lg bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#1D1842] dark:text-[#FDA1A2] text-sm"
                                @click="closeModal"
                            >
                                Batal
                            </button>
                            <button
                                class="px-4 py-2 rounded-lg bg-[#EF3B33] text-white text-sm font-medium shadow"
                                @click="saveProduct"
                            >
                                Simpan
                            </button>
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

const searchQuery = ref("");
const admin = ref(null);
const products = ref([]);
const loading = ref(true);

const showModal = ref(false);
const editingProduct = ref(null);
const form = ref({
    name: "",
    category: "",
    description: "",
    price: 0,
    stock: 0,
    image: null,
});

const formatPrice = (price) =>
    new Intl.NumberFormat("id-ID").format(price || 0);

// Helper untuk parse harga dari format string ke number
const parsePrice = (priceString) => {
    if (!priceString) return 0;
    // Hapus semua karakter non-digit kecuali titik (untuk separator ribuan)
    const cleaned = priceString.toString().replace(/[^\d.]/g, '');
    // Hapus semua titik (karena di Indonesia titik = separator ribuan, bukan desimal)
    const numberString = cleaned.replace(/\./g, '');
    const parsed = parseInt(numberString, 10);
    return isNaN(parsed) ? 0 : parsed;
};

// Helper untuk format harga ke string dengan format Rupiah
const formatPriceString = (price) => {
    if (!price || price === 0) return '';
    return `Rp ${formatPrice(price)}`;
};

// Ref untuk input harga (string)
const priceInput = ref('');

// Handle input harga - parse dan update form.price
const handlePriceInput = (event) => {
    const value = event.target.value;
    priceInput.value = value;
    // Parse dan update form.price
    form.value.price = parsePrice(value);
};

// Format harga saat blur (keluar dari input)
const formatPriceInput = () => {
    if (form.value.price > 0) {
        priceInput.value = formatPriceString(form.value.price);
    } else {
        priceInput.value = '';
    }
};

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

const filteredProducts = computed(() => {
    if (!searchQuery.value) return products.value;
    const q = searchQuery.value.toLowerCase();
    return products.value.filter((p) => {
        return (
            (p.name || "").toLowerCase().includes(q) ||
            (p.description || "").toLowerCase().includes(q) ||
            (p.user?.name || "").toLowerCase().includes(q)
        );
    });
});

const fetchProducts = async () => {
    try {
        loading.value = true;
        const response = await axios.get("/api/products");
        products.value = response.data || [];
    } catch (error) {
        console.error("Error fetching products:", error);
        products.value = [];
    } finally {
        loading.value = false;
    }
};

const handleProfile = () => {
    window.location.href = "/admin/profile";
};

const resetForm = () => {
    form.value = {
        name: "",
        category: "",
        description: "",
        price: 0,
        stock: 0,
        image: null,
    };
    priceInput.value = '';
    editingProduct.value = null;
};

const openCreateModal = () => {
    resetForm();
    showModal.value = true;
};

const openEditModal = (product) => {
    editingProduct.value = product;
    form.value = {
        name: product.name || "",
        category: product.category || "",
        description: product.description || "",
        price: product.price || 0,
        stock: product.stock || 0,
        image: null,
    };
    // Set priceInput dengan format yang sudah diformat
    priceInput.value = product.price > 0 ? formatPriceString(product.price) : '';
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    priceInput.value = '';
};

const onImageChange = (event) => {
    const file = event.target.files?.[0];
    form.value.image = file || null;
};

const saveProduct = async () => {
    const payload = new FormData();
    payload.append("name", form.value.name);
    payload.append("category", form.value.category || "");
    payload.append("description", form.value.description || "");
    payload.append("price", String(form.value.price || 0));
    payload.append("stock", String(form.value.stock || 0));
    if (form.value.image) {
        payload.append("image", form.value.image);
    }

    try {
        if (editingProduct.value) {
            // Laravel expects PUT/PATCH for updates. Use method spoofing when sending FormData.
            payload.append("_method", "PUT");
            await axios.post(
                `/api/products/${editingProduct.value.id}`,
                payload,
                {
                    headers: { "Content-Type": "multipart/form-data" },
                }
            );
        } else {
            await axios.post("/api/products", payload, {
                headers: { "Content-Type": "multipart/form-data" },
            });
        }

        await fetchProducts();
        closeModal();
    } catch (error) {
        console.error("Error saving product:", error);
        alert("Gagal menyimpan produk");
    }
};

const confirmDelete = async (product) => {
    if (!confirm(`Hapus produk "${product.name}"?`)) return;

    try {
        await axios.delete(`/api/products/${product.id}`);
        await fetchProducts();
    } catch (error) {
        console.error("Error deleting product:", error);
        alert("Gagal menghapus produk");
    }
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
    await fetchProducts();
    window.addEventListener("userUpdated", handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener("userUpdated", handleUserUpdated);
});
</script>
