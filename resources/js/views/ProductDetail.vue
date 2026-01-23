<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="max-w-6xl mx-auto px-3 sm:px-4 md:px-6 py-4 sm:py-6">
            <!-- Back Button -->
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

            <!-- Loading -->
            <div v-if="loading" class="text-center py-12">
                <p class="text-[#1D1842] dark:text-[#FDA1A2]">
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

            <!-- Product Detail -->
            <div
                v-else
                class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-lg overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 p-4 sm:p-6">
                    <!-- Product Image -->
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

                    <!-- Product Info -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <!-- Store Name -->
                            <p
                                @click="goToStore(product.user_id || product.user?.id)"
                                class="text-sm font-semibold text-[#EF3B33] dark:text-[#EF3B33] mb-2 hover:text-[#d92f25] cursor-pointer transition-colors inline-block"
                            >
                                {{ product.store_name || product.user?.name || "Toko" }}
                            </p>

                            <!-- Product Name -->
                            <h1
                                class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-4"
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
                                    class="text-3xl sm:text-4xl font-bold text-[#EF3B33] dark:text-[#EF3B33]"
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
                                    class="text-sm font-medium text-[#1D1842] dark:text-[#FDA1A2]"
                                    >Jumlah:</label
                                >
                                <div
                                    class="flex items-center border-2 border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50"
                                >
                                    <button
                                        @click="decreaseQuantity"
                                        :disabled="quantity <= 0"
                                        class="px-4 py-2 text-[#EF3B33] dark:text-[#EF3B33] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/20 hover:scale-105 active:scale-95 active:shadow-inner"
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
                                        class="px-6 py-2 text-[#1D1842] dark:text-[#FDA1A2] font-medium min-w-[60px] text-center"
                                    >
                                        {{ quantity }}
                                    </span>
                                    <button
                                        @click="increaseQuantity"
                                        :disabled="quantity >= product.stock"
                                        class="px-4 py-2 text-[#EF3B33] dark:text-[#EF3B33] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/20 hover:scale-105 active:scale-95 active:shadow-inner"
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

        <!-- Toast Notification -->
        <ToastNotification
            :visible="toast.visible"
            :message="toast.message"
            :type="toast.type"
            @close="handleToastClose"
        />

        <!-- Login Modal -->
        <transition name="modal">
            <div
                v-if="showLoginModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showLoginModal = false"
            >
                <div
                    class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                >
                    <div class="flex flex-col items-center text-center">
                        <div
                            class="w-16 h-16 bg-white dark:bg-white rounded-full flex items-center justify-center mb-4"
                        >
                            <img
                                src="/images/logo-u.png"
                                alt="U Marketplace Logo"
                                class="w-10 h-10 object-contain"
                            />
                        </div>
                        <h3
                            class="text-xl font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-2"
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
                                class="flex-1 px-4 py-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg font-medium"
                            >
                                Batal
                            </button>
                            <button
                                @click="goToLogin"
                                class="flex-1 px-4 py-2 bg-[#FDA1A2] text-white rounded-lg font-semibold shadow-lg"
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
import ToastNotification from "../components/ToastNotification.vue";
// Get product ID from URL
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
    if (quantity.value > 0) {
        quantity.value -= 1;
    }
};

const handleToastClose = () => {
    toast.value.visible = false;
    // Reset quantity selector ke 0 setelah toast tertutup
    quantity.value = 0;
};

const handleAddToCart = async () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    if (!product.value) return;

    // Validasi: quantity harus lebih dari 0
    if (quantity.value <= 0) {
        toast.value = { visible: true, message: "Jumlah produk harus lebih dari 0", type: "error" };
        return;
    }

    // Validasi: quantity tidak boleh melebihi stok
    const stock = product.value.stock || 0;
    if (quantity.value > stock) {
        toast.value = { visible: true, message: `Stok tidak mencukupi. Sisa stok: ${stock}`, type: "error" };
        return;
    }

    // Optimistic update: tampilkan toast langsung tanpa menunggu API
    toast.value = { visible: true, message: "Produk berhasil ditambahkan ke keranjang!", type: "success" };

    try {
        // Tambahkan produk ke cart via API
        await axios.post("/api/cart/add", {
            product_id: product.value.id,
            quantity: quantity.value,
        });

        // Trigger cart update event untuk update cart count di halaman lain
        window.dispatchEvent(new CustomEvent("cartUpdated"));

        // Reset quantity setelah toast tertutup (auto close setelah 3 detik)
        setTimeout(() => {
            quantity.value = 0;
        }, 3000);
    } catch (error) {
        console.error("Error adding to cart:", error);
        const message = "Gagal menambahkan produk ke keranjang: " +
            (error.response?.data?.message || error.message);
        
        // Tutup toast sukses dan tampilkan error
        toast.value = { visible: true, message: message, type: "error" };
    }
};

const handleCheckout = async () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    if (!product.value) return;

    // Validasi: quantity harus lebih dari 0
    if (quantity.value <= 0) {
        toast.value = { visible: true, message: "Jumlah produk harus lebih dari 0", type: "error" };
        return;
    }

    // Validasi: quantity tidak boleh melebihi stok
    const stock = product.value.stock || 0;
    if (quantity.value > stock) {
        toast.value = { visible: true, message: `Stok tidak mencukupi. Sisa stok: ${stock}`, type: "error" };
        return;
    }

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
