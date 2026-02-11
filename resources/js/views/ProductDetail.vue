<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 py-4 sm:py-6">
            <button
                @click="goBack"
                class="mb-6 flex items-center gap-2 text-[#1D1842] dark:text-[#FDA1A2]"
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

            <div v-if="loading" class="text-center py-12">
                <p class="text-[#1D1842] dark:text-[#FDA1A2]">
                    Memuat detail produk...
                </p>
            </div>

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
                <p class="text-[#1D1842] dark:text-[#FDA1A2] text-lg">
                    Produk tidak ditemukan
                </p>
                <button
                    @click="goBack"
                    class="mt-4 px-6 py-2 bg-[#EF3B33] text-white rounded-lg"
                >
                    Kembali ke Beranda
                </button>
            </div>

            <div
                v-else
                class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-lg overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 p-4 sm:p-6">
                    <div class="w-full">
                        <div
                            class="w-full h-64 sm:h-80 md:h-96 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-xl flex items-center justify-center overflow-hidden border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
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

                    <div class="flex flex-col justify-between">
                        <div>
                            <p
                                @click="goToStore(product.user_id || product.user?.id)"
                                class="text-sm font-semibold text-[#EF3B33] dark:text-[#EF3B33] mb-2 hover:text-[#d92f25] cursor-pointer transition-colors inline-block"
                            >
                                {{ product.store_name || product.user?.name || "Toko" }}
                            </p>

                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ product.name }}</h1>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ product.category?.name || product.description || "Tidak ada kategori" }}</p>

                            <div class="mb-6">
                                <p class="text-3xl sm:text-4xl font-bold text-[#EF3B33] dark:text-[#EF3B33]">Rp. {{ formatPrice(product.price) }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Stok: {{ product.stock }} pcs</p>
                            </div>

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Deskripsi Produk</h3>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ product.description || "Tidak ada deskripsi produk" }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <label
                                    class="text-xs sm:text-sm font-medium text-[#1D1842] dark:text-[#FDA1A2]"
                                    >Jumlah:</label
                                >
                                <div
                                    class="flex items-center border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50"
                                >
                                    <button
                                        @click="decreaseQuantity"
                                        :disabled="quantity <= 0"
                                        class="px-2 py-1 sm:px-3 sm:py-1.5 text-[#EF3B33] dark:text-[#EF3B33] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/20 hover:scale-105 active:scale-95 active:shadow-inner"
                                    >
                                        <svg
                                            class="w-3.5 h-3.5 sm:w-4 sm:h-4"
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
                                        class="px-3 py-1 sm:px-4 sm:py-1.5 text-[#1D1842] dark:text-[#FDA1A2] font-medium min-w-[45px] sm:min-w-[50px] text-center text-sm sm:text-base"
                                    >
                                        {{ quantity }}
                                    </span>
                                    <button
                                        @click="increaseQuantity"
                                        :disabled="quantity >= product.stock"
                                        class="px-2 py-1 sm:px-3 sm:py-1.5 text-[#EF3B33] dark:text-[#EF3B33] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/20 hover:scale-105 active:scale-95 active:shadow-inner"
                                    >
                                        <svg
                                            class="w-3.5 h-3.5 sm:w-4 sm:h-4"
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

                            <div class="flex flex-row gap-2 sm:gap-3">
                                <button
                                    @click="handleAddToCart"
                                    class="flex-1 bg-[#FDA1A2] dark:bg-[#FDA1A2] text-[#8E0D3C] dark:text-[#8E0D3C] font-semibold py-2.5 sm:py-3 px-2 sm:px-6 rounded-lg shadow-md cursor-pointer transition-all duration-150 hover:bg-[#f88a8c] hover:shadow-lg active:scale-95 active:shadow-inner text-xs sm:text-base"
                                >
                                    <span class="hidden sm:inline">Tambah ke Keranjang</span>
                                    <span class="sm:hidden">Tambah</span>
                                </button>
                                <button
                                    @click="handleCheckout"
                                    class="flex-1 bg-[#EF3B33] dark:bg-[#EF3B33] text-white font-semibold py-2.5 sm:py-3 px-2 sm:px-6 rounded-lg shadow-md cursor-pointer transition-all duration-150 hover:bg-[#d92f25] hover:shadow-lg active:scale-95 active:shadow-inner text-xs sm:text-base"
                                >
                                    <span class="hidden sm:inline">Checkout Langsung</span>
                                    <span class="sm:hidden">Checkout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

        <ToastNotification
            :visible="toast.visible"
            :message="toast.message"
            :type="toast.type"
            @close="handleToastClose"
        />

        <transition name="modal">
            <div
                v-if="showLoginModal"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 flex items-center justify-center z-50 p-4 backdrop-blur-sm"
                @click.self="showLoginModal = false"
            >
                <div
                    class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all modal-content"
                >
                    <div class="bg-[#FDA1A2] rounded-t-2xl p-4 sm:p-6">
                        <div class="flex items-center justify-center mb-2">
                            <div
                                class="w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-full flex items-center justify-center shadow-md"
                            >
                                <img
                                    src="/images/logo-u.png"
                                    alt="U Marketplace Logo"
                                    class="w-8 h-8 sm:w-10 sm:h-10 object-contain"
                                />
                            </div>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white text-center drop-shadow-sm">
                            Login Diperlukan
                        </h3>
                    </div>

                    <div class="p-4 sm:p-6 bg-white dark:bg-[#1D1842]">
                        <p class="text-sm sm:text-base text-gray-800 dark:text-gray-200 text-center mb-4 sm:mb-6 leading-relaxed">
                            Anda perlu login untuk menambahkan produk ke
                            keranjang atau melakukan checkout.
                        </p>
                        <div class="flex gap-2 sm:gap-3 w-full">
                            <button
                                @click="showLoginModal = false"
                                class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm sm:text-base font-semibold rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-150 shadow-sm"
                            >
                                Batal
                            </button>
                            <button
                                @click="goToLogin"
                                class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-[#EF3B33] hover:bg-[#d92f25] text-white text-sm sm:text-base font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-150 transform hover:scale-[1.02] active:scale-[0.98]"
                            >
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="h-1 bg-[#FDA1A2] rounded-b-2xl"></div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import ToastNotification from "../components/ToastNotification.vue";
const getProductId = () => {
    const path = window.location.pathname;
    const parts = path.split("/");
    return parts[parts.length - 1];
};
const product = ref(null);
const loading = ref(true);
const quantity = ref(0);
const showLoginModal = ref(false);
const user = ref(null);
const toast = ref({ visible: false, message: "", type: "success" });

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const goBack = () => {
    window.history.back();
};

const goToStore = (userId) => {
    if (!userId) return;
    window.location.href = `/store/${userId}`;
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
    if (quantity.value > 0) {
        quantity.value -= 1;
    }
};

const handleToastClose = () => {
    toast.value.visible = false;
    quantity.value = 0;
};

const handleAddToCart = async () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    if (!product.value) return;

    if (quantity.value <= 0) {
        toast.value = { visible: true, message: "Jumlah produk harus lebih dari 0", type: "error" };
        return;
    }

    const stock = product.value.stock || 0;
    if (quantity.value > stock) {
        toast.value = { visible: true, message: `Stok tidak mencukupi. Sisa stok: ${stock}`, type: "error" };
        return;
    }

    toast.value = { visible: true, message: "Produk berhasil ditambahkan ke keranjang!", type: "success" };

    try {
        await axios.post("/api/cart/add", {
            product_id: product.value.id,
            quantity: quantity.value,
        });

        window.dispatchEvent(new CustomEvent("cartUpdated"));

        setTimeout(() => {
            quantity.value = 0;
        }, 3000);
    } catch (error) {
        console.error("Error adding to cart:", error);
        const message = "Gagal menambahkan produk ke keranjang: " +
            (error.response?.data?.message || error.message);
        
        toast.value = { visible: true, message: message, type: "error" };
    }
};

const handleCheckout = async () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    if (!product.value) return;

    if (quantity.value <= 0) {
        toast.value = { visible: true, message: "Jumlah produk harus lebih dari 0", type: "error" };
        return;
    }

    const stock = product.value.stock || 0;
    if (quantity.value > stock) {
        toast.value = { visible: true, message: `Stok tidak mencukupi. Sisa stok: ${stock}`, type: "error" };
        return;
    }

    try {
        await axios.post("/api/cart/add", {
            product_id: product.value.id,
            quantity: quantity.value,
        });

        window.dispatchEvent(new CustomEvent("cartUpdated"));

        window.location.href = "/cart";
    } catch (error) {
        console.error("Error adding to cart:", error);
        toast.value = { 
            visible: true, 
            message: "Gagal menambahkan produk ke keranjang: " + (error.response?.data?.message || error.message), 
            type: "error" 
        };
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
