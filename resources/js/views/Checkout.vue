<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] pb-24">
        <div class="max-w-6xl mx-auto py-4 sm:py-6 px-3 sm:px-4 md:px-6">
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
                <span>Kembali ke Keranjang</span>
            </button>

            <!-- Title -->
            <h1
                class="text-2xl font-bold text-[#1D1842] dark:text-[#FDA1A2] mb-6"
            >
                Checkout
            </h1>

            <div v-if="loading" class="text-center py-12">
                <p class="text-[#1D1842] dark:text-[#FDA1A2]">
                    Memuat data checkout...
                </p>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Alamat Pengiriman -->
                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <h2
                                class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                            >
                                Alamat Pengiriman
                            </h2>
                            <button
                                @click="showAddressModal = true"
                                class="text-sm text-[#EF3B33] dark:text-[#EF3B33]"
                            >
                                Ubah
                            </button>
                        </div>
                        <div class="space-y-2">
                            <p
                                class="text-gray-900 dark:text-white font-medium"
                            >
                                {{ shippingAddress.name }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{ shippingAddress.phone }}
                            </p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{
                                    shippingAddress.address ||
                                    "Alamat belum diisi"
                                }}
                            </p>
                        </div>
                    </div>

                    <!-- Daftar Produk (dikelompokkan per toko) -->
                    <div class="space-y-6">
                        <div
                            v-for="group in groupedByStore"
                            :key="group.store_name"
                            class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6"
                        >
                            <h2
                                class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                            >
                                Toko: {{ group.store_name }}
                            </h2>
                            <div class="space-y-4">
                                <div
                                    v-for="item in group.items"
                                    :key="item.id"
                                    class="flex items-start gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0"
                                >
                                    <!-- Product Image -->
                                    <div
                                        class="w-16 h-16 sm:w-20 sm:h-20 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-md flex items-center justify-center overflow-hidden flex-shrink-0 border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                    >
                                        <img
                                            v-if="item.image_url"
                                            :src="item.image_url"
                                            :alt="item.product_name"
                                            class="w-full h-full object-cover"
                                        />
                                        <svg
                                            v-else
                                            class="w-10 h-10 text-gray-400"
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
                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-semibold text-gray-900 dark:text-white mb-1 line-clamp-2"
                                        >
                                            {{ item.product_name }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-500 dark:text-gray-400 mb-2"
                                        >
                                            {{
                                                item.product_description ||
                                                "Tidak ada deskripsi"
                                            }}
                                        </p>
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <span
                                                class="text-sm text-gray-600 dark:text-gray-400"
                                                >Jumlah:
                                                {{ item.qty }} pcs</span
                                            >
                                            <span
                                                class="text-sm font-semibold text-gray-900 dark:text-white"
                                                >Rp.
                                                {{
                                                    formatPrice(
                                                        item.price * item.qty,
                                                    )
                                                }}</span
                                            >
                                        </div>
                                        <p
                                            v-if="
                                                item.stock !== undefined &&
                                                item.qty > item.stock
                                            "
                                            class="mt-2 text-xs text-red-600 dark:text-red-400"
                                        >
                                            Stok tidak mencukupi (stok tersedia:
                                            {{ item.stock }}).
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Ringkasan -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6 lg:sticky lg:top-6"
                    >
                        <h2
                            class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                        >
                            Ringkasan Pesanan
                        </h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400"
                                    >Subtotal</span
                                >
                                <span class="text-[#1D1842] dark:text-[#FDA1A2]"
                                    >Rp. {{ formatPrice(subtotal) }}</span
                                >
                            </div>
                            <div
                                class="border-t border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 pt-3 flex justify-between"
                            >
                                <span
                                    class="font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                                    >Total</span
                                >
                                <span
                                    class="font-bold text-lg text-[#EF3B33] dark:text-[#EF3B33]"
                                    >Rp. {{ formatPrice(totalPrice) }}</span
                                >
                            </div>
                        </div>

                        <button
                            @click="handleConfirmPayment"
                            :disabled="
                                processing ||
                                !shippingAddress.address ||
                                hasInvalid
                            "
                            class="w-full bg-[#EF3B33] disabled:bg-gray-400 text-white font-semibold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg disabled:cursor-not-allowed text-sm sm:text-base"
                        >
                            <span v-if="processing">Memproses...</span>
                            <span v-else>Konfirmasi Pembayaran</span>
                        </button>

                        <p
                            v-if="!shippingAddress.address"
                            class="text-xs text-red-500 dark:text-red-400 mt-2 text-center"
                        >
                            Lengkapi alamat pengiriman terlebih dahulu
                        </p>
                        <p
                            v-if="hasInvalid"
                            class="text-xs text-red-500 dark:text-red-400 mt-2 text-center"
                        >
                            Ada produk yang melebihi stok tersedia.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <transition name="modal">
            <div
                v-if="showPaymentModal"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
            >
                <div
                    class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                >
                    <h3
                        class="text-xl font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                    >
                        Penyelesaian Pembayaran
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        Silakan selesaikan pembayaran untuk setiap toko.
                    </p>

                    <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6 max-h-[50vh] sm:max-h-[60vh] overflow-y-auto">
                        <div
                            v-for="(t, index) in paymentTransactions"
                            :key="index"
                            class="border border-gray-200 dark:border-gray-700 rounded-lg p-4"
                            :class="{
                                'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50':
                                    currentPaymentIndex === index
                            }"
                        >
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p
                                        class="font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                                    >
                                        {{ t.seller_name || "Toko" }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ t.transaction?.order_id }}
                                    </p>
                                </div>
                                <span class="font-bold text-[#EF3B33]"
                                    >Rp {{ formatPrice(t.total) }}</span
                                >
                            </div>

                            <div class="flex justify-between items-center mt-3">
                                <span
                                    class="text-xs px-2 py-1 rounded-full"
                                    :class="{
                                        'bg-green-100 text-green-800':
                                            t.status === 'success' ||
                                            t.status === 'settlement',
                                        'bg-yellow-100 text-yellow-800':
                                            t.status === 'pending',
                                        'bg-red-100 text-red-800':
                                            t.status === 'failed',
                                        'bg-gray-100 text-gray-800': !t.status,
                                    }"
                                >
                                    {{ getStatusLabel(t.status) }}
                                </span>

                                <button
                                    v-if="
                                        t.status !== 'success' &&
                                        t.status !== 'settlement'
                                    "
                                    @click="processPayment(index)"
                                    class="px-3 py-1.5 bg-[#EF3B33] text-white text-sm rounded-md shadow-sm hover:bg-[#D12B24] transition-colors"
                                >
                                    Bayar Sekarang
                                </button>
                                <span
                                    v-else
                                    class="text-green-600 text-sm font-medium flex items-center"
                                >
                                    <svg
                                        class="w-4 h-4 mr-1"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7"
                                        ></path>
                                    </svg>
                                    Berhasil
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button
                            v-if="allPaymentsCompleted"
                            @click="finishPaymentProcess"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-lg font-semibold shadow-lg hover:bg-green-700"
                        >
                            Selesai & Lihat Pesanan
                        </button>
                        <button
                            v-else
                            @click="finishPaymentProcess"
                            class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600"
                        >
                            Tutup & Cek Pesanan Saya
                        </button>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Address Modal -->
        <transition name="modal">
            <div
                v-if="showAddressModal"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                @click.self="showAddressModal = false"
            >
                <div
                    class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                >
                    <h3
                        class="text-xl font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                    >
                        Ubah Alamat Pengiriman
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                >Nama Penerima</label
                            >
                            <input
                                v-model="shippingAddress.name"
                                type="text"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                >No. Telepon</label
                            >
                            <input
                                v-model="shippingAddress.phone"
                                type="text"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                >Alamat Lengkap</label
                            >
                            <textarea
                                v-model="shippingAddress.address"
                                rows="3"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                            ></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button
                                @click="showAddressModal = false"
                                class="flex-1 px-4 py-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg font-medium"
                            >
                                Batal
                            </button>
                            <button
                                @click="saveAddress"
                                class="flex-1 px-4 py-2 bg-[#EF3B33] text-white rounded-lg font-semibold shadow-lg"
                            >
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const loading = ref(true);
const processing = ref(false);
const checkoutItems = ref([]);
const user = ref(null);
const shippingAddress = ref({
    name: "",
    phone: "",
    address: "",
});
const showAddressModal = ref(false);

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const goBack = () => {
    window.location.href = "/cart";
};

const subtotal = computed(() => {
    return checkoutItems.value.reduce(
        (sum, item) => sum + item.price * item.qty,
        0,
    );
});

const shippingCost = computed(() => 0);

const totalPrice = computed(() => subtotal.value);

const hasInvalid = computed(() => {
    return checkoutItems.value.some(
        (item) => item.stock !== undefined && item.qty > item.stock,
    );
});

const groupedByStore = computed(() => {
    const groups = {};
    for (const item of checkoutItems.value) {
        const key = item.store_name || "Toko";
        if (!groups[key]) groups[key] = [];
        groups[key].push(item);
    }
    return Object.keys(groups).map((store) => ({
        store_name: store,
        items: groups[store],
    }));
});

const fetchCheckoutItems = async () => {
    try {
        loading.value = true;

        // Ambil item dari URL params atau localStorage
        const urlParams = new URLSearchParams(window.location.search);
        const itemIds = urlParams.get("items")?.split(",") || [];

        if (itemIds.length === 0) {
            // Jika tidak ada di URL, ambil dari localStorage (fallback)
            const savedItems = localStorage.getItem("checkout_items");
            if (savedItems) {
                checkoutItems.value = JSON.parse(savedItems);
                loading.value = false;
                return;
            }
            // Jika tidak ada, redirect ke cart
            window.location.href = "/cart";
            return;
        }

        // Ambil cart items dari API
        const response = await axios.get("/api/cart");
        const allItems = response.data.items || [];

        // Filter hanya item yang dipilih
        const selectedItems = allItems.filter((item) =>
            itemIds.includes(item.id.toString()),
        );

        // Map ke format checkout
        checkoutItems.value = selectedItems.map((item) => ({
            id: item.id,
            product_id: item.product_id,
            product_name: item.product?.name || "Produk",
            product_description: item.product?.description || "",
            price: item.product?.price || item.price || 0,
            qty: item.qty || item.quantity || 0,
            stock: item.product?.stock ?? 0,
            store_name: item.store_name || item.product?.user?.name || "Toko",
            image_url: item.product?.image_url || null,
        }));

        // Simpan ke localStorage sebagai backup
        localStorage.setItem(
            "checkout_items",
            JSON.stringify(checkoutItems.value),
        );
    } catch (error) {
        console.error("Error fetching checkout items:", error);
        alert("Gagal memuat data checkout");
        window.location.href = "/cart";
    } finally {
        loading.value = false;
    }
};

const fetchUserProfile = async () => {
    try {
        const response = await axios.get("/api/user");
        user.value = response.data;

        // Set shipping address dari profile
        shippingAddress.value = {
            name: response.data.name || "",
            phone: response.data.phone || "",
            address: response.data.address || "",
        };
    } catch (error) {
        console.error("Error fetching user profile:", error);
    }
};

const saveAddress = () => {
    showAddressModal.value = false;
    // Bisa juga simpan ke backend jika perlu
};

const paymentTransactions = ref([]);
const showPaymentModal = ref(false);
const currentPaymentIndex = ref(0);

const allPaymentsCompleted = computed(() => {
    return paymentTransactions.value.every(
        (t) => t.status === "success" || t.status === "settlement",
    );
});

const getStatusLabel = (status) => {
    switch (status) {
        case "success":
            return "Berhasil";
        case "settlement":
            return "Berhasil";
        case "pending":
            return "Menunggu Pembayaran";
        case "failed":
            return "Gagal";
        default:
            return "Belum Dibayar";
    }
};

const ensureMidtransLoaded = (callback) => {
    if (window.snap) {
        callback();
        return;
    }
    const script = document.createElement("script");
    script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
    script.setAttribute("data-client-key", "Mid-client-t4gCXBa6b1_ar6Ji");
    script.onload = () => callback();
    document.head.appendChild(script);
};

const handleConfirmPayment = async () => {
    if (!shippingAddress.value.address) {
        alert("Lengkapi alamat pengiriman terlebih dahulu");
        return;
    }

    if (checkoutItems.value.length === 0) {
        alert("Tidak ada produk yang dipilih");
        return;
    }

    if (hasInvalid.value) {
        alert(
            "Ada produk yang melebihi stok tersedia. Kurangi jumlah sebelum melanjutkan.",
        );
        return;
    }

    try {
        processing.value = true;

        // Siapkan data checkout dengan cart_item_ids yang dipilih
        const checkoutData = {
            shipping_address: shippingAddress.value,
            cart_item_ids: checkoutItems.value.map((item) => item.id), // Kirim ID item yang dipilih
        };

        const response = await axios.post("/api/checkout", checkoutData);
        if (
            response.data &&
            Array.isArray(response.data.transactions) &&
            response.data.transactions.length > 0
        ) {
            localStorage.removeItem("checkout_items");
            checkoutItems.value = []; // Clear items to prevent double checkout

            paymentTransactions.value = response.data.transactions.map((t) => ({
                ...t,
                status: null, // pending, success, failed
            }));

            showPaymentModal.value = true;
            currentPaymentIndex.value = 0;

            // Do not auto start payment
             // processPayment(0);
        }
    } catch (error) {
        console.error("Error during checkout:", error);
        console.error("Error response:", error.response);

        let message = "Gagal melakukan checkout";

        if (error.response) {
            message =
                error.response.data?.message ||
                error.response.data?.error ||
                message;
        } else if (error.request) {
            message =
                "Tidak ada response dari server. Pastikan server berjalan dan database terkoneksi.";
        } else {
            message = error.message || message;
        }

        alert(message);
    } finally {
        processing.value = false;
    }
};

const processPayment = (index) => {
    if (index >= paymentTransactions.value.length) return;

    currentPaymentIndex.value = index;
    const t = paymentTransactions.value[index];

    ensureMidtransLoaded(() => {
        window.snap.pay(t.snap_token, {
            onSuccess: function (result) {
                console.log("Payment success:", result);
                updateTransactionStatus(index, "success");
            },
            onPending: function (result) {
                console.log("Payment pending:", result);
                updateTransactionStatus(index, "pending");
            },
            onError: function (result) {
                console.error("Payment error:", result);
                updateTransactionStatus(index, "failed");
            },
            onClose: function () {
                console.log("Payment modal closed");
                // Do not auto-advance if closed, let user click again or close modal
            },
        });
    });
};

const updateTransactionStatus = (index, status) => {
    if (paymentTransactions.value[index]) {
        paymentTransactions.value[index].status = status;

        // Auto move to next item but DO NOT trigger popup automatically
        if (
            status === "success" ||
            status === "settlement" ||
            status === "pending"
        ) {
            if (index + 1 < paymentTransactions.value.length) {
                currentPaymentIndex.value = index + 1;
            } 
            // else {
            //     // All done logic is handled by "Selesai" button
            // }
        }
    }
};

const finishPaymentProcess = () => {
    const transactionIds = paymentTransactions.value
        .map(t => t.transaction?.id)
        .filter(id => id);
    
    if (transactionIds.length > 0) {
        window.location.href = `/order-confirmation?transaction_ids=${transactionIds.join(',')}`;
    } else {
        const lastId =
            paymentTransactions.value[paymentTransactions.value.length - 1]
                ?.transaction?.id;
        if (lastId) {
            window.location.href = `/order-confirmation?transaction_id=${lastId}`;
        } else {
            window.location.href = `/orders`;
        }
    }
};
onMounted(async () => {
    await fetchUserProfile();
    await fetchCheckoutItems();
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
