<template>
    <div class="min-h-screen bg-[#FDA1A2]/20 dark:bg-[#1D1842] py-12 px-4">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-[#1D1842] dark:text-[#FDA1A2] mb-2">
                    Pesanan Berhasil!
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Terima kasih telah berbelanja di U-Market
                </p>
            </div>

            <div v-if="loading" class="text-center py-12">
                <p class="text-[#1D1842] dark:text-[#FDA1A2]">Memuat detail pesanan...</p>
            </div>

            <div v-else-if="confirmedOrders.length > 0">
                <div v-for="(order, index) in confirmedOrders" :key="order.id" class="mb-8 bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-lg overflow-hidden">
                    <div class="bg-[#FDA1A2]/10 dark:bg-[#8E0D3C]/10 px-6 py-4 border-b border-[#FDA1A2]/20 dark:border-[#8E0D3C]/30 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="bg-white dark:bg-[#1D1842] p-2 rounded-full shadow-sm">
                                <svg class="w-5 h-5 text-[#EF3B33] dark:text-[#FDA1A2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-[#1D1842] dark:text-[#FDA1A2]">
                                    {{ order.storeName }}
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Order ID: #{{ order.orderId }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span :class="[
                                'px-3 py-1 rounded-full text-xs font-medium',
                                order.status === 'paid' || order.status === 'settlement' || order.status === 'shipping' || order.status === 'completed'
                                    ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300'
                                    : 'bg-[#FDA1A2]/30 dark:bg-[#EF3B33]/20 text-[#8E0D3C] dark:text-[#FDA1A2]',
                            ]">
                                {{ getPaymentStatusLabel(order.status) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Tanggal</span>
                                    <span class="font-medium text-[#1D1842] dark:text-[#FDA1A2]">{{ order.date }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Metode Bayar</span>
                                    <span class="font-medium text-[#1D1842] dark:text-[#FDA1A2]">{{ getPaymentMethodLabel(order.paymentMethod) }}</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm" v-if="order.shippingAddress">
                                    <span class="text-gray-600 dark:text-gray-400">Penerima</span>
                                    <span class="font-medium text-[#1D1842] dark:text-[#FDA1A2] text-right truncate ml-4">{{ order.shippingAddress.name }}</span>
                                </div>
                                <div class="flex justify-between text-sm border-t border-[#FDA1A2]/20 dark:border-[#8E0D3C]/30 pt-2 mt-2">
                                    <span class="font-bold text-[#1D1842] dark:text-[#FDA1A2]">Total</span>
                                    <span class="font-bold text-[#EF3B33] text-lg">Rp. {{ formatPrice(order.totalPrice) }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider">Produk</h3>
                            <div class="space-y-4">
                                <div
                                    v-for="(item, idx) in order.items"
                                    :key="idx"
                                    class="flex items-start gap-4 pb-4 border-b border-[#FDA1A2]/20 dark:border-[#8E0D3C]/30 last:border-0 last:pb-0"
                                >
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0 border border-gray-200 dark:border-gray-700">
                                        <img
                                            v-if="item.image_url"
                                            :src="item.image_url"
                                            :alt="item.product_name"
                                            class="w-full h-full object-cover"
                                        />
                                        <svg v-else class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-1 line-clamp-1">{{ item.product_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 line-clamp-1">{{ item.product_description }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded">{{ item.qty }} pcs</span>
                                            <span class="text-sm font-medium text-[#EF3B33]">Rp. {{ formatPrice(item.price * item.qty) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="order.status === 'pending' && order.snapToken" class="mt-6 pt-4 border-t border-[#FDA1A2]/20 dark:border-[#8E0D3C]/30">
                            <button
                                @click="handlePaymentClick(order)"
                                :disabled="isProcessingPayment === order.id"
                                class="w-full bg-[#EF3B33] hover:bg-[#d92f25] disabled:bg-gray-400 text-white font-semibold py-2.5 px-4 rounded-lg shadow transition-colors flex justify-center items-center gap-2"
                            >
                                <span v-if="isProcessingPayment === order.id" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                <span v-else>Lanjutkan Pembayaran</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-12 bg-white dark:bg-[#1D1842] rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <p class="text-gray-600 dark:text-gray-400">Data pesanan tidak ditemukan.</p>
                <button @click="goToOrders" class="mt-4 text-[#EF3B33] font-medium hover:underline">Lihat Riwayat Pesanan</button>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <button
                    @click="goToOrders"
                    class="flex-1 bg-[#EF3B33] hover:bg-[#d92f25] text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all"
                >
                    Lihat Semua Pesanan Saya
                </button>
                <button
                    @click="goToHome"
                    class="flex-1 bg-white dark:bg-[#1D1842] text-[#1D1842] dark:text-[#FDA1A2] font-semibold py-3 px-6 rounded-lg border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 hover:bg-[#FDA1A2]/10 dark:hover:bg-[#8E0D3C]/10 transition-all font-medium"
                >
                    Kembali ke Beranda
                </button>
            </div>

            <div class="mt-6 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 rounded-lg p-4 flex gap-3">
                <svg class="w-5 h-5 text-[#EF3B33] dark:text-[#FDA1A2] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">
                    <p class="font-semibold mb-1">Informasi Penting</p>
                    <p>Pesanan Anda telah tercatat. Mohon selesaikan pembayaran agar pesanan segera diproses oleh penjual. Cek email atau WhatsApp untuk notifikasi resi pengiriman.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const loading = ref(true);
const confirmedOrders = ref([]);
const isProcessingPayment = ref(null);
const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);

const getPaymentMethodLabel = (method) => {
    const methodMap = {
        'bank_transfer': 'Transfer Bank',
        'e_wallet': 'E-Wallet',
        'cod': 'Bayar di Tempat',
        'midtrans': 'Midtrans Payment',
    };
    return methodMap[method] || method;
};

const getPaymentStatusLabel = (status) => {
    const statusMap = {
        'paid': 'Sudah Dibayar',
        'settlement': 'Sudah Dibayar',
        'capture': 'Sudah Dibayar',
        'pending': 'Menunggu Pembayaran',
        'unpaid': 'Belum Dibayar',
        'failed': 'Gagal',
        'shipping': 'Dikirim',
        'completed': 'Selesai',
    };
    return statusMap[status] || status;
};

const goToOrders = () => (window.location.href = '/orders');
const goToHome = () => (window.location.href = '/');

const handlePaymentClick = (order) => {
    if (order.snapToken && window.snap) {
        isProcessingPayment.value = order.id;
        window.snap.pay(order.snapToken, {
            onSuccess: function(result) {
                console.log('Payment success:', result);
                setTimeout(() => {
                    isProcessingPayment.value = null;
                    fetchOrderData(); // Refresh data to update status
                }, 2000);
            },
            onPending: function(result) {
                console.log('Payment pending:', result);
                isProcessingPayment.value = null;
                fetchOrderData();
            },
            onError: function(result) {
                console.error('Payment error:', result);
                isProcessingPayment.value = null;
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                console.log('Payment modal closed');
                isProcessingPayment.value = null;
            }
        });
    } else {
        alert('Payment gateway details not available');
    }
};

const fetchOrderData = async () => {
    try {
        loading.value = true;
        const urlParams = new URLSearchParams(window.location.search);
        const idsParam = urlParams.get('transaction_ids');
        const singleIdParam = urlParams.get('transaction_id') || urlParams.get('id');
        let targetIds = [];
        if (idsParam) {
            targetIds = idsParam.split(',').filter(id => id);
        }
        if (singleIdParam && !targetIds.includes(singleIdParam)) {
            targetIds.push(singleIdParam);
        }
        targetIds = [...new Set(targetIds)];

        if (targetIds.length > 0) {
            const response = await axios.get(`/api/transactions`);
            const allTransactions = response.data || [];
            const matchingTransactions = allTransactions.filter(t => targetIds.some(id => id == t.id));
            if (matchingTransactions.length > 0) {
                confirmedOrders.value = matchingTransactions.map(t => {
                    const items = (t.items || []).map(item => ({
                        product_name: item.product?.name || 'Produk',
                        product_description: item.product?.description || '',
                        qty: item.qty || 1,
                        price: item.price || item.product?.price || 0,
                        image_url: item.product?.image_url || null,
                    }));
                    let address = null;
                    if (t.shipping_address) {
                        try {
                            address = typeof t.shipping_address === 'string' ? JSON.parse(t.shipping_address) : t.shipping_address;
                        } catch (e) {
                            address = {
                                address: t.shipping_address,
                                name: t.shipping_name || '',
                                phone: t.shipping_phone || '',
                            };
                        }
                    } else if (t.shipping_name) {
                        address = {
                            name: t.shipping_name,
                            phone: t.shipping_phone || '',
                            address: t.shipping_address || '',
                        };
                    }
                    let storeName = t.store_name || 'Toko';
                    if (!t.store_name && t.items && t.items.length > 0) {
                        storeName = t.items[0].product?.user?.name || 'Toko';
                    }

                    return {
                        id: t.id,
                        orderId: t.order_id || `ORDER-${t.id}`,
                        date: t.created_at
                            ? new Date(t.created_at).toLocaleDateString('id-ID', {
                                  year: 'numeric',
                                  month: 'long',
                                  day: 'numeric',
                                  hour: '2-digit',
                                  minute: '2-digit',
                              })
                            : '',
                        totalPrice: t.total_price || 0,
                        paymentMethod: t.payment_method || 'midtrans',
                        status: t.status || 'pending',
                        snapToken: t.snap_token || '',
                        storeName: storeName,
                        items: items,
                        shippingAddress: address,
                    };
                });
            }
        } else {
            const savedData = localStorage.getItem('order_confirmation');
            if (savedData) {
                const data = JSON.parse(savedData);
                if (data) {
                    confirmedOrders.value = [{
                        id: data.transactionId,
                        orderId: data.orderId,
                        date: data.orderDate,
                        totalPrice: data.totalPrice,
                        paymentMethod: data.paymentMethod,
                        status: data.paymentStatus,
                        snapToken: data.snapToken,
                        storeName: 'Toko',
                        items: data.orderItems || [],
                        shippingAddress: data.shippingAddress,
                     }];
                    if (confirmedOrders.value[0].items.length > 0 && confirmedOrders.value[0].items[0].store_name) confirmedOrders.value[0].storeName = confirmedOrders.value[0].items[0].store_name;
                    localStorage.removeItem('order_confirmation');
                }
            }
        }
    } catch (error) {
        console.error('Error fetching order data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    if (!window.snap) {
        const script = document.createElement('script');
        script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', 'Mid-client-t4gCXBa6b1_ar6Ji');
        document.head.appendChild(script);
    }
    fetchOrderData();
});
</script>
