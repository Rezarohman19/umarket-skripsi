<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
            <!-- Back Button -->
            <button
                @click="goBack"
                class="mb-6 flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors"
            >
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
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
                <span>Kembali</span>
            </button>

            <!-- Loading -->
            <div v-if="loading" class="text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">
                    Memuat detail produk...
                </p>
            </div>

            <!-- Product Not Found -->
            <div v-else-if="!product" class="text-center py-12">
                <svg
                    class="w-24 h-24 mx-auto text-gray-400 mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <p class="text-gray-600 dark:text-gray-400 text-lg">
                    Produk tidak ditemukan
                </p>
                <button
                    @click="goBack"
                    class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                >
                    Kembali ke Beranda
                </button>
            </div>

            <!-- Product Detail -->
            <div
                v-else
                class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-300 dark:border-gray-800 shadow-lg overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                    <!-- Product Image -->
                    <div class="w-full">
                        <div
                            class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-xl flex items-center justify-center overflow-hidden"
                        >
                            <svg
                                v-if="!product.image_url"
                                class="w-32 h-32 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                            <img
                                v-else
                                :src="product.image_url"
                                :alt="product.name"
                                class="w-full h-full object-cover"
                            />
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <!-- Store Name -->
                            <p
                                class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-2"
                            >
                                {{ product.store_name || "Toko" }}
                            </p>

                            <!-- Product Name -->
                            <h1
                                class="text-3xl font-bold text-gray-900 dark:text-white mb-4"
                            >
                                {{ product.name }}
                            </h1>

                            <!-- Category -->
                            <p
                                class="text-sm text-gray-500 dark:text-gray-400 mb-4"
                            >
                                {{
                                    product.category?.name ||
                                    product.description ||
                                    "Tidak ada kategori"
                                }}
                            </p>

                            <!-- Price -->
                            <div class="mb-6">
                                <p
                                    class="text-4xl font-bold text-blue-600 dark:text-blue-400"
                                >
                                    Rp. {{ formatPrice(product.price) }}
                                </p>
                                <p
                                    class="text-sm text-gray-500 dark:text-gray-400 mt-1"
                                >
                                    Stok: {{ product.stock }} pcs
                                </p>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-white mb-2"
                                >
                                    Deskripsi Produk
                                </h3>
                                <p
                                    class="text-gray-700 dark:text-gray-300 leading-relaxed"
                                >
                                    {{
                                        product.description ||
                                        "Tidak ada deskripsi produk"
                                    }}
                                </p>
                            </div>
                        </div>

                        <!-- Quantity Selector & Actions -->
                        <div class="space-y-4">
                            <!-- Quantity Selector -->
                            <div class="flex items-center gap-4">
                                <label
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Jumlah:</label
                                >
                                <div
                                    class="flex items-center border-2 border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800"
                                >
                                    <button
                                        @click="decreaseQuantity"
                                        :disabled="quantity <= 1"
                                        class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
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
                                                d="M20 12H4"
                                            />
                                        </svg>
                                    </button>
                                    <span
                                        class="px-6 py-2 text-gray-900 dark:text-white font-medium min-w-[60px] text-center"
                                    >
                                        {{ quantity }}
                                    </span>
                                    <button
                                        @click="increaseQuantity"
                                        :disabled="quantity >= product.stock"
                                        class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
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
                                                d="M12 4v16m8-8H4"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button
                                    @click="handleAddToCart"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-[0.98]"
                                >
                                    Tambah ke Keranjang
                                </button>
                                <button
                                    @click="handleCheckout"
                                    class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-[1.02] active:scale-[0.98]"
                                >
                                    Checkout Langsung
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Modal -->
        <transition name="modal">
            <div
                v-if="showLoginModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showLoginModal = false"
            >
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all"
                >
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-blue-600 dark:text-blue-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white mb-2"
                        >
                            Login Diperlukan
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Anda perlu login untuk menambahkan produk ke
                            keranjang atau melakukan checkout.
                        </p>
                        <div class="flex gap-3 w-full">
                            <button
                                @click="showLoginModal = false"
                                class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition"
                            >
                                Batal
                            </button>
                            <button
                                @click="goToLogin"
                                class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg"
                            >
                                Login
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
// Get product ID from URL
const getProductId = () => {
    const path = window.location.pathname;
    const parts = path.split("/");
    return parts[parts.length - 1];
};
const product = ref(null);
const loading = ref(true);
const quantity = ref(1);
const showLoginModal = ref(false);
const user = ref(null);

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const goBack = () => {
    window.history.back();
};

const goToLogin = () => {
    window.location.href = "/login";
};

const checkAuth = async () => {
    try {
        const response = await axios.get("/api/user");
        user.value = response.data;
    } catch (error) {
        if (error.response?.status !== 401) {
            console.error("Error checking auth:", error);
        }
        user.value = null;
    }
};

const fetchProduct = async () => {
    try {
        loading.value = true;
        const productId = getProductId();

        // Ambil produk dari API
        const response = await axios.get(`/api/products/${productId}`);
        product.value = response.data;
    } catch (error) {
        console.error("Error fetching product:", error);
        product.value = null;
    } finally {
        loading.value = false;
    }
};

const increaseQuantity = () => {
    if (product.value && quantity.value < product.value.stock) {
        quantity.value += 1;
    }
};

const decreaseQuantity = () => {
    if (quantity.value > 1) {
        quantity.value -= 1;
    }
};

const handleAddToCart = async () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    if (!product.value) return;

    try {
        // Tambahkan produk ke cart via API
        await axios.post("/api/cart/add", {
            product_id: product.value.id,
            quantity: quantity.value,
        });

        // Trigger cart update event
        window.dispatchEvent(new CustomEvent("cartUpdated"));

        // Reset quantity
        quantity.value = 1;

        alert("Produk berhasil ditambahkan ke keranjang!");
    } catch (error) {
        console.error("Error adding to cart:", error);
        alert(
            "Gagal menambahkan produk ke keranjang: " +
                (error.response?.data?.message || error.message)
        );
    }
};

const handleCheckout = async () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    if (!product.value) return;

    try {
        // Tambahkan ke cart dulu
        await axios.post("/api/cart/add", {
            product_id: product.value.id,
            quantity: quantity.value,
        });

        // Trigger cart update event
        window.dispatchEvent(new CustomEvent("cartUpdated"));

        // Redirect ke cart untuk checkout
        window.location.href = "/cart";
    } catch (error) {
        console.error("Error adding to cart:", error);
        alert(
            "Gagal menambahkan produk ke keranjang: " +
                (error.response?.data?.message || error.message)
        );
    }
};

onMounted(async () => {
    await checkAuth();
    await fetchProduct();
});
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>
