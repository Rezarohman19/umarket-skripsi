<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="flex">
            <!-- Sidebar -->
            <aside
                :class="[
                    'bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                    sidebarCollapsed ? 'w-16' : 'w-64',
                ]"
            >
                <div class="p-4 flex items-center justify-between">
                    <button @click="toggleSidebar" class="p-2 rounded-lg">
                        <svg
                            class="w-5 h-5 text-white"
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
                    </button>
                </div>

                <nav class="px-4 space-y-3">
                    <a
                        href="/"
                        class="flex items-center px-4 py-3 rounded-lg text-white/80"
                    >
                        <svg
                            class="w-5 h-5 text-white mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Beranda</span>
                    </a>

                    <a
                        href="/orders"
                        class="flex items-center px-4 py-3 rounded-lg text-white/80"
                    >
                        <svg
                            class="w-5 h-5 text-white mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Pesanan Saya</span>
                    </a>

                    <a
                        href="#"
                        class="flex items-center px-4 py-3 rounded-lg bg-[#FDA1A2]/30 text-white font-medium"
                    >
                        <svg
                            class="w-5 h-5 text-white mr-3"
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
                        <span v-if="!sidebarCollapsed">Buka Toko</span>
                    </a>
                </nav>

                <nav
                    class="px-4 space-y-3 border-t border-[#EF3B33]/30 pt-6 mt-6"
                >
                    <a
                        href="/terms-and-conditions"
                        class="flex items-center px-4 py-3 rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition"
                    >
                        <svg
                            class="w-5 h-5 text-white mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Syarat & Ketentuan</span>
                    </a>

                    <a
                        href="/contact-us"
                        class="flex items-center px-4 py-3 rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition"
                    >
                        <svg
                            class="w-5 h-5 text-white mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Hubungi Kami</span>
                    </a>
                </nav>

                <div class="mt-auto p-4">
                    <button
                        @click="handleLogout"
                        class="w-full bg-[#EF3B33]/30 text-white font-medium py-3 px-4 rounded-lg"
                    >
                        <span v-if="!sidebarCollapsed">Keluar</span>
                        <span v-else class="flex justify-center">
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
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>
                        </span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <main
                :class="[
                    'flex-1 transition-all duration-300',
                    sidebarCollapsed ? 'ml-16' : 'ml-64',
                ]"
            >
                <!-- Header -->
                <header
                    class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm px-6 py-4 sticky top-0 z-10"
                >
                    <div class="flex items-center justify-between">
                        <Logo
                            containerClass="w-10 h-10 bg-[#1D1842] rounded-full flex items-center justify-center"
                        />

                        <div class="flex-1 mx-6">
                            <p class="text-gray-700 dark:text-gray-300">
                                Halo,
                                <span class="font-semibold">{{
                                    user?.name || "Pengunjung"
                                }}</span>
                            </p>
                        </div>

                        <div class="flex-1 max-w-md mx-4">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari"
                                    class="w-full px-4 py-2 pl-10 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg focus:outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                />
                                <svg
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <button
                            @click="handleCart"
                            class="relative p-2 text-gray-600 dark:text-gray-400 mr-1"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
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
                                :class="[
                                    'absolute top-0 right-0 bg-[#EF3B33] text-white text-xs rounded-full flex items-center justify-center font-semibold',
                                    cartCount > 9
                                        ? 'w-6 h-6 -mt-1 -mr-1'
                                        : 'w-5 h-5',
                                ]"
                            >
                                {{ cartCount > 99 ? "99+" : cartCount }}
                            </span>
                        </button>

                        <!-- Profile Icon -->
                        <button
                            @click="handleProfile"
                            class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center ml-2"
                            :class="
                                user?.photo_url
                                    ? 'ring-2 ring-[#8E0D3C] dark:ring-[#FDA1A2]'
                                    : 'bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/30'
                            "
                        >
                            <img
                                v-if="user?.photo_url"
                                :src="getPhotoUrl(user.photo_url)"
                                :alt="user.name"
                                class="w-full h-full object-cover"
                            />
                            <svg
                                v-else
                                class="w-6 h-6 text-gray-600 dark:text-gray-400"
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
                        </button>
                    </div>
                </header>

                <!-- Store Overview -->
                <div class="p-6 space-y-8">
                    <!-- Store Overview -->
                    <section
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6"
                    >
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between gap-6"
                        >
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300"
                                >
                                    <img
                                        v-if="user?.photo_url"
                                        :src="getPhotoUrl(user.photo_url)"
                                        :alt="user.name || 'Foto Profil'"
                                        class="w-full h-full object-cover"
                                    />
                                    <svg
                                        v-else
                                        class="w-8 h-8 text-gray-400"
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
                                </div>
                                <div>
                                    <p
                                        class="text-lg font-semibold text-gray-800 dark:text-gray-100"
                                    >
                                        {{ store.name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Saldo Penjual -->
                            <div
                                class="bg-gradient-to-r from-[#FDA1A2]/20 to-[#EF3B33]/20 dark:from-[#8E0D3C]/30 dark:to-[#EF3B33]/20 rounded-xl p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                            >
                                <div
                                    class="flex items-center justify-between gap-4"
                                >
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1"
                                        >
                                            Saldo Penjualan
                                        </p>
                                        <p
                                            class="text-3xl font-bold text-[#EF3B33] dark:text-[#FDA1A2]"
                                        >
                                            Rp.
                                            {{
                                                formatPrice(store.balance || 0)
                                            }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                                        >
                                            Dari
                                            {{ store.totalSold || 0 }} penjualan
                                        </p>
                                    </div>
                                    <button
                                        @click="showWithdrawModal = true"
                                        :disabled="
                                            !store.balance || store.balance <= 0
                                        "
                                        class="px-6 py-3 bg-[#EF3B33] hover:bg-[#d92f25] disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-semibold rounded-lg shadow-md transition-colors whitespace-nowrap"
                                    >
                                        Tarik Saldo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                            <button
                                @click="showOrdersSection('paid')"
                                :class="[
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer',
                                    activeOrderSection === 'paid'
                                        ? 'ring-2 ring-[#EF3B33] dark:ring-[#FDA1A2]'
                                        : '',
                                ]"
                            >
                                <p
                                    class="text-2xl font-bold text-gray-900 dark:text-white"
                                >
                                    {{ store.stats.incoming }}
                                </p>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >
                                    Pesanan Masuk
                                </p>
                            </button>
                            <button
                                @click="showOrdersSection('processing')"
                                :class="[
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer',
                                    activeOrderSection === 'processing'
                                        ? 'ring-2 ring-[#FDA1A2] dark:ring-[#FDA1A2]'
                                        : '',
                                ]"
                            >
                                <p
                                    class="text-2xl font-bold text-gray-900 dark:text-white"
                                >
                                    {{ store.stats.needShip }}
                                </p>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >
                                    Perlu Dikirim
                                </p>
                            </button>
                            <button
                                @click="showOrdersSection('shipping')"
                                :class="[
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer',
                                    activeOrderSection === 'shipping'
                                        ? 'ring-2 ring-[#8E0D3C] dark:ring-[#8E0D3C]'
                                        : '',
                                ]"
                            >
                                <p
                                    class="text-2xl font-bold text-gray-900 dark:text-white"
                                >
                                    {{ store.stats.shipped }}
                                </p>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >
                                    Dikirim
                                </p>
                            </button>
                            <button
                                @click="showOrdersSection('history')"
                                :class="[
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer',
                                    activeOrderSection === 'history'
                                        ? 'ring-2 ring-[#1D1842] dark:ring-[#1D1842]'
                                        : '',
                                ]"
                            >
                                <p
                                    class="text-2xl font-bold text-gray-900 dark:text-white"
                                >
                                    {{ store.stats.history }}
                                </p>
                                <p
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >
                                    Riwayat Penjualan
                                </p>
                            </button>
                        </div>
                    </section>

                    <!-- Pesanan Section (Muncul saat statistik diklik) -->
                    <section
                        v-if="activeOrderSection"
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6 space-y-4"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <h2
                                    class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                                >
                                    {{ getSectionTitle(activeOrderSection) }}
                                </h2>
                                <button
                                    @click="activeOrderSection = null"
                                    class="p-1 text-gray-500"
                                    title="Tutup"
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
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Loading -->
                        <div v-if="ordersLoading" class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">
                                Memuat pesanan...
                            </p>
                        </div>

                        <!-- Empty State -->
                        <div
                            v-else-if="filteredOrdersBySection.length === 0"
                            class="text-center py-8"
                        >
                            <svg
                                class="w-16 h-16 mx-auto text-gray-400 mb-3"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400">
                                Belum ada pesanan di kategori ini
                            </p>
                        </div>

                        <!-- Orders List -->
                        <div v-else class="space-y-4">
                            <div
                                v-for="order in filteredOrdersBySection"
                                :key="order.id"
                                class="border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 rounded-lg p-4"
                            >
                                <div
                                    class="flex items-start justify-between mb-3"
                                >
                                    <div>
                                        <div
                                            class="flex items-center gap-2 mb-1"
                                        >
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-semibold"
                                                :class="
                                                    getStatusClass(order.status)
                                                "
                                            >
                                                {{
                                                    getStatusLabel(order.status)
                                                }}
                                            </span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400"
                                                >ID: #{{ order.id }}</span
                                            >
                                        </div>
                                        <p
                                            class="text-sm font-semibold text-gray-900 dark:text-white"
                                        >
                                            Pesanan dari: {{ order.buyer_name }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                                        >
                                            {{ formatDate(order.created_at) }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p
                                            class="text-lg font-bold text-gray-900 dark:text-white"
                                        >
                                            Rp.
                                            {{ formatPrice(order.total_price) }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-500 dark:text-gray-400"
                                        >
                                            {{ order.items.length }} item
                                        </p>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="space-y-2 mb-3">
                                    <div
                                        v-for="item in order.items"
                                        :key="item.id"
                                        class="flex items-center gap-3 p-2 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded"
                                    >
                                        <div
                                            class="w-12 h-12 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded flex items-center justify-center overflow-hidden flex-shrink-0 border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                        >
                                            <img
                                                v-if="item.product?.image_url"
                                                :src="item.product.image_url"
                                                :alt="item.product.name"
                                                class="w-full h-full object-cover"
                                            />
                                            <svg
                                                v-else
                                                class="w-6 h-6 text-gray-400"
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
                                                class="text-sm font-semibold text-gray-900 dark:text-white truncate"
                                            >
                                                {{
                                                    item.product?.name ||
                                                    "Produk"
                                                }}
                                            </p>
                                            <p
                                                class="text-xs text-gray-600 dark:text-gray-400"
                                            >
                                                {{ item.qty }} pcs × Rp.
                                                {{ formatPrice(item.price) }}
                                            </p>
                                        </div>
                                        <p
                                            class="text-sm font-semibold text-gray-900 dark:text-white"
                                        >
                                            Rp.
                                            {{
                                                formatPrice(
                                                    item.price * item.qty
                                                )
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Shipping Address -->
                                <div
                                    v-if="order.shipping_address"
                                    class="mb-3 p-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 rounded text-xs"
                                >
                                    <p
                                        class="font-semibold text-[#8E0D3C] dark:text-[#FDA1A2] mb-1"
                                    >
                                        Alamat Pengiriman:
                                    </p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        {{ order.shipping_address.name }} -
                                        {{ order.shipping_address.phone }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ order.shipping_address.address }}
                                    </p>
                                </div>

                                <!-- Tracking Number -->
                                <div
                                    v-if="order.tracking_number"
                                    class="mb-3 p-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 rounded text-xs"
                                >
                                    <p
                                        class="font-semibold text-[#8E0D3C] dark:text-[#FDA1A2] mb-1"
                                    >
                                        Nomor Resi:
                                    </p>
                                    <p
                                        class="font-mono text-gray-900 dark:text-white"
                                    >
                                        {{ order.tracking_number }}
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        v-if="order.status === 'paid'"
                                        @click="
                                            updateOrderStatus(
                                                order.id,
                                                'processing'
                                            )
                                        "
                                        class="px-3 py-1.5 bg-[#EF3B33] text-white rounded-lg text-xs font-medium"
                                    >
                                        Mulai Kemas
                                    </button>
                                    <button
                                        v-if="order.status === 'processing'"
                                        @click="showShippingModal(order)"
                                        class="px-3 py-1.5 bg-[#FDA1A2] text-white rounded-lg text-xs font-medium"
                                    >
                                        Kirim Paket
                                    </button>
                                    <button
                                        v-if="order.status === 'shipping'"
                                        @click="
                                            updateOrderStatus(
                                                order.id,
                                                'delivered'
                                            )
                                        "
                                        class="px-3 py-1.5 bg-[#8E0D3C] text-white rounded-lg text-xs font-medium"
                                    >
                                        Tandai Diterima
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Product Table -->
                    <section
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6 space-y-4"
                    >
                        <div class="flex items-center justify-between">
                            <h2
                                class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                            >
                                Produk
                            </h2>
                            <button
                                class="px-4 py-2 bg-[#EF3B33] text-white text-sm font-medium rounded-lg shadow-md"
                                @click="toggleForm"
                            >
                                + Tambah Produk
                            </button>
                        </div>

                        <transition name="fade">
                            <div
                                v-if="showForm"
                                class="bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 space-y-3 border border-dashed border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40"
                            >
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-3"
                                >
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                            >Nama Produk</label
                                        >
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                            >Kategori</label
                                        >
                                        <input
                                            v-model="form.category"
                                            type="text"
                                            list="category-suggestions"
                                            placeholder="Ketik nama kategori (atau pilih dari saran)..."
                                            class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                                        />
                                        <datalist id="category-suggestions">
                                            <option
                                                v-for="cat in categories"
                                                :key="cat.id"
                                                :value="cat.name"
                                            ></option>
                                        </datalist>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                            >Deskripsi Produk</label
                                        >
                                        <textarea
                                            v-model="form.description"
                                            rows="3"
                                            class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none resize-none"
                                            placeholder="Masukkan deskripsi produk yang detail..."
                                        ></textarea>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                            >Harga</label
                                        >
                                        <input
                                            v-model="priceInput"
                                            type="text"
                                            placeholder="Contoh: Rp 10.000 atau 10000"
                                            @input="handlePriceInput"
                                            @blur="formatPriceInput"
                                            class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                            >Stok</label
                                        >
                                        <input
                                            v-model.number="form.stock"
                                            type="number"
                                            min="0"
                                            class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                                        />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                                            >Foto Produk</label
                                        >
                                        <div class="flex items-center gap-3">
                                            <label
                                                class="w-28 h-28 border border-dashed border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg flex items-center justify-center bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 cursor-pointer"
                                            >
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    class="hidden"
                                                    @change="onImageChange"
                                                />
                                                <template
                                                    v-if="form.imagePreview"
                                                >
                                                    <img
                                                        :src="form.imagePreview"
                                                        alt="preview"
                                                        class="w-full h-full object-cover rounded-lg"
                                                    />
                                                </template>
                                                <template v-else>
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400"
                                                        >Upload</span
                                                    >
                                                </template>
                                            </label>
                                            <button
                                                v-if="form.imagePreview"
                                                class="text-xs text-red-500 hover:text-red-600"
                                                @click="removeImage"
                                            >
                                                Hapus Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="px-4 py-2 bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg"
                                        @click="cancelForm"
                                    >
                                        Batal
                                    </button>
                                    <button
                                        class="px-4 py-2 bg-[#EF3B33] text-white rounded-lg shadow-md"
                                        @click="submitForm"
                                    >
                                        {{
                                            form.id
                                                ? "Simpan Perubahan"
                                                : "Simpan Produk"
                                        }}
                                    </button>
                                </div>
                            </div>
                        </transition>

                        <div class="overflow-x-auto">
                            <div class="min-w-full">
                                <div
                                    class="grid grid-cols-6 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-sm font-semibold text-[#8E0D3C] dark:text-[#FDA1A2] rounded-lg px-4 py-3"
                                >
                                    <div>Nama Toko</div>
                                    <div>Nama</div>
                                    <div>Kategori</div>
                                    <div>Stok</div>
                                    <div>Harga</div>
                                    <div class="text-right">Aksi</div>
                                </div>

                                <div
                                    class="space-y-2 mt-2"
                                    v-if="products.length"
                                >
                                    <div
                                        v-for="p in products"
                                        :key="p.id"
                                        class="grid grid-cols-6 items-center bg-white dark:bg-[#1D1842] border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 rounded-lg px-4 py-4 gap-2"
                                    >
                                        <div
                                            class="text-sm text-gray-700 dark:text-gray-300"
                                        >
                                            {{ store.name }}
                                        </div>
                                        <div
                                            class="text-sm text-[#1D1842] dark:text-[#FDA1A2] font-semibold"
                                        >
                                            {{ p.name }}
                                        </div>
                                        <div
                                            class="text-sm text-[#EF3B33] dark:text-[#EF3B33]"
                                        >
                                            {{ p.category?.name || "-" }}
                                        </div>
                                        <div
                                            class="text-sm text-[#1D1842] dark:text-[#FDA1A2]"
                                        >
                                            {{ p.stock }}
                                        </div>
                                        <div
                                            class="text-sm text-[#EF3B33] dark:text-[#EF3B33] font-semibold"
                                        >
                                            Rp. {{ formatPrice(p.price) }}
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2]"
                                                @click="editProduct(p)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-[#EF3B33]/20 dark:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#FDA1A2]"
                                                @click="deleteProduct(p.id)"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-else
                                    class="text-sm text-gray-500 dark:text-gray-400 mt-3"
                                >
                                    Belum ada produk.
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Shipping Modal -->
        <transition name="modal">
            <div
                v-if="showShippingForm"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showShippingForm = false"
            >
                <div
                    class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                >
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white mb-4"
                    >
                        Kirim Paket
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                            >
                                Nomor Resi / Tracking Number
                            </label>
                            <input
                                v-model="trackingNumber"
                                type="text"
                                placeholder="Masukkan nomor resi"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            />
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                            >
                                Kurir / Jasa Pengiriman
                            </label>
                            <select
                                v-model="shippingCourier"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            >
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="jnt">J&T Express</option>
                                <option value="sicepat">SiCepat</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="flex gap-3">
                            <button
                                @click="
                                    showShippingForm = false;
                                    trackingNumber = '';
                                    shippingCourier = 'jne';
                                    selectedOrderId = null;
                                "
                                class="flex-1 px-4 py-2 bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg font-medium"
                            >
                                Batal
                            </button>
                            <button
                                @click="confirmShipping"
                                class="flex-1 px-4 py-2 bg-[#EF3B33] text-white rounded-lg font-semibold"
                            >
                                Konfirmasi Kirim
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Withdraw Saldo Modal -->
        <transition name="modal">
            <div
                v-if="showWithdrawModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showWithdrawModal = false"
            >
                <div
                    class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                >
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white mb-4"
                    >
                        Tarik Saldo
                    </h3>
                    <div class="space-y-4">
                        <!-- Info Saldo -->
                        <div
                            class="bg-[#FDA1A2]/10 dark:bg-[#8E0D3C]/20 rounded-lg p-4 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                        >
                            <p
                                class="text-sm text-gray-600 dark:text-gray-400 mb-1"
                            >
                                Saldo Tersedia
                            </p>
                            <p
                                class="text-2xl font-bold text-[#EF3B33] dark:text-[#FDA1A2]"
                            >
                                Rp. {{ formatPrice(store.balance || 0) }}
                            </p>
                        </div>

                        <!-- Jumlah Penarikan -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                            >
                                Jumlah Penarikan
                            </label>
                            <input
                                v-model="withdrawAmount"
                                type="text"
                                placeholder="Masukkan jumlah"
                                @input="handleWithdrawInput"
                                @blur="formatWithdrawAmount"
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg focus:outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                            />
                            <p
                                class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                            >
                                Contoh: Rp 100.000 atau 100000
                            </p>
                        </div>

                        <!-- Bank Account Info -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                            >
                                Rekening Tujuan
                            </label>
                            <select
                                v-model="withdrawBankId"
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg focus:outline-none text-gray-900 dark:text-white"
                            >
                                <option value="">-- Pilih Rekening --</option>
                                <option
                                    v-for="bank in userBanks"
                                    :key="bank.id"
                                    :value="bank.id"
                                >
                                    {{ bank.bank_name }} -
                                    {{ bank.account_number }} ({{
                                        bank.account_holder
                                    }})
                                </option>
                            </select>
                            <p
                                class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                            >
                                <a
                                    href="/profile"
                                    class="text-[#EF3B33] hover:underline"
                                >
                                    Kelola rekening di profil
                                </a>
                            </p>
                        </div>

                        <!-- Error Message -->
                        <div
                            v-if="withdrawError"
                            class="bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 text-sm px-4 py-3 rounded-lg"
                        >
                            {{ withdrawError }}
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button
                                @click="showWithdrawModal = false"
                                class="flex-1 px-4 py-2 bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg font-medium hover:bg-[#1D1842]/30 dark:hover:bg-[#1D1842]/40 transition-colors"
                            >
                                Batal
                            </button>
                            <button
                                @click="confirmWithdraw"
                                :disabled="
                                    !withdrawAmount ||
                                    !withdrawBankId ||
                                    withdrawProcessing
                                "
                                class="flex-1 px-4 py-2 bg-[#EF3B33] hover:bg-[#d92f25] disabled:bg-gray-400 disabled:cursor-not-allowed text-white rounded-lg font-semibold shadow-md transition-colors"
                            >
                                <span v-if="withdrawProcessing"
                                    >Memproses...</span
                                >
                                <span v-else>Konfirmasi Penarikan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import axios from "axios";
import Logo from "../components/Logo.vue";

const sidebarCollapsed = ref(false);
const user = ref(null);
const cartCount = ref(0);
const searchQuery = ref("");

const store = ref({
    name: "Nama Toko",
    balance: 0,
    totalSold: 0,
    stats: {
        incoming: 0,
        needShip: 0,
        shipped: 0,
        history: 0,
    },
});

const products = ref([]);
const categories = ref([]);
const showForm = ref(false);
const form = ref({
    id: null,
    name: "",
    category: "",
    description: "",
    price: 0,
    stock: 0,
    imageFile: null,
    imagePreview: null,
});

// Orders
const incomingOrders = ref([]);
const ordersLoading = ref(false);
const activeOrderSection = ref(null);
const showShippingForm = ref(false);
const selectedOrderId = ref(null);
const trackingNumber = ref("");
const shippingCourier = ref("");

// Withdraw
const showWithdrawModal = ref(false);
const withdrawAmount = ref("");
const withdrawAmountNumber = ref(0);
const withdrawBankId = ref("");
const withdrawError = ref("");
const withdrawProcessing = ref(false);
const userBanks = ref([]);
const orderFilterStatus = ref("");

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

// Helper untuk parse harga dari format string ke number
const parsePrice = (priceString) => {
    if (!priceString) return 0;
    // Hapus semua karakter non-digit kecuali titik (untuk separator ribuan)
    const cleaned = priceString.toString().replace(/[^\d.]/g, "");
    // Hapus semua titik (karena di Indonesia titik = separator ribuan, bukan desimal)
    const numberString = cleaned.replace(/\./g, "");
    const parsed = parseInt(numberString, 10);
    return isNaN(parsed) ? 0 : parsed;
};

// Helper untuk format harga ke string dengan format Rupiah
const formatPriceString = (price) => {
    if (!price || price === 0) return "";
    return `Rp ${formatPrice(price)}`;
};

// Ref untuk input harga (string)
const priceInput = ref("");

// Handle input harga - parse dan update form.price
const handlePriceInput = (event) => {
    const value = event.target.value;
    priceInput.value = value;
    // Parse dan update form.price
    form.value.price = parsePrice(value);
};

// Format harga saat blur (keluar dari input)
const formatPriceInput = () => {
    if (form.value.price > 0) {
        priceInput.value = formatPriceString(form.value.price);
    } else {
        priceInput.value = "";
    }
};

const formatDate = (date) => {
    if (!date) return "";
    const d = new Date(date);
    return d.toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getStatusLabel = (status) => {
    const labels = {
        pending: "Menunggu Pembayaran",
        paid: "Sudah Dibayar",
        processing: "Sedang Dikemas",
        shipping: "Sedang Dikirim",
        delivered: "Sudah Diterima",
        completed: "Selesai",
        cancelled: "Dibatalkan",
    };
    return labels[status] || status;
};

const getStatusClass = (status) => {
    const classes = {
        pending:
            "bg-[#EF3B33]/20 text-[#EF3B33] dark:bg-[#EF3B33]/20 dark:text-[#FDA1A2]",
        paid: "bg-[#FDA1A2]/30 text-[#8E0D3C] dark:bg-[#FDA1A2]/20 dark:text-[#FDA1A2]",
        processing:
            "bg-[#FDA1A2]/30 text-[#8E0D3C] dark:bg-[#FDA1A2]/20 dark:text-[#FDA1A2]",
        shipping:
            "bg-[#8E0D3C]/20 text-[#8E0D3C] dark:bg-[#8E0D3C]/30 dark:text-[#FDA1A2]",
        delivered:
            "bg-[#1D1842]/20 text-[#1D1842] dark:bg-[#1D1842]/40 dark:text-[#FDA1A2]",
        completed:
            "bg-[#1D1842]/20 text-[#1D1842] dark:bg-[#1D1842]/40 dark:text-[#FDA1A2]",
        cancelled:
            "bg-[#EF3B33]/20 text-[#EF3B33] dark:bg-[#EF3B33]/20 dark:text-[#FDA1A2]",
    };
    return (
        classes[status] ||
        "bg-[#FDA1A2]/20 text-[#8E0D3C] dark:bg-[#8E0D3C]/20 dark:text-[#FDA1A2]"
    );
};

const filteredIncomingOrders = computed(() => {
    let filtered = incomingOrders.value;
    if (orderFilterStatus.value) {
        filtered = filtered.filter(
            (order) => order.status === orderFilterStatus.value
        );
    }
    return filtered;
});

const filteredOrdersBySection = computed(() => {
    if (!activeOrderSection.value) return [];

    let filtered = incomingOrders.value;

    if (activeOrderSection.value === "paid") {
        // Pesanan Masuk: status pending (menunggu pembayaran) atau paid (sudah dibayar)
        filtered = filtered.filter(
            (order) => order.status === "pending" || order.status === "paid"
        );
    } else if (activeOrderSection.value === "processing") {
        // Perlu Dikirim: status processing (sedang dikemas)
        filtered = filtered.filter((order) => order.status === "processing");
    } else if (activeOrderSection.value === "shipping") {
        // Dikirim: status shipping (sedang dikirim)
        filtered = filtered.filter((order) => order.status === "shipping");
    } else if (activeOrderSection.value === "history") {
        // Riwayat: status completed atau delivered (selesai/diterima)
        filtered = filtered.filter(
            (order) =>
                order.status === "completed" || order.status === "delivered"
        );
    }

    return filtered;
});

const getSectionTitle = (section) => {
    const titles = {
        paid: "Pesanan Masuk",
        processing: "Perlu Dikirim",
        shipping: "Dikirim",
        history: "Riwayat Penjualan",
    };
    return titles[section] || "Pesanan";
};

const showOrdersSection = (section) => {
    activeOrderSection.value =
        activeOrderSection.value === section ? null : section;
};

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const handleLogout = async () => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }

    if (confirm("Apakah Anda yakin ingin keluar?")) {
        try {
            await axios.post("/logout");
            window.location.href = "/login";
        } catch (error) {
            console.error("Error logging out:", error);
            // Tetap redirect meskipun ada error
            window.location.href = "/login";
        }
    }
};

const handleCart = () => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }
    window.location.href = "/cart";
};

const handleProfile = () => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }
    window.location.href = "/profile";
};

const toggleForm = () => {
    showForm.value = !showForm.value;
    if (!showForm.value) {
        resetForm();
    } else {
        // Saat form dibuka, pastikan priceInput juga di-reset
        priceInput.value = "";
    }
};

const resetForm = () => {
    form.value = {
        id: null,
        name: "",
        category: "",
        description: "",
        price: 0,
        stock: 0,
        imageFile: null,
        imagePreview: null,
    };
    priceInput.value = "";
};

const cancelForm = () => {
    resetForm();
    showForm.value = false;
};

const editProduct = (p) => {
    form.value = {
        id: p.id,
        name: p.name,
        category: p.category?.name || "",
        description: p.description || "",
        price: p.price,
        stock: p.stock,
        imageFile: null,
        imagePreview: p.image_url || null,
    };
    // Set priceInput dengan format yang sudah diformat
    priceInput.value = p.price > 0 ? formatPriceString(p.price) : "";
    showForm.value = true;
};

const deleteProduct = async (id) => {
    if (!confirm("Hapus produk ini?")) return;
    try {
        await axios.delete(`/api/products/${id}`);
        await fetchProducts();
    } catch (error) {
        alert("Gagal menghapus produk");
    }
};

const submitForm = async () => {
    if (!form.value.name || form.value.price < 0 || form.value.stock < 0) {
        alert("Nama, harga, dan stok wajib diisi dengan benar");
        return;
    }
    const payload = new FormData();
    payload.append("name", form.value.name);
    payload.append("category", form.value.category || "");
    payload.append("description", form.value.description || "");
    payload.append("price", form.value.price);
    payload.append("stock", form.value.stock);
    if (form.value.imageFile) {
        payload.append("image", form.value.imageFile);
    } else if (form.value.imagePreview === null && form.value.id) {
        payload.append("remove_image", "1");
    }

    try {
        let response;
        if (form.value.id) {
            response = await axios.post(
                `/api/products/${form.value.id}`,
                payload
            );
        } else {
            response = await axios.post("/api/products", payload);
        }
        console.log("Product saved:", response.data);

        // Tambahkan produk baru ke array langsung (untuk immediate update)
        if (!form.value.id && response.data) {
            const newProduct = {
                ...response.data,
                image_url: response.data.image_url || null,
            };
            products.value.unshift(newProduct);
        } else if (form.value.id && response.data) {
            // Update produk yang sudah ada
            const index = products.value.findIndex(
                (p) => p.id === form.value.id
            );
            if (index !== -1) {
                products.value[index] = {
                    ...response.data,
                    image_url: response.data.image_url || null,
                };
            }
        }

        // Refresh produk setelah save untuk memastikan data terbaru
        await fetchProducts();
        resetForm();
        showForm.value = false;
    } catch (error) {
        console.error("Error saving product:", error);
        alert(
            "Gagal menyimpan produk: " +
                (error.response?.data?.message || error.message)
        );
    }
};

const onImageChange = (event) => {
    const file = event.target.files?.[0];
    if (file) {
        form.value.imageFile = file;
        form.value.imagePreview = URL.createObjectURL(file);
    }
};

const removeImage = () => {
    form.value.imageFile = null;
    form.value.imagePreview = null;
};

const fetchProducts = async () => {
    if (!user.value) {
        console.log("User not authenticated, cannot fetch products");
        products.value = [];
        return;
    }
    try {
        // Gunakan endpoint /api/my-products yang sudah ada di web.php
        const response = await axios.get("/api/my-products");
        const fetchedProducts = Array.isArray(response.data)
            ? response.data
            : [];

        console.log("Fetched products count:", fetchedProducts.length);

        // Update products dengan data baru
        products.value = fetchedProducts;

        if (fetchedProducts.length === 0) {
            console.warn("No products found for user:", user.value.id);
        } else {
            console.log(
                "Products successfully loaded:",
                fetchedProducts.map((p) => ({ id: p.id, name: p.name }))
            );
        }
    } catch (error) {
        console.error("Error fetching products:", error);
        console.error("Error details:", error.response?.data);
        products.value = [];
    }
};

const getPhotoUrl = (photoUrl) => {
    if (!photoUrl) return null;
    // Tambahkan cache busting jika belum ada
    if (photoUrl.includes("?")) {
        return photoUrl.split("?")[0] + "?t=" + Date.now();
    }
    return photoUrl + "?t=" + Date.now();
};

const checkAuth = async () => {
    try {
        // Tambahkan cache busting untuk memastikan data terbaru
        const response = await axios.get("/api/user", {
            params: { _t: Date.now() },
        });
        user.value = response.data;
        store.value.name = response.data.name || "Nama Toko";
    } catch (error) {
        user.value = null;
        window.location.href = "/login";
    }
};

const fetchCategories = async () => {
    try {
        const response = await axios.get("/api/categories");
        categories.value = Array.isArray(response.data) ? response.data : [];
        console.log("Categories loaded:", categories.value.length);
    } catch (error) {
        console.error("Error fetching categories:", error);
        categories.value = [];
    }
};

// Handler untuk update user data (setelah edit profil)
const handleUserUpdated = async (event) => {
    // Refresh user data untuk update foto profil
    await checkAuth();
};

const fetchCartCount = async () => {
    if (!user.value) {
        cartCount.value = 0;
        return;
    }
    try {
        const response = await axios.get("/api/cart");
        const apiItems = response.data.items || [];
        cartCount.value = apiItems.reduce(
            (sum, item) => sum + (item.qty || item.quantity || 0),
            0
        );
    } catch (error) {
        cartCount.value = 0;
    }
};

const fetchIncomingOrders = async () => {
    if (!user.value) {
        ordersLoading.value = false;
        return;
    }

    try {
        ordersLoading.value = true;
        // Endpoint untuk mengambil pesanan yang masuk ke toko penjual
        // Akan dibuat di backend: GET /api/seller/orders
        const response = await axios.get("/api/seller/orders");
        const orders = response.data || [];

        incomingOrders.value = orders;

        // Update stats berdasarkan data real
        // Pesanan Masuk: status pending (menunggu pembayaran) atau paid (sudah dibayar)
        store.value.stats = {
            incoming: orders.filter(
                (o) => o.status === "pending" || o.status === "paid"
            ).length,
            needShip: orders.filter((o) => o.status === "processing").length,
            shipped: orders.filter((o) => o.status === "shipping").length,
            history: orders.filter(
                (o) => o.status === "completed" || o.status === "delivered"
            ).length,
        };
    } catch (error) {
        console.error("Error fetching incoming orders:", error);
        incomingOrders.value = [];
        // Jika endpoint belum ada, set stats ke 0
        store.value.stats = {
            incoming: 0,
            needShip: 0,
            shipped: 0,
            history: 0,
        };
    } finally {
        ordersLoading.value = false;
    }
};

const updateOrderStatus = async (orderId, newStatus) => {
    if (
        !confirm(`Ubah status pesanan menjadi "${getStatusLabel(newStatus)}"?`)
    ) {
        return;
    }

    try {
        // Endpoint untuk update status pesanan
        // Akan dibuat di backend: POST /api/seller/orders/{id}/update-status
        await axios.post(`/api/seller/orders/${orderId}/update-status`, {
            status: newStatus,
        });

        // Refresh orders
        await fetchIncomingOrders();
        alert("Status pesanan berhasil diupdate");
    } catch (error) {
        console.error("Error updating order status:", error);
        const message =
            error.response?.data?.message || "Gagal mengupdate status";
        alert(message);
    }
};

const showShippingModal = (order) => {
    selectedOrderId.value = order.id;
    trackingNumber.value = order.tracking_number || "";
    shippingCourier.value = order.shipping_courier || "jne";
    showShippingForm.value = true;
};

const confirmShipping = async () => {
    if (!trackingNumber.value.trim()) {
        alert("Masukkan nomor resi terlebih dahulu");
        return;
    }

    try {
        // Endpoint untuk update status ke shipping dengan tracking number
        await axios.post(
            `/api/seller/orders/${selectedOrderId.value}/update-status`,
            {
                status: "shipping",
                tracking_number: trackingNumber.value,
                shipping_courier: shippingCourier.value,
            }
        );

        showShippingForm.value = false;
        trackingNumber.value = "";
        shippingCourier.value = "jne";
        selectedOrderId.value = null;

        // Refresh orders
        await fetchIncomingOrders();
        alert("Paket berhasil dikonfirmasi dikirim");
    } catch (error) {
        console.error("Error confirming shipping:", error);
        const message =
            error.response?.data?.message || "Gagal mengkonfirmasi pengiriman";
        alert(message);
    }
};

const handleWithdrawInput = (event) => {
    const value = event.target.value;
    withdrawAmount.value = value;
    withdrawAmountNumber.value = parsePrice(value);
    withdrawError.value = "";
};

const formatWithdrawAmount = () => {
    if (withdrawAmountNumber.value > 0) {
        withdrawAmount.value = formatPriceString(withdrawAmountNumber.value);
    } else {
        withdrawAmount.value = "";
    }
};

const confirmWithdraw = async () => {
    withdrawError.value = "";

    // Validasi
    if (!withdrawAmountNumber.value || withdrawAmountNumber.value <= 0) {
        withdrawError.value = "Masukkan jumlah penarikan yang valid";
        return;
    }

    if (!withdrawBankId.value) {
        withdrawError.value = "Pilih rekening tujuan terlebih dahulu";
        return;
    }

    if (withdrawAmountNumber.value > (store.value.balance || 0)) {
        withdrawError.value = `Saldo tidak cukup. Saldo Anda: Rp ${formatPrice(
            store.value.balance || 0
        )}`;
        return;
    }

    if (withdrawAmountNumber.value < 50000) {
        withdrawError.value = "Jumlah minimum penarikan adalah Rp 50.000";
        return;
    }

    // Konfirmasi
    if (
        !confirm(
            `Tarik saldo Rp ${formatPrice(
                withdrawAmountNumber.value
            )}?\n\nPencairan akan diproses dalam 1-2 hari kerja.`
        )
    ) {
        return;
    }

    try {
        withdrawProcessing.value = true;

        const response = await axios.post("/api/seller/withdraw", {
            amount: withdrawAmountNumber.value,
            bank_account_id: withdrawBankId.value,
        });

        alert(
            "Permintaan penarikan berhasil dibuat!\nStatus dapat dipantau di halaman profil Anda."
        );

        // Reset form
        withdrawAmount.value = "";
        withdrawAmountNumber.value = 0;
        withdrawBankId.value = "";
        showWithdrawModal.value = false;

        // Refresh saldo
        await fetchSellerBalance();
    } catch (error) {
        console.error("Error withdrawing balance:", error);
        withdrawError.value =
            error.response?.data?.message || "Gagal memproses penarikan saldo";
    } finally {
        withdrawProcessing.value = false;
    }
};

const fetchSellerBalance = async () => {
    if (!user.value) return;

    try {
        const response = await axios.get("/api/seller/balance");
        store.value.balance = response.data.balance || 0;
        store.value.totalSold = response.data.total_sold || 0;
    } catch (error) {
        console.error("Error fetching seller balance:", error);
    }
};

const fetchUserBanks = async () => {
    if (!user.value) return;

    try {
        const response = await axios.get("/api/user/banks");
        userBanks.value = response.data || [];
    } catch (error) {
        console.error("Error fetching user banks:", error);
    }
};

onMounted(async () => {
    await checkAuth();
    if (user.value) {
        await fetchCartCount();
        await fetchProducts();
        await fetchCategories();
        await fetchIncomingOrders();
        await fetchSellerBalance();
        await fetchUserBanks();
    }

    // Listen untuk user update event (setelah edit profil)
    window.addEventListener("userUpdated", handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener("userUpdated", handleUserUpdated);
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

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s, transform 0.25s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-6px);
}
</style>
