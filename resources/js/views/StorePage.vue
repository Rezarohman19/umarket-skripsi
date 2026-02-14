<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm sticky top-0 z-40">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4">
                <button
                    @click="goBack"
                    class="flex items-center gap-2 text-[#1D1842] dark:text-[#FDA1A2] hover:text-[#EF3B33] transition-all duration-150 cursor-pointer hover:bg-[#FDA1A2]/10 dark:hover:bg-[#8E0D3C]/20 rounded-lg px-3 py-2 active:scale-95"
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
                    <span class="font-medium">Kembali ke Beranda</span>
                </button>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
            <div v-if="loadingStore" class="text-center py-12">
                <p class="text-gray-600 dark:text-gray-400">Memuat informasi toko...</p>
            </div>

            <div v-else-if="store" class="mb-8">
                <div class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-lg p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-full flex items-center justify-center overflow-hidden border-2 border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30">
                                <svg
                                    v-if="!store.photo_url"
                                    class="w-12 h-12 text-gray-400"
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
                                <img
                                    v-else
                                    :src="store.photo_url"
                                    :alt="store.name"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>

                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ store.name }}
                            </h1>
                            <p v-if="store.description" class="text-gray-600 dark:text-gray-400 mb-4">{{ store.description }}</p>
                            
                            <button
                                v-if="store.phone"
                                @click="contactSeller"
                                class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner"
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
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                    />
                                </svg>
                                Hubungi Penjual
                            </button>
                            <p v-else class="text-sm text-gray-500 dark:text-gray-400">Nomor WhatsApp tidak tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                    Produk dari {{ store?.name || "Toko" }}
                </h2>

                <div v-if="loadingProducts" class="text-center py-12">
                    <p class="text-gray-600 dark:text-gray-400">Memuat produk...</p>
                </div>

                <div v-else-if="products.length === 0" class="text-center py-12 bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30">
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
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                        />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        Belum ada produk yang tersedia
                    </p>
                </div>

                <div v-else class="grid gap-3" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="relative bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 overflow-hidden shadow-md cursor-pointer hover:shadow-lg transition-shadow"
                        @click="goToProductDetail(product.id)"
                    >
                        <div class="w-full h-28 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 flex items-center justify-center overflow-hidden">
                            <svg
                                v-if="!product.image_url"
                                class="w-14 h-14 text-gray-400"
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

                        <div class="p-2 pb-1">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 mb-1">{{ product.name }}</h3>
                            <p class="text-base font-bold text-[#EF3B33] dark:text-[#EF3B33]">Rp. {{ formatPrice(product.price) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Stok: {{ product.stock }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ToastNotification
            :visible="toast.visible"
            :message="toast.message"
            :type="toast.type"
            @close="toast.visible = false"
        />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import ToastNotification from "../components/ToastNotification.vue";

const getUserId = () => {
    const path = window.location.pathname;
    const parts = path.split("/");
    return parts[parts.length - 1];
};

const store = ref(null);
const products = ref([]);
const loadingStore = ref(true);
const loadingProducts = ref(true);
const toast = ref({ visible: false, message: "", type: "success" });

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};

const fetchStoreInfo = async () => {
    const userId = getUserId();
    if (!userId) {
        loadingStore.value = false;
        return;
    }

    try {
        const response = await axios.get(`/api/store/${userId}`);
        store.value = response.data;
    } catch (error) {
        console.error("Error fetching store info:", error);
        toast.value = {
            visible: true,
            message: "Gagal memuat informasi toko",
            type: "error",
        };
    } finally {
        loadingStore.value = false;
    }
};

const fetchProducts = async () => {
    const userId = getUserId();
    if (!userId) {
        loadingProducts.value = false;
        return;
    }

    try {
        const response = await axios.get(`/api/store/${userId}/products`);
        products.value = response.data || [];
    } catch (error) {
        console.error("Error fetching products:", error);
        toast.value = {
            visible: true,
            message: "Gagal memuat produk",
            type: "error",
        };
    } finally {
        loadingProducts.value = false;
    }
};

const contactSeller = () => {
    if (!store.value || !store.value.phone) {
        toast.value = {
            visible: true,
            message: "Nomor WhatsApp tidak tersedia",
            type: "error",
        };
        return;
    }

    let phoneNumber = store.value.phone.toString().replace(/[^\d+]/g, "");

    if (phoneNumber.startsWith("0")) {
        phoneNumber = "62" + phoneNumber.substring(1);
    }

    if (!phoneNumber.startsWith("+")) {
        phoneNumber = "+" + phoneNumber;
    }

    const message = `Halo ${store.value.name},\n\nSaya tertarik dengan produk yang Anda jual. Apakah masih tersedia?\n\nTerima kasih.`;

    const whatsappUrl = `https://wa.me/${phoneNumber.replace("+", "")}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, "_blank");
};

const goToProductDetail = (productId) => {
    window.location.href = `/product/${productId}`;
};

const goBack = () => {
    window.location.href = "/";
};

onMounted(async () => {
    await Promise.all([fetchStoreInfo(), fetchProducts()]);
});
</script>

<style scoped>
</style>
