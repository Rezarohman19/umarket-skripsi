<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] pb-24">
        <div class="max-w-5xl mx-auto py-4 sm:py-6 px-3 sm:px-4 md:px-6 space-y-4">
            <div
                class="flex items-center gap-2 text-[#1D1842] dark:text-[#FDA1A2] cursor-pointer"
                @click="goBack"
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
            </div>

            <div class="flex items-center justify-between relative">
                <div class="w-8"></div>
                <h1 class="text-lg sm:text-xl font-semibold text-center text-[#1D1842] dark:text-[#FDA1A2]">
                    Keranjang Saya
                </h1>
                <div class="w-8 flex justify-end">
                    <div class="relative">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-[#1D1842] dark:text-[#FDA1A2]"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                        <span
                            v-if="cartCount > 0"
                            class="absolute -top-2 -right-2 bg-[#EF3B33] text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center"
                        >
                            {{ cartCount }}
                        </span>
                    </div>
                </div>
            </div>

            <div v-if="loading" class="text-center py-8">
                <p class="text-[#1D1842] dark:text-[#FDA1A2]">
                    Memuat keranjang...
                </p>
            </div>

            <div v-else-if="cartItems.length === 0" class="text-center py-12">
                <svg
                    class="w-24 h-24 mx-auto text-[#FDA1A2] dark:text-[#FDA1A2] mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                    />
                </svg>
                <p class="text-[#1D1842] dark:text-[#FDA1A2] text-lg">
                    Keranjang Anda kosong
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                    Tambahkan produk ke keranjang untuk melihatnya di sini
                </p>
            </div>

            <div v-else class="space-y-4">
                <div
                    class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 flex items-center gap-3"
                >
                    <input
                        type="checkbox"
                        :checked="isAllSelected"
                        @change="toggleSelectAll"
                        class="w-5 h-5 text-[#EF3B33] bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded focus:outline-none cursor-pointer"
                    />
                    <label
                        class="text-sm font-semibold text-[#1D1842] dark:text-[#FDA1A2] cursor-pointer"
                        @click="toggleSelectAll"
                    >
                        Pilih Semua
                    </label>
                </div>

                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-3 sm:p-4 flex items-start sm:items-center gap-3 sm:gap-4"
                >
                    <input
                        type="checkbox"
                        :checked="selectedItems.includes(item.id)"
                        @change="toggleItem(item.id)"
                        class="w-4 h-4 sm:w-5 sm:h-5 text-[#EF3B33] bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded focus:outline-none cursor-pointer flex-shrink-0"
                    />

                    <div
                        class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 flex items-center justify-center rounded-md overflow-hidden border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20 flex-shrink-0"
                    >
                        <img
                            v-if="item.image_url"
                            :src="item.image_url"
                            :alt="item.product_name"
                            class="w-full h-full object-cover"
                        />
                        <svg
                            v-else
                            class="w-12 h-12 text-gray-400"
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
                    </div>

                    <div class="flex-1 min-w-0">
                        <p
                            class="text-sm font-semibold text-[#EF3B33] dark:text-[#EF3B33]"
                        >
                            {{ item.store_name }}
                        </p>
                        <p
                            class="text-sm text-[#1D1842] dark:text-[#FDA1A2] font-semibold"
                        >
                            {{ item.product_name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ item.product_description || "Tidak ada deskripsi" }}</p>
                        <p
                            class="text-sm font-semibold text-[#EF3B33] dark:text-[#EF3B33] mt-1"
                        >
                            Rp. {{ formatPrice(item.price) }}
                        </p>
                    </div>

                    <div class="flex flex-col items-end gap-2 sm:gap-1 flex-shrink-0">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <button
                                class="w-7 h-7 sm:w-8 sm:h-8 border border-[#EF3B33]/30 dark:border-[#EF3B33]/30 rounded-md text-base sm:text-lg text-[#EF3B33] dark:text-[#EF3B33] bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10 cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/20 hover:border-[#EF3B33]/50 hover:shadow-md active:scale-95 active:shadow-inner flex items-center justify-center"
                                @click="decrease(item)"
                            >
                                -
                            </button>
                            <div
                                class="w-8 sm:w-10 text-center text-[#1D1842] dark:text-[#FDA1A2] font-semibold text-sm sm:text-base"
                            >
                                {{ item.qty }}
                            </div>
                            <button
                                class="w-7 h-7 sm:w-8 sm:h-8 border border-[#EF3B33]/30 dark:border-[#EF3B33]/30 rounded-md text-base sm:text-lg text-[#EF3B33] dark:text-[#EF3B33] bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10 cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/20 hover:border-[#EF3B33]/50 hover:shadow-md active:scale-95 active:shadow-inner flex items-center justify-center"
                                @click="increase(item)"
                            >
                                +
                            </button>
                            <button
                                @click="removeItem(item)"
                                class="p-1 sm:p-1.5 text-[#EF3B33] dark:text-[#EF3B33] bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10 rounded-lg ml-1 sm:ml-2 cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/20 hover:shadow-md active:scale-95 active:shadow-inner"
                                title="Hapus dari keranjang"
                            >
                                <svg
                                    class="w-4 h-4 sm:w-5 sm:h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    />
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-[#EF3B33] text-right w-full pr-1 mt-1 sm:mt-0">
                            Sisa stok: {{ item.stock }}
                        </p>
                    </div>


                </div>
            </div>
        </div>

        <div
            v-if="!loading && cartItems.length > 0 && selectedItems.length > 0"
            class="fixed bottom-0 left-0 right-0 bg-white dark:bg-[#1D1842] border-t border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-lg z-50"
        >
            <div class="max-w-5xl mx-auto px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-[#1D1842] dark:text-[#FDA1A2]">
                            Total Harga
                        </p>
                        <p
                            class="text-xl font-bold text-[#EF3B33] dark:text-[#EF3B33]"
                        >
                            Rp. {{ formatPrice(totalPrice) }}
                        </p>
                    </div>

                    <button
                        @click="handleCheckout"
                        class="px-4 sm:px-6 md:px-8 py-2.5 sm:py-3 bg-[#EF3B33] text-white rounded-lg font-semibold shadow-lg ml-2 sm:ml-4 cursor-pointer transition-all duration-150 hover:bg-[#d92f25] hover:shadow-xl active:scale-95 active:shadow-inner text-sm sm:text-base"
                    >
                        Checkout ({{ selectedItems.length }})
                    </button>
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

    <ConfirmModal
        :visible="confirmModal.visible"
        :title="confirmModal.title"
        :message="confirmModal.message"
        @confirm="handleConfirmAction"
        @cancel="closeConfirmModal"
    />
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import ToastNotification from "../components/ToastNotification.vue";
import ConfirmModal from "../components/ConfirmModal.vue";

const cartItems = ref([]);
const loading = ref(true);
const selectedItems = ref([]);
const cartCount = ref(0);

const toast = ref({ visible: false, message: "", type: "success" });
const confirmModal = ref({ visible: false, title: "", message: "", onConfirm: null });

const showToast = (message, type = "success") => {
    toast.value = { visible: true, message, type };
};

const closeConfirmModal = () => {
    confirmModal.value.visible = false;
};

const handleConfirmAction = () => {
    if (confirmModal.value.onConfirm) confirmModal.value.onConfirm();
    closeConfirmModal();
};

const removeItem = (item) => {
    confirmModal.value = {
        visible: true,
        title: "Hapus Produk",
        message: `Hapus "${item.product_name}" dari keranjang?`,
        onConfirm: async () => {
            closeConfirmModal();
            
            // Backup data sebelum optimistically removing
            const backupCartItems = [...cartItems.value];
            const backupSelectedItems = [...selectedItems.value];
            const backupCartCount = cartCount.value;

            // Optimistic update
            const itemToRemoveId = item.id;
            selectedItems.value = selectedItems.value.filter(id => id !== itemToRemoveId);
            cartItems.value = cartItems.value.filter(i => i.id !== itemToRemoveId);
            cartCount.value = cartItems.value.length;

            try {
                const response = await axios.post(`/api/cart/remove/${itemToRemoveId}`);
                showToast("Produk dihapus dari keranjang", "success");
                window.dispatchEvent(new CustomEvent("cartUpdated"));
            } catch (error) {
                console.error("Error removing item:", error);
                
                // Rollback jika gagal
                cartItems.value = backupCartItems;
                selectedItems.value = backupSelectedItems;
                cartCount.value = backupCartCount;
                
                const message = error.response?.data?.message || "Gagal menghapus produk";
                showToast(message, "error");

                // Jika errornya adalah 401 atau session expired, baru refresh total
                if (error.response?.status === 401 || error.response?.status === 419) {
                    fetchCartItems();
                }
            }
        }
    };
};

const increase = async (item) => {
    const currentQty = parseInt(item.qty) || 0;
    const newQty = currentQty + 1;
    const stock = item.stock ?? 0;
    
    if (newQty > stock) {
        showToast("Stok tidak mencukupi. Sisa stok: " + stock, "error");
        return;
    }

    const oldQty = item.qty;
    item.qty = newQty;

    axios.post("/api/cart/update", { item_id: item.id, qty: newQty })
        .then(() => {
            window.dispatchEvent(new CustomEvent("cartUpdated"));
        })
        .catch((error) => {
            console.error("Error updating quantity:", error);
            item.qty = oldQty;
            showToast(error.response?.data?.message || "Gagal menambah", "error");
            fetchCartItems();
        });
};

const decrease = async (item) => {
    const currentQty = parseInt(item.qty) || 0;
    if (currentQty <= 1) return;

    const newQty = currentQty - 1;

    const oldQty = item.qty;
    item.qty = newQty;

    axios.post("/api/cart/update", { item_id: item.id, qty: newQty })
        .then(() => {
            window.dispatchEvent(new CustomEvent("cartUpdated"));
        })
        .catch((error) => {
            console.error("Error updating quantity:", error);
            item.qty = oldQty;
            showToast("Gagal mengurangi jumlah produk", "error");
            fetchCartItems();
        });
};

const handleCheckout = () => {
    if (selectedItems.value.length === 0) {
        showToast("Pilih minimal satu produk untuk checkout", "error");
        return;
    }
    const itemIds = selectedItems.value.join(",");
    window.location.href = `/checkout?items=${itemIds}`;
};

const goBack = () => {
    const referrer = document.referrer;
    const isFromConfirmation = referrer.includes("/order-confirmation");
    const isFromCheckout = referrer.includes("/checkout");
    const fromCheckoutFlow =
        sessionStorage.getItem("from_checkout_flow") === "true";

    if (isFromConfirmation || isFromCheckout || fromCheckoutFlow) {
        sessionStorage.removeItem("from_checkout_flow");
        window.location.href = "/";
    } else {
        window.history.back();
    }
};

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const totalPrice = computed(() => {
    return cartItems.value
        .filter((item) => selectedItems.value.includes(item.id))
        .reduce((total, item) => total + item.price * item.qty, 0);
});

const isAllSelected = computed(() => {
    return (
        cartItems.value.length > 0 &&
        selectedItems.value.length === cartItems.value.length
    );
});

const toggleItem = (itemId) => {
    const index = selectedItems.value.indexOf(itemId);
    if (index > -1) {
        selectedItems.value.splice(index, 1);
    } else {
        selectedItems.value.push(itemId);
    }
};

const toggleSelectAll = () => {
    if (isAllSelected.value) {
        selectedItems.value = [];
    } else {
        selectedItems.value = cartItems.value.map((item) => item.id);
    }
};

const fetchCartItems = async () => {
    try {
        loading.value = true;
        const response = await axios.get("/api/cart");
        const apiItems = response.data.items || [];
        cartItems.value = apiItems.map((item) => ({
            id: item.id,
            product_id: item.product_id,
            product_name: item.product?.name || item.product_name || "Produk",
            product_description:
                item.product?.description || item.product_description || "",
            price: item.product?.price || item.price || 0,
            qty: item.qty || item.quantity || 0,
            store_name: item.store_name || item.product?.user?.name || "Toko",
            image_url: item.product?.image_url || item.image_url || null,
            stock: item.product?.stock || item.stock || 0,
        }));
    } catch (error) {
        console.error("Error fetching cart items:", error);
        cartItems.value = [];
    } finally {
        loading.value = false;
        cartCount.value = cartItems.value.length;
    }
};

onMounted(async () => {
    await fetchCartItems();
    const referrer = document.referrer;
    const isFromConfirmation = referrer.includes("/order-confirmation");
    const isFromCheckout = referrer.includes("/checkout");

    if (isFromConfirmation || isFromCheckout) {
        sessionStorage.setItem("from_checkout_flow", "true");
    }
});
</script>

<style scoped></style>
