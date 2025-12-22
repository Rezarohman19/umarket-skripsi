<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 py-12 px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Pesanan Berhasil!
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Terima kasih telah berbelanja di U-Market
                </p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Detail Pesanan</h2>
                
                <div class="space-y-4">
                    <!-- Order ID -->
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">ID Pesanan</span>
                        <span class="font-semibold text-gray-900 dark:text-white">#{{ orderId || 'ORDER-' + transactionId }}</span>
                    </div>

                    <!-- Transaction ID -->
                    <div v-if="transactionId" class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">ID Transaksi</span>
                        <span class="font-semibold text-gray-900 dark:text-white">#{{ transactionId }}</span>
                    </div>

                    <!-- Order Date -->
                    <div class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Tanggal Pesanan</span>
                        <span class="text-gray-900 dark:text-white">{{ orderDate }}</span>
                    </div>

                    <!-- Payment Method -->
                    <div v-if="paymentMethod" class="flex justify-between items-center pb-4 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran</span>
                        <span class="text-gray-900 dark:text-white">{{ getPaymentMethodLabel(paymentMethod) }}</span>
                    </div>

                    <!-- Total Price -->
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">Rp. {{ formatPrice(totalPrice) }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div v-if="orderItems && orderItems.length > 0" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Produk yang Dipesan</h2>
                
                <div class="space-y-4">
                    <div
                        v-for="(item, index) in orderItems"
                        :key="index"
                        class="flex items-start gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0"
                    >
                        <!-- Product Image -->
                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-md flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img
                                v-if="item.image_url"
                                :src="item.image_url"
                                :alt="item.product_name"
                                class="w-full h-full object-cover"
                            />
                            <svg v-else class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">{{ item.store_name || 'Toko' }}</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ item.product_name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ item.product_description || '' }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Jumlah: {{ item.qty }} pcs</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Rp. {{ formatPrice(item.price * item.qty) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div v-if="shippingAddress" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Alamat Pengiriman</h2>
                <div class="space-y-2">
                    <p class="text-gray-900 dark:text-white font-medium">{{ shippingAddress.name }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ shippingAddress.phone }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ shippingAddress.address }}</p>
                </div>
            </div>

            <!-- Payment Status -->
            <div v-if="paymentStatus" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Status Pembayaran</h2>
                <div class="flex items-center gap-3 mb-4">
                    <span :class="[
                        'px-4 py-2 rounded-full text-sm font-medium',
                        paymentStatus === 'paid' || paymentStatus === 'settlement'
                            ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300'
                            : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300'
                    ]">
                        {{ getPaymentStatusLabel(paymentStatus) }}
                    </span>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ paymentStatus === 'paid' || paymentStatus === 'settlement' 
                            ? 'Pembayaran Anda telah diterima. Pesanan sedang diproses.' 
                            : 'Menunggu konfirmasi pembayaran.' }}
                    </p>
                </div>
                
                <!-- Payment Button (for pending status) -->
                <button
                    v-if="paymentStatus === 'pending' && snapToken"
                    @click="handlePaymentClick"
                    :disabled="isProcessingPayment"
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98] disabled:cursor-not-allowed"
                >
                    <span v-if="isProcessingPayment">Memproses...</span>
                    <span v-else>Lanjutkan Pembayaran</span>
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button
                    @click="goToOrders"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]"
                >
                    Lihat Pesanan Saya
                </button>
                <button
                    @click="goToHome"
                    class="flex-1 bg-gray-200 dark:bg-gray-800 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200"
                >
                    Kembali ke Beranda
                </button>
            </div>

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-800 dark:text-blue-300">
                        <p class="font-semibold mb-1">Informasi Penting</p>
                        <p>Pesanan Anda akan diproses setelah pembayaran dikonfirmasi. Anda akan menerima notifikasi melalui email atau WhatsApp ketika pesanan dikirim.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const orderId = ref('');
const transactionId = ref('');
const orderDate = ref('');
const totalPrice = ref(0);
const paymentMethod = ref('');
const paymentStatus = ref('pending');
const orderItems = ref([]);
const shippingAddress = ref(null);
const snapToken = ref('');
const isProcessingPayment = ref(false);

const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);

const getPaymentMethodLabel = (method) => {
    const methodMap = {
        'bank_transfer': 'Transfer Bank',
        'e_wallet': 'E-Wallet',
        'cod': 'Bayar di Tempat',
        'midtrans': 'Midtrans Payment'
    };
    return methodMap[method] || method;
};

const getPaymentStatusLabel = (status) => {
    const statusMap = {
        'paid': 'Sudah Dibayar',
        'settlement': 'Sudah Dibayar',
        'pending': 'Menunggu Pembayaran',
        'unpaid': 'Belum Dibayar',
        'failed': 'Gagal'
    };
    return statusMap[status] || status;
};

const goToOrders = () => {
    window.location.href = '/orders';
};

const goToHome = () => {
    window.location.href = '/';
};

const handlePaymentClick = () => {
    if (snapToken.value && window.snap) {
        isProcessingPayment.value = true;
        window.snap.pay(snapToken.value, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                // Refresh payment status after 2 seconds
                setTimeout(() => {
                    isProcessingPayment.value = false;
                    fetchOrderData();
                }, 2000);
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                isProcessingPayment.value = false;
            },
            onError: function(result) {
                console.error('Payment error:', result);
                isProcessingPayment.value = false;
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                console.log('Payment modal closed');
                isProcessingPayment.value = false;
            }
        });
    } else {
        alert('Snap payment gateway tidak tersedia');
    }
};

const fetchOrderData = async () => {
    try {
        // Ambil data dari URL params
        const urlParams = new URLSearchParams(window.location.search);
        const transactionIdParam = urlParams.get('transaction_id') || urlParams.get('id');
        
        if (transactionIdParam) {
            transactionId.value = transactionIdParam;
            
            // Fetch detail transaksi dari API
            try {
                const response = await axios.get(`/api/transactions`);
                const transactions = response.data || [];
                const transaction = transactions.find(t => t.id == transactionIdParam);
                
                if (transaction) {
                    orderId.value = `ORDER-${transaction.id}`;
                    totalPrice.value = transaction.total_price || 0;
                    paymentStatus.value = transaction.status || 'pending';
                    paymentMethod.value = transaction.payment_method || 'midtrans';
                    snapToken.value = transaction.snap_token || '';
                    
                    // Format tanggal
                    if (transaction.created_at) {
                        const date = new Date(transaction.created_at);
                        orderDate.value = date.toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                    
                    // Map items
                    if (transaction.items && transaction.items.length > 0) {
                        orderItems.value = transaction.items.map(item => ({
                            product_name: item.product?.name || 'Produk',
                            product_description: item.product?.description || '',
                            qty: item.qty || 1,
                            price: item.price || item.product?.price || 0,
                            image_url: item.product?.image_url || null,
                            store_name: item.product?.user?.name || 'Toko'
                        }));
                    }
                    
                    // Shipping address dari transaction
                    if (transaction.shipping_address) {
                        shippingAddress.value = typeof transaction.shipping_address === 'string' 
                            ? JSON.parse(transaction.shipping_address)
                            : transaction.shipping_address;
                    } else if (transaction.shipping_name) {
                        shippingAddress.value = {
                            name: transaction.shipping_name,
                            phone: transaction.shipping_phone || '',
                            address: transaction.shipping_address || ''
                        };
                    }
                }
            } catch (error) {
                console.error('Error fetching transaction details:', error);
            }
        } else {
            // Jika tidak ada transaction_id, ambil dari localStorage (fallback)
            const savedData = localStorage.getItem('order_confirmation');
            if (savedData) {
                const data = JSON.parse(savedData);
                orderId.value = data.orderId || '';
                transactionId.value = data.transactionId || '';
                totalPrice.value = data.totalPrice || 0;
                paymentMethod.value = data.paymentMethod || '';
                paymentStatus.value = data.paymentStatus || 'pending';
                orderItems.value = data.orderItems || [];
                shippingAddress.value = data.shippingAddress || null;
                orderDate.value = data.orderDate || new Date().toLocaleDateString('id-ID');
                snapToken.value = data.snapToken || '';
                
                // Clear localStorage setelah digunakan
                localStorage.removeItem('order_confirmation');
            }
        }
    } catch (error) {
        console.error('Error fetching order data:', error);
    }
};

onMounted(() => {
    // Load Midtrans Snap SDK
    const script = document.createElement('script');
    script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
    script.setAttribute('data-client-key', 'Mid-client-t4gCXBa6b1_ar6Ji');
    document.head.appendChild(script);
    
    fetchOrderData();
});
</script>

<style scoped>
/* Additional styles if needed */
</style>
