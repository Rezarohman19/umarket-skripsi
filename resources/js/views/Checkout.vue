<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] pb-24">
        <div class="max-w-6xl mx-auto py-6 px-4 sm:px-6">
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

            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Alamat Pengiriman -->
                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6"
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
                            class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6"
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
                                        class="w-20 h-20 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-md flex items-center justify-center overflow-hidden flex-shrink-0 border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
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
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6 sticky top-6"
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
                            class="w-full bg-[#EF3B33] disabled:bg-gray-400 text-white font-semibold py-3 px-6 rounded-lg shadow-lg disabled:cursor-not-allowed"
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

        <!-- Address Modal -->
        <transition name="modal">
            <div
                v-if="showAddressModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
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

const loadMidtransAndRedirect = (snapToken, transactionId) => {
    // Cek apakah Midtrans Snap SDK sudah dimuat
    if (window.snap) {
        // Langsung redirect ke Midtrans
        window.snap.pay(snapToken, {
            onSuccess: function (result) {
                console.log("Payment success:", result);
                // Redirect ke order confirmation setelah pembayaran berhasil
                window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
            },
            onPending: function (result) {
                console.log("Payment pending:", result);
                // Redirect ke order confirmation untuk menunggu konfirmasi
                window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
            },
            onError: function (result) {
                console.error("Payment error:", result);
                alert("Pembayaran gagal. Silakan coba lagi.");
                // Tetap redirect ke order confirmation untuk melihat detail pesanan
                window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
            },
            onClose: function () {
                console.log("Payment modal closed");
                // User menutup halaman pembayaran, redirect ke order confirmation
                window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
            },
        });
    } else {
        // Load Midtrans Snap SDK terlebih dahulu
        const script = document.createElement("script");
        script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
        script.setAttribute("data-client-key", "Mid-client-t4gCXBa6b1_ar6Ji");
        script.onload = () => {
            // Setelah SDK dimuat, redirect ke Midtrans
            if (window.snap) {
                window.snap.pay(snapToken, {
                    onSuccess: function (result) {
                        console.log("Payment success:", result);
                        window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
                    },
                    onPending: function (result) {
                        console.log("Payment pending:", result);
                        window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
                    },
                    onError: function (result) {
                        console.error("Payment error:", result);
                        alert("Pembayaran gagal. Silakan coba lagi.");
                        window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
                    },
                    onClose: function () {
                        console.log("Payment modal closed");
                        window.location.href = `/order-confirmation?transaction_id=${transactionId}`;
                    },
                });
            }
        };
        document.head.appendChild(script);
    }
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

        // Panggil API checkout
        const response = await axios.post("/api/checkout", checkoutData);

        // Jika server mengembalikan banyak transaksi (per penjual), proses secara berurutan
        if (
            response.data &&
            Array.isArray(response.data.transactions) &&
            response.data.transactions.length > 0
        ) {
            localStorage.removeItem("checkout_items");
            await payTransactionsSequentially(response.data.transactions);
            return;
        }
    } catch (error) {
        console.error("Error during checkout:", error);
        console.error("Error response:", error.response);

        let message = "Gagal melakukan checkout";

        if (error.response) {
            // Ada response dari server
            message =
                error.response.data?.message ||
                error.response.data?.error ||
                message;

            // Tampilkan error detail untuk debugging
            if (error.response.data?.error) {
                console.error("Error detail:", error.response.data.error);
            }
        } else if (error.request) {
            // Request dikirim tapi tidak ada response
            message =
                "Tidak ada response dari server. Pastikan server berjalan dan database terkoneksi.";
        } else {
            // Error saat setup request
            message = error.message || message;
        }

        alert(message);
    } finally {
        processing.value = false;
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

const payTransactionsSequentially = async (transactions) => {
    const process = (index) => {
        if (index >= transactions.length) {
            const lastId =
                transactions[transactions.length - 1]?.transaction?.id;
            if (lastId) {
                window.location.href = `/order-confirmation?transaction_id=${lastId}`;
            } else {
                window.location.href = `/order-confirmation`;
            }
            return;
        }
        const t = transactions[index];
        const transactionId = t.transaction?.id;

        // Simpan data konfirmasi untuk transaksi ini
        const confirmationData = {
            transactionId: transactionId,
            orderId: t.transaction?.order_id || `ORDER-${transactionId}`,
            totalPrice: t.total,
            paymentMethod: "midtrans",
            paymentStatus: t.transaction?.status || "pending",
            orderItems: Array.isArray(t.items) ? t.items : checkoutItems.value,
            shippingAddress: shippingAddress.value,
            snapToken: t.snap_token,
            orderDate: new Date().toLocaleDateString("id-ID", {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            }),
        };
        localStorage.setItem(
            "order_confirmation",
            JSON.stringify(confirmationData),
        );

        ensureMidtransLoaded(() => {
            window.snap.pay(t.snap_token, {
                onSuccess: function (result) {
                    process(index + 1);
                },
                onPending: function (result) {
                    process(index + 1);
                },
                onError: function (result) {
                    alert(
                        "Pembayaran gagal untuk salah satu toko. Anda dapat mencoba lagi dari halaman pesanan.",
                    );
                    process(index + 1);
                },
                onClose: function () {
                    process(index + 1);
                },
            });
        });
    };
    process(0);
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
