<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] pb-24">
        <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 space-y-4">
            <!-- Back -->
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

            <!-- Title -->
            <h1
                class="text-xl font-semibold text-center text-[#1D1842] dark:text-[#FDA1A2]"
            >
                Keranjang Saya
            </h1>

            <!-- Loading -->
            <div v-if="loading" class="text-center py-8">
                <p class="text-[#1D1842] dark:text-[#FDA1A2]">
                    Memuat keranjang...
                </p>
            </div>

            <!-- Empty Cart -->
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

            <!-- Cart List -->
            <div v-else class="space-y-4">
                <!-- Pilih Semua -->
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

                <!-- Cart Items -->
                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 flex items-center gap-4"
                >
                    <!-- Checkbox -->
                    <input
                        type="checkbox"
                        :checked="selectedItems.includes(item.id)"
                        @change="toggleItem(item.id)"
                        class="w-5 h-5 text-[#EF3B33] bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded focus:outline-none cursor-pointer"
                    />

                    <!-- Image -->
                    <div
                        class="w-24 h-24 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 flex items-center justify-center rounded-md overflow-hidden border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
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

                    <!-- Info -->
                    <div class="flex-1">
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
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{
                                item.product_description ||
                                "Tidak ada deskripsi"
                            }}
                        </p>
                        <p
                            class="text-sm font-semibold text-[#EF3B33] dark:text-[#EF3B33] mt-1"
                        >
                            Rp. {{ formatPrice(item.price) }}
                        </p>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center gap-3">
                        <button
                            class="w-8 h-8 border border-[#EF3B33]/30 dark:border-[#EF3B33]/30 rounded-md text-lg text-[#EF3B33] dark:text-[#EF3B33] bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10"
                            @click="decrease(item)"
                        >
                            -
                        </button>
                        <div
                            class="w-10 text-center text-[#1D1842] dark:text-[#FDA1A2] font-semibold"
                        >
                            {{ item.qty }}
                        </div>
                        <button
                            class="w-8 h-8 border border-[#EF3B33]/30 dark:border-[#EF3B33]/30 rounded-md text-lg text-[#EF3B33] dark:text-[#EF3B33] bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10"
                            @click="increase(item)"
                        >
                            +
                        </button>
                    </div>

                    <!-- Delete Button -->
                    <button
                        @click="removeItem(item)"
                        class="p-2 text-[#EF3B33] dark:text-[#EF3B33] bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10 rounded-lg"
                        title="Hapus dari keranjang"
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
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Checkout Footer (Sticky) -->
        <div
            v-if="!loading && cartItems.length > 0 && selectedItems.length > 0"
            class="fixed bottom-0 left-0 right-0 bg-white dark:bg-[#1D1842] border-t border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-lg z-50"
        >
            <div class="max-w-5xl mx-auto px-4 sm:px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Total -->
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

                    <!-- Checkout Button -->
                    <button
                        @click="handleCheckout"
                        class="px-8 py-3 bg-[#EF3B33] text-white rounded-lg font-semibold shadow-lg ml-4"
                    >
                        Checkout ({{ selectedItems.length }})
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const cartItems = ref([]);
const loading = ref(true);
const selectedItems = ref([]);

const goBack = () => {
    // Cek apakah user datang dari halaman konfirmasi atau checkout
    // Bisa dari referrer atau sessionStorage flag
    const referrer = document.referrer;
    const isFromConfirmation = referrer.includes("/order-confirmation");
    const isFromCheckout = referrer.includes("/checkout");
    const fromCheckoutFlow =
        sessionStorage.getItem("from_checkout_flow") === "true";

    // Jika datang dari konfirmasi atau checkout, langsung ke beranda
    // Kalau tidak, gunakan history back biasa
    if (isFromConfirmation || isFromCheckout || fromCheckoutFlow) {
        // Hapus flag setelah digunakan
        sessionStorage.removeItem("from_checkout_flow");
        window.location.href = "/";
    } else {
        window.history.back();
    }
};

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

// Total harga dari item yang dicentang
const totalPrice = computed(() => {
    return cartItems.value
        .filter((item) => selectedItems.value.includes(item.id))
        .reduce((total, item) => total + item.price * item.qty, 0);
});

// Cek apakah semua item tercentang
const isAllSelected = computed(() => {
    return (
        cartItems.value.length > 0 &&
        selectedItems.value.length === cartItems.value.length
    );
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
        selectedItems.value = cartItems.value.map((item) => item.id);
    }
};

const fetchCartItems = async () => {
    try {
        loading.value = true;

        // Ambil cart dari API
        const response = await axios.get("/api/cart");
        const apiItems = response.data.items || [];

        // Map items ke format yang diharapkan
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
        }));
    } catch (error) {
        console.error("Error fetching cart items:", error);
        cartItems.value = [];
    } finally {
        loading.value = false;
    }
};

const increase = async (item) => {
    const newQty = item.qty + 1;
    const stock = item.product?.stock ?? item.stock ?? undefined;
    if (stock !== undefined && newQty > stock) {
        alert("Stok tidak mencukupi");
        return;
    }
    try {
        await axios.post("/api/cart/update", {
            item_id: item.id,
            qty: newQty,
        });
        item.qty = newQty;
        window.dispatchEvent(new CustomEvent("cartUpdated"));
    } catch (error) {
        console.error("Error updating quantity:", error);
        const message =
            error.response?.data?.message || "Gagal menambah jumlah produk";
        alert(message);
    }
};

const decrease = async (item) => {
    if (item.qty <= 1) return;

    try {
        const newQty = item.qty - 1;
        await axios.post("/api/cart/update", {
            item_id: item.id,
            qty: newQty,
        });
        item.qty = newQty;
        window.dispatchEvent(new CustomEvent("cartUpdated"));
    } catch (error) {
        console.error("Error updating quantity:", error);
        alert("Gagal mengurangi jumlah produk");
    }
};

const removeItem = async (item) => {
    if (!confirm(`Hapus "${item.product_name}" dari keranjang?`)) {
        return;
    }

    try {
        // Hapus dari database via API
        await axios.post(`/api/cart/remove/${item.id}`);

        // Hapus dari selectedItems jika sedang terpilih
        const index = selectedItems.value.indexOf(item.id);
        if (index > -1) {
            selectedItems.value.splice(index, 1);
        }

        cartItems.value = cartItems.value.filter((i) => i.id !== item.id);

        // Trigger custom event untuk update cart count di halaman lain
        window.dispatchEvent(new CustomEvent("cartUpdated"));
    } catch (error) {
        console.error("Error removing item:", error);
        alert(
            "Gagal menghapus produk dari keranjang: " +
                (error.response?.data?.message || error.message),
        );
    }
};

const handleCheckout = () => {
    if (selectedItems.value.length === 0) {
        alert("Pilih minimal satu produk untuk checkout");
        return;
    }

    // Redirect ke halaman checkout dengan item IDs sebagai query parameter
    const itemIds = selectedItems.value.join(",");
    window.location.href = `/checkout?items=${itemIds}`;
};

onMounted(async () => {
    await fetchCartItems();

    // Jika user datang dari halaman konfirmasi atau checkout,
    // set flag di sessionStorage untuk menandai bahwa user datang dari checkout flow
    // Ini akan digunakan oleh fungsi goBack() untuk redirect ke beranda
    const referrer = document.referrer;
    const isFromConfirmation = referrer.includes("/order-confirmation");
    const isFromCheckout = referrer.includes("/checkout");

    if (isFromConfirmation || isFromCheckout) {
        // Set flag di sessionStorage untuk menandai bahwa user datang dari konfirmasi/checkout
        sessionStorage.setItem("from_checkout_flow", "true");
    }
});
</script>

<style scoped></style>
