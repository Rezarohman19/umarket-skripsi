<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] pb-24">
        <div class="max-w-6xl mx-auto py-4 sm:py-6 px-3 sm:px-4 md:px-6">
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
            <h1 class="text-2xl font-bold text-[#1D1842] dark:text-[#FDA1A2] mb-6">
                Checkout
            </h1>
            <div v-if="loading" class="text-center py-12">
                <p class="text-[#1D1842] dark:text-[#FDA1A2]">
                    Memuat data checkout...
                </p>
            </div>
            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6"
                    >
                        <div class="flex items-center justify-between mb-4">
                            <h2
                                class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                            >
                                Alamat Pengiriman
                            </h2>
                            <div class="flex items-center gap-2">
                                <button
                                    @click="showMapPickerModal = true"
                                    class="text-xs bg-[#EF3B33]/10 hover:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#FDA1A2] px-3 py-1.5 rounded-lg font-medium transition-colors flex items-center gap-1"
                                >
                                    <span>📍 Peta</span>
                                </button>
                                <button
                                    @click="showAddressModal = true"
                                    class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 px-2 py-1.5 font-medium transition-colors"
                                >
                                    Ubah Data
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <p class="text-gray-900 dark:text-white font-medium">
                                    {{ shippingAddress.name }}
                                </p>
                                <span class="text-gray-400">•</span>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    {{ shippingAddress.phone }}
                                </p>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                {{
                                    shippingAddress.address ||
                                    "Alamat belum diisi"
                                }}
                            </p>

                            <!-- Destination Pin Highlight -->
                            <div
                                v-if="shippingAddress.lat && shippingAddress.lng"
                                class="mt-3 flex items-center justify-between bg-green-50 dark:bg-green-950/30 border border-green-200/60 dark:border-green-800/40 rounded-xl px-3.5 py-2.5"
                            >
                                <div class="flex items-center gap-2">
                                    <span class="text-green-600 dark:text-green-400 text-sm">📍</span>
                                    <div>
                                        <p class="text-xs font-semibold text-green-700 dark:text-green-300">
                                            Titik Tujuan Terkunci di Peta
                                        </p>
                                        <p class="text-[11px] text-green-600/80 dark:text-green-400/80 font-mono">
                                            GPS: {{ Number(shippingAddress.lat).toFixed(5) }}, {{ Number(shippingAddress.lng).toFixed(5) }}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    @click="showMapPickerModal = true"
                                    class="text-xs text-green-700 dark:text-green-300 font-semibold underline hover:opacity-80"
                                >
                                    Ganti Titik
                                </button>
                            </div>

                            <div
                                v-else
                                class="mt-3 bg-red-50/60 dark:bg-red-950/20 border border-dashed border-[#EF3B33]/40 rounded-xl p-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2"
                            >
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🗺️</span>
                                    <div>
                                        <p class="text-xs font-bold text-[#1D1842] dark:text-[#FDA1A2]">
                                            Tentukan Titik di Peta (ShopeeFood Style)
                                        </p>
                                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                                            Pilih titik maps agar pengiriman ada rute garis biru dan kurir sampai ke tujuan.
                                        </p>
                                    </div>
                                </div>
                                <button
                                    @click="showMapPickerModal = true"
                                    class="w-full sm:w-auto px-3.5 py-2 bg-[#EF3B33] hover:bg-[#d32f2f] text-white text-xs font-bold rounded-lg shadow-sm transition-colors whitespace-nowrap flex items-center justify-center gap-1.5"
                                >
                                    <span>Buka Peta</span>
                                    <span>→</span>
                                </button>
                            </div>
                        </div>
                    </div>
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
                <div class="lg:col-span-1">
                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6 lg:sticky lg:top-6"
                    >
                        <h2
                            class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                        >
                            Ringkasan Pesanan
                        </h2>

                        <!-- Voucher Promo Box -->
                        <div class="mb-5 p-3.5 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/60 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/40 rounded-xl space-y-2.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xl">🎟️</span>
                                    <div>
                                        <p class="text-xs font-bold text-[#1D1842] dark:text-[#FDA1A2]">Voucher Diskon</p>
                                        <p class="text-[11px] text-gray-500">Hemat belanja dengan kupon promo</p>
                                    </div>
                                </div>
                                <button
                                    @click="showVoucherModal = true"
                                    type="button"
                                    class="px-2.5 py-1 bg-[#EF3B33] hover:bg-[#d92f25] text-white text-xs font-semibold rounded-lg shadow-sm transition-all cursor-pointer"
                                >
                                    Pilih Kupon
                                </button>
                            </div>

                            <!-- Applied Voucher Pill -->
                            <div
                                v-if="appliedVoucher"
                                class="p-2.5 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-300 dark:border-emerald-700/50 rounded-lg flex items-center justify-between"
                            >
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-emerald-600 font-bold text-sm">🎉</span>
                                    <div class="truncate">
                                        <p class="text-xs font-mono font-bold text-emerald-800 dark:text-emerald-300 truncate">
                                            {{ appliedVoucher.code }}
                                        </p>
                                        <p class="text-[11px] text-emerald-700 dark:text-emerald-400 font-medium">
                                            Hemat Rp. {{ formatPrice(discountAmount) }}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    @click="removeVoucher"
                                    type="button"
                                    class="text-xs text-red-500 hover:text-red-700 font-bold ml-2 p-1"
                                    title="Hapus voucher"
                                >
                                    ✕
                                </button>
                            </div>

                            <!-- Input Voucher Code (if none applied) -->
                            <div v-else class="flex gap-1.5">
                                <input
                                    v-model="voucherInputCode"
                                    @keyup.enter="applyVoucherByCode"
                                    type="text"
                                    placeholder="Ketik kode promo (cth: UMARKETHEMAT)"
                                    class="flex-1 px-3 py-1.5 text-xs uppercase font-mono bg-white dark:bg-[#1D1842] border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EF3B33]"
                                />
                                <button
                                    @click="applyVoucherByCode"
                                    type="button"
                                    :disabled="applyingVoucher || !voucherInputCode.trim()"
                                    class="px-3 py-1.5 bg-gray-800 dark:bg-gray-700 hover:bg-black text-white text-xs font-semibold rounded-lg disabled:opacity-40 transition-colors cursor-pointer"
                                >
                                    {{ applyingVoucher ? '...' : 'Pakai' }}
                                </button>
                            </div>
                            <p v-if="voucherErrorMessage" class="text-[11px] text-red-500 font-medium">
                                ⚠️ {{ voucherErrorMessage }}
                            </p>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400"
                                    >Subtotal</span
                                >
                                <span class="text-[#1D1842] dark:text-[#FDA1A2]"
                                    >Rp. {{ formatPrice(subtotal) }}</span
                                >
                            </div>
                            <div v-if="appliedVoucher && discountAmount > 0" class="flex justify-between text-sm text-emerald-600 dark:text-emerald-400 font-semibold">
                                <span class="flex items-center gap-1">
                                    <span>🎟️</span>
                                    <span>Diskon Voucher ({{ appliedVoucher.code }})</span>
                                </span>
                                <span>- Rp. {{ formatPrice(discountAmount) }}</span>
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
                            class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 transition-all"
                            :class="{
                                'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border-[#EF3B33]/40':
                                    currentPaymentIndex === index
                            }"
                        >
                            <div class="flex justify-between items-start mb-2">
                                <div class="min-w-0 pr-2">
                                    <p
                                        class="font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                                    >
                                        {{ t.seller_name || "Toko" }}
                                    </p>
                                    <p class="text-xs text-gray-500 font-mono">
                                        {{ t.transaction?.order_id || t.order_id }}
                                    </p>
                                    <!-- Voucher Diskon Pill -->
                                    <span
                                        v-if="t.discount_amount > 0 || t.voucher_code"
                                        class="inline-flex items-center gap-1 mt-1.5 text-[11px] font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 px-2 py-0.5 rounded-md"
                                    >
                                        <span>🎟️ Diskon ({{ t.voucher_code || 'Promo' }}):</span>
                                        <strong>-Rp {{ formatPrice(t.discount_amount) }}</strong>
                                    </span>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p v-if="t.discount_amount > 0" class="text-xs text-gray-400 line-through mb-0.5">
                                        Rp {{ formatPrice(t.subtotal || (Number(t.total) + Number(t.discount_amount))) }}
                                    </p>
                                    <span class="font-bold text-base sm:text-lg text-[#EF3B33]">
                                        Rp {{ formatPrice(t.total) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-100 dark:border-gray-800">
                                <span
                                    class="text-xs px-2.5 py-1 rounded-full font-medium"
                                    :class="{
                                        'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300':
                                            isPaidStatus(t.status),
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300':
                                            t.status === 'pending',
                                        'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300':
                                            t.status === 'failed',
                                        'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300':
                                            !t.status || t.status === 'unpaid',
                                    }"
                                >
                                    {{ getStatusLabel(t.status) }}
                                </span>
                                <button
                                    v-if="!isPaidStatus(t.status)"
                                    @click="processPayment(index)"
                                    class="px-3.5 py-1.5 bg-[#EF3B33] text-white text-xs font-semibold rounded-lg shadow-sm hover:bg-[#D12B24] transition-colors cursor-pointer"
                                >
                                    Bayar Sekarang
                                </button>
                                <span
                                    v-else
                                    class="text-green-600 dark:text-green-400 text-xs font-semibold flex items-center gap-1"
                                >
                                    <svg
                                        class="w-4 h-4 mr-0.5"
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
                                    Pembayaran Selesai
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
                                placeholder="Detail alamat, nama jalan, patokan..."
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                            ></textarea>
                        </div>
                        <div>
                            <button
                                @click="showMapPickerModal = true"
                                type="button"
                                class="w-full py-2.5 px-3 bg-red-50 dark:bg-red-950/40 border border-[#EF3B33]/30 rounded-xl text-xs font-bold text-[#EF3B33] dark:text-[#FDA1A2] hover:bg-red-100 flex items-center justify-center gap-2 transition-colors"
                            >
                                <span>🗺️</span>
                                <span>{{ (shippingAddress.lat && shippingAddress.lng) ? 'Ubah Titik Lokasi di Peta' : 'Pilih Titik Lokasi di Peta (ShopeeFood Style)' }}</span>
                            </button>
                            <p v-if="shippingAddress.lat && shippingAddress.lng" class="text-[11px] text-green-600 dark:text-green-400 mt-1 text-center font-mono">
                                ✓ Koordinat: {{ Number(shippingAddress.lat).toFixed(5) }}, {{ Number(shippingAddress.lng).toFixed(5) }}
                            </p>
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

        <!-- Modal Pilih Voucher Diskon -->
        <transition name="modal">
            <div
                v-if="showVoucherModal"
                class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                @click.self="showVoucherModal = false"
            >
                <div class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-lg w-full p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 relative max-h-[85vh] flex flex-col">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">🎟️</span>
                            <div>
                                <h3 class="text-base sm:text-lg font-bold text-[#1D1842] dark:text-[#FDA1A2]">Pilih Voucher Diskon</h3>
                                <p class="text-xs text-gray-500">Pilih kupon promo terbaik untuk pesanan kamu</p>
                            </div>
                        </div>
                        <button
                            @click="showVoucherModal = false"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-1.5 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer"
                        >
                            ✕
                        </button>
                    </div>

                    <!-- Voucher List Scrollable -->
                    <div class="my-4 space-y-3 overflow-y-auto flex-1 pr-1">
                        <div
                            v-for="v in availableVouchers"
                            :key="v.id"
                            class="relative p-4 rounded-xl border transition-all"
                            :class="[
                                appliedVoucher?.code === v.code
                                    ? 'bg-emerald-50/70 dark:bg-emerald-950/30 border-emerald-400 dark:border-emerald-600 shadow-sm'
                                    : (getVoucherEligibleSubtotal(v) >= v.min_purchase && (!v.seller_id || getVoucherEligibleSubtotal(v) > 0)
                                        ? 'bg-gradient-to-r from-red-50/40 via-white to-orange-50/40 dark:from-[#8E0D3C]/10 dark:to-transparent border-red-200 dark:border-[#8E0D3C]/40 hover:border-[#EF3B33]'
                                        : 'bg-gray-50 dark:bg-gray-900/30 border-gray-200 dark:border-gray-800 opacity-60')
                            ]"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div class="space-y-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="px-2 py-0.5 font-mono font-bold text-xs bg-[#EF3B33] text-white rounded">
                                            {{ v.code }}
                                        </span>
                                        <span class="text-xs font-semibold text-gray-900 dark:text-white truncate">
                                            {{ v.name }}
                                        </span>
                                        <span v-if="v.seller_id" class="px-2 py-0.5 text-[10px] font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 rounded-full border border-amber-300">
                                            🏪 {{ v.store_name }}
                                        </span>
                                        <span v-else class="px-2 py-0.5 text-[10px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 rounded-full border border-blue-300">
                                            🌐 Promo U-Market
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                                        {{ v.description || (v.type === 'percentage' ? `Diskon ${parseFloat(v.value)}%` : `Potongan Rp. ${formatPrice(v.value)}`) }}
                                    </p>
                                    <div class="flex items-center gap-2 text-[11px] text-gray-500 dark:text-gray-400 pt-1 flex-wrap">
                                        <span>Min. Belanja: Rp. {{ formatPrice(v.min_purchase) }}</span>
                                        <span v-if="v.max_discount">• Maks. Potongan: Rp. {{ formatPrice(v.max_discount) }}</span>
                                    </div>
                                </div>
                                <button
                                    v-if="appliedVoucher?.code === v.code"
                                    @click="removeVoucher"
                                    type="button"
                                    class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-bold shadow-sm cursor-pointer whitespace-nowrap"
                                >
                                    ✓ Digunakan
                                </button>
                                <button
                                    v-else
                                    @click="selectVoucher(v)"
                                    type="button"
                                    :disabled="getVoucherEligibleSubtotal(v) < v.min_purchase || (v.seller_id && getVoucherEligibleSubtotal(v) === 0)"
                                    class="px-3 py-1.5 bg-[#EF3B33] hover:bg-[#d92f25] disabled:bg-gray-300 dark:disabled:bg-gray-700 text-white rounded-lg text-xs font-bold shadow-sm transition-all cursor-pointer disabled:cursor-not-allowed whitespace-nowrap"
                                >
                                    {{ v.seller_id && getVoucherEligibleSubtotal(v) === 0 ? 'Bukan Toko Ini' : (getVoucherEligibleSubtotal(v) < v.min_purchase ? 'Belum Cukup' : 'Gunakan') }}
                                </button>
                            </div>
                        </div>

                        <div v-if="availableVouchers.length === 0" class="text-center py-8 text-gray-500 text-xs">
                            Sedang memuat voucher atau belum ada voucher aktif saat ini.
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Address Map Picker Modal (ShopeeFood Destination Picker) -->
        <AddressMapPicker
            v-if="showMapPickerModal"
            :initial-address="shippingAddress.address"
            :initial-lat="shippingAddress.lat"
            :initial-lng="shippingAddress.lng"
            @confirm="onLocationConfirmed"
            @close="showMapPickerModal = false"
        />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import AddressMapPicker from "../components/AddressMapPicker.vue";

const loading = ref(true);
const processing = ref(false);
const checkoutItems = ref([]);
const user = ref(null);
const showMapPickerModal = ref(false);
const shippingAddress = ref({
    name: "",
    phone: "",
    address: "",
    lat: null,
    lng: null,
    destination_lat: null,
    destination_lng: null,
});
const showAddressModal = ref(false);

const onLocationConfirmed = (loc) => {
    shippingAddress.value.address = loc.address;
    shippingAddress.value.lat = loc.lat;
    shippingAddress.value.lng = loc.lng;
    shippingAddress.value.destination_lat = loc.lat;
    shippingAddress.value.destination_lng = loc.lng;
    showMapPickerModal.value = false;
    showAddressModal.value = false;
};
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
const availableVouchers = ref([]);
const showVoucherModal = ref(false);
const voucherInputCode = ref("");
const appliedVoucher = ref(null);
const applyingVoucher = ref(false);
const voucherErrorMessage = ref("");

const fetchVouchers = async () => {
    try {
        const response = await axios.get("/api/vouchers");
        availableVouchers.value = response.data || [];
    } catch (err) {
        console.error("Error fetching vouchers:", err);
    }
};

const getVoucherEligibleSubtotal = (v) => {
    if (!v) return 0;
    if (!v.seller_id) return subtotal.value;
    return checkoutItems.value
        .filter((item) => item.seller_id == v.seller_id)
        .reduce((sum, item) => sum + item.price * item.qty, 0);
};

const discountAmount = computed(() => {
    if (!appliedVoucher.value) return 0;
    const v = appliedVoucher.value;
    const eligibleSubtotal = getVoucherEligibleSubtotal(v);
    if (eligibleSubtotal < (v.min_purchase || 0)) return 0;
    if (v.type === 'percentage') {
        let disc = eligibleSubtotal * (parseFloat(v.value) / 100);
        if (v.max_discount) {
            disc = Math.min(disc, parseFloat(v.max_discount));
        }
        return Math.round(disc);
    }
    return Math.min(parseFloat(v.value), eligibleSubtotal);
});

const totalPrice = computed(() => Math.max(0, subtotal.value - discountAmount.value));

const selectVoucher = (v) => {
    const eligibleSubtotal = getVoucherEligibleSubtotal(v);
    if (v.seller_id && eligibleSubtotal <= 0) {
        voucherErrorMessage.value = `Voucher ini khusus untuk produk dari toko "${v.store_name}"`;
        return;
    }
    if (eligibleSubtotal < (v.min_purchase || 0)) {
        voucherErrorMessage.value = `Minimal belanja Rp ${formatPrice(v.min_purchase)} untuk voucher ini`;
        return;
    }
    appliedVoucher.value = v;
    voucherErrorMessage.value = "";
    showVoucherModal.value = false;
};

const removeVoucher = () => {
    appliedVoucher.value = null;
    voucherInputCode.value = "";
    voucherErrorMessage.value = "";
};

const applyVoucherByCode = async () => {
    const code = voucherInputCode.value.trim().toUpperCase();
    if (!code) return;

    try {
        applyingVoucher.value = true;
        voucherErrorMessage.value = "";

        const response = await axios.post("/api/vouchers/apply", {
            code: code,
            subtotal: subtotal.value,
        });

        const vData = response.data.voucher;
        if (vData.seller_id) {
            const storeSubtotal = checkoutItems.value
                .filter((item) => item.seller_id == vData.seller_id)
                .reduce((sum, item) => sum + item.price * item.qty, 0);
            if (storeSubtotal <= 0) {
                voucherErrorMessage.value = `Voucher ini khusus untuk produk toko "${vData.store_name}". Keranjang Anda tidak memiliki produk dari toko tersebut.`;
                return;
            }
            if (storeSubtotal < (vData.min_purchase || 0)) {
                voucherErrorMessage.value = `Minimal belanja Rp ${formatPrice(vData.min_purchase)} untuk produk toko "${vData.store_name}".`;
                return;
            }
        }

        appliedVoucher.value = {
            code: vData.code,
            name: vData.name,
            type: vData.type,
            value: vData.value,
            max_discount: vData.max_discount,
            min_purchase: vData.min_purchase || 0,
            seller_id: vData.seller_id,
            store_name: vData.store_name,
        };
        showVoucherModal.value = false;
    } catch (err) {
        voucherErrorMessage.value = err.response?.data?.message || "Kode voucher tidak valid atau sudah kadaluarsa.";
    } finally {
        applyingVoucher.value = false;
    }
};
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
        const urlParams = new URLSearchParams(window.location.search);
        const itemIds = urlParams.get("items")?.split(",") || [];
        if (itemIds.length === 0) {
            const savedItems = localStorage.getItem("checkout_items");
            if (savedItems) {
                checkoutItems.value = JSON.parse(savedItems);
                loading.value = false;
                return;
            }
            window.location.href = "/cart";
            return;
        }
        const response = await axios.get("/api/cart");
        const allItems = response.data.items || [];
        const selectedItems = allItems.filter((item) =>
            itemIds.includes(item.id.toString()),
        );
        checkoutItems.value = selectedItems.map((item) => ({
            id: item.id,
            product_id: item.product_id,
            seller_id: item.product?.user_id || item.seller_id || null,
            product_name: item.product?.name || "Produk",
            product_description: item.product?.description || "",
            price: item.product?.price || item.price || 0,
            qty: item.qty || item.quantity || 0,
            stock: item.product?.stock ?? 0,
            store_name: item.store_name || item.product?.user?.name || "Toko",
            image_url: item.product?.image_url || null,
        }));
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
        shippingAddress.value = {
            name: response.data.name || "",
            phone: response.data.phone || "",
            address: response.data.address || "",
            lat: response.data.latitude || response.data.lat || shippingAddress.value.lat || null,
            lng: response.data.longitude || response.data.lng || shippingAddress.value.lng || null,
            destination_lat: response.data.latitude || response.data.lat || shippingAddress.value.destination_lat || null,
            destination_lng: response.data.longitude || response.data.lng || shippingAddress.value.destination_lng || null,
        };
    } catch (error) {
        console.error("Error fetching user profile:", error);
    }
};

const saveAddress = () => {
    showAddressModal.value = false;
};

const paymentTransactions = ref([]);
const showPaymentModal = ref(false);
const currentPaymentIndex = ref(0);

const isPaidStatus = (status) => {
    return status === "success" ||
        status === "settlement" ||
        status === "capture" ||
        status === "paid" ||
        status === "processing" ||
        status === "shipping" ||
        status === "delivered" ||
        status === "completed";
};

const allPaymentsCompleted = computed(() => {
    return paymentTransactions.value.every((t) => isPaidStatus(t.status));
});

const getStatusLabel = (status) => {
    if (isPaidStatus(status)) {
        return "Sudah Dibayar";
    }
    if (status === "pending") {
        return "Menunggu Pembayaran";
    }
    if (status === "failed") {
        return "Gagal";
    }
    return "Belum Dibayar";
};

const ensureMidtransLoaded = (callback) => {
    if (window.snap) {
        callback();
        return;
    }
    const script = document.createElement("script");
    script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
    script.setAttribute("data-client-key", "Mid-client-PWVFJy65rpPL1JmL");
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
        const checkoutData = {
            shipping_address: shippingAddress.value,
            cart_item_ids: checkoutItems.value.map((item) => item.id),
            voucher_code: appliedVoucher.value?.code || null,
        };
        const response = await axios.post("/api/checkout", checkoutData);
        if (
            response.data &&
            Array.isArray(response.data.transactions) &&
            response.data.transactions.length > 0
        ) {
            localStorage.removeItem("checkout_items");
            checkoutItems.value = [];

            paymentTransactions.value = response.data.transactions.map((t) => ({
                ...t,
                status: t.status === "pending" || t.status === "unpaid" ? null : t.status,
            }));
            showPaymentModal.value = true;
            currentPaymentIndex.value = 0;
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
                const oid = result.order_id || t.transaction?.order_id || t.order_id || '';
                window.location.href = `/order-confirmation?order_id=${oid}&transaction_status=settlement&status_code=200`;
            },
            onPending: function (result) {
                console.log("Payment pending:", result);
                updateTransactionStatus(index, "pending");
                setTimeout(() => checkTransactionStatusFromBackend(index), 2500);
            },
            onError: function (result) {
                console.error("Payment error:", result);
                updateTransactionStatus(index, "failed");
            },
            onClose: function () {
                console.log("Payment modal closed, checking status...");
                checkTransactionStatusFromBackend(index);
            },
        });
    });
};

const checkTransactionStatusFromBackend = async (index) => {
    const t = paymentTransactions.value[index];
    const txId = t?.transaction?.id || t?.id;
    if (!txId) return;

    try {
        const response = await axios.get(`/api/transactions/${txId}/status`);
        if (response.data && response.data.status) {
            const st = response.data.status;
            paymentTransactions.value[index].status = st;
            if (response.data.total_price) {
                paymentTransactions.value[index].total = response.data.total_price;
            }
            if (response.data.discount_amount) {
                paymentTransactions.value[index].discount_amount = response.data.discount_amount;
            }
            if (response.data.voucher_code) {
                paymentTransactions.value[index].voucher_code = response.data.voucher_code;
            }
            if (isPaidStatus(st)) {
                updateTransactionStatus(index, "success");
            }
        }
    } catch (err) {
        console.error("Error checking transaction status:", err);
    }
};

const updateTransactionStatus = (index, status) => {
    if (paymentTransactions.value[index]) {
        paymentTransactions.value[index].status = status;
        if (
            status === "success" ||
            status === "settlement" ||
            status === "pending"
        ) {
            if (index + 1 < paymentTransactions.value.length) {
                currentPaymentIndex.value = index + 1;
            }
        }
    }
};

const finishPaymentProcess = () => {
    const transactionIds = paymentTransactions.value
        .map((t) => t.transaction?.id)
        .filter((id) => id);

    if (transactionIds.length > 0) {
        window.location.href = `/order-confirmation?transaction_ids=${transactionIds.join(
            ",",
        )}`;
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
    await fetchVouchers();
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
