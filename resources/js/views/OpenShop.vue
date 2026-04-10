<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] overflow-x-hidden">
        <div class="flex">
            <aside
                :class="[
                    'bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                    sidebarCollapsed ? 'w-16' : 'w-64',
                ]"
            >
                <div :class="[
                    'p-4 border-b border-[#EF3B33]/30',
                    sidebarCollapsed ? 'flex flex-col items-center gap-2' : 'flex items-center justify-between'
                ]">
                    <div :class="[
                        'flex items-center justify-center',
                        sidebarCollapsed ? 'w-full' : 'flex-1'
                    ]">
                        <img
                            src="/images/logo-u-marketplace.png"
                            alt="U Marketplace"
                            :class="[
                                'object-contain',
                                sidebarCollapsed ? 'h-10 w-10' : 'h-20 w-auto'
                            ]"
                        />
                    </div>
                    <button 
                        @click="toggleSidebar" 
                        :class="[
                            'p-2 rounded-lg hover:bg-[#EF3B33]/20 transition-all duration-150 cursor-pointer active:scale-95',
                            sidebarCollapsed ? 'w-full flex justify-center' : ''
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white transition-transform duration-300',
                                sidebarCollapsed ? 'w-5 h-5 rotate-180' : 'w-5 h-5'
                            ]"
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

                <nav :class="[
                    'space-y-3',
                    sidebarCollapsed ? 'px-2' : 'px-4'
                ]">
                    <a href="/" :class="[
                            'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                            sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                            ]"
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

                    <a href="/orders" :class="[
                            'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                            sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                            ]"
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

                    <a href="#" :class="[
                            'flex items-center rounded-lg bg-[#FDA1A2]/30 text-white font-medium transition relative',
                            sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                            ]"
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
                        <span v-if="!sidebarCollapsed">Toko Saya</span>
                        <!-- Notification Badge -->
                        <span 
                            v-if="unreadOrdersCount > 0"
                            class="ml-auto bg-[#EF3B33] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] h-[18px] flex items-center justify-center shadow-lg transform translate-x-1"
                            :title="unreadOrdersCount + ' pesanan baru'"
                        >
                            {{ unreadOrdersCount > 99 ? '99+' : unreadOrdersCount }}
                        </span>
                        <div 
                            v-if="sidebarCollapsed && unreadOrdersCount > 0"
                            class="absolute top-1 right-1 w-2.5 h-2.5 bg-[#EF3B33] rounded-full border border-[#8E0D3C] shadow-sm animate-pulse"
                        ></div>
                    </a>
                </nav>

                <nav
                    :class="[
                        'space-y-3 border-t border-[#EF3B33]/30 pt-4 mt-4',
                        sidebarCollapsed ? 'px-2' : 'px-4'
                    ]"
                >
                    <a href="/terms-and-conditions" :class="[
                            'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                            sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                            ]"
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

                    <a href="/contact-us" :class="[
                            'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                            sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                            ]"
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

                <div :class="[
                    'mt-auto',
                    sidebarCollapsed ? 'p-2' : 'p-4'
                ]">
                    <button
                        @click="handleLogout"
                        :class="[
                            'w-full bg-[#EF3B33]/30 text-white font-medium py-3 rounded-lg transition hover:bg-[#EF3B33]/40 cursor-pointer',
                            sidebarCollapsed ? 'px-2 flex justify-center' : 'px-4'
                        ]"
                    >
                        <span v-if="!sidebarCollapsed">Keluar</span>
                        <svg
                            v-else
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
                    </button>
                </div>
            </aside>

            <main
                :class="[
                    'flex-1 transition-all duration-300 overflow-x-hidden',
                    sidebarCollapsed ? 'ml-16' : 'ml-64',
                ]"
            >
                <header
                    class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm px-4 sm:px-6 py-3 sm:py-4 sticky top-0 z-10"
                >
                    <div class="flex items-center justify-between gap-2 sm:gap-4">
                        <div class="flex-1 min-w-0 flex items-center gap-1.5 sm:gap-2">
                            <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 truncate">
                                Halo,
                                <template v-if="user?.name">
                                    <span class="font-semibold">{{
                                        user?.name
                                    }}</span>
                                </template>
                                <template v-else>
                                    <span>
                                        Pengunjung
                                        <span class="font-semibold italic"
                                            >U Market</span
                                        ></span
                                    >
                                </template>
                            </p>
                        </div>

                        <div class="hidden md:flex flex-1 max-w-md mx-2 md:mx-2">
                            <div class="relative w-full">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari produk, kategori, atau deskripsi..."
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
                            v-if="user"
                            @click="showMobileSearch = !showMobileSearch"
                            class="md:hidden p-1.5 sm:p-2 text-gray-600 dark:text-gray-400"
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
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </button>

                        <button
                            v-if="user"
                            @click="handleCart"
                            class="relative p-1.5 sm:p-2 text-gray-600 dark:text-gray-400"
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

                        <button
                            v-if="user"
                            @click="handleProfile"
                            class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden flex items-center justify-center ml-1 sm:ml-2"
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

                <transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="transform -translate-y-4 opacity-0"
                    enter-to-class="transform translate-y-0 opacity-100"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="transform translate-y-0 opacity-100"
                    leave-to-class="transform -translate-y-4 opacity-0"
                >
                    <div
                        v-if="showMobileSearch"
                        class="md:hidden bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 px-4 py-3 sticky top-[4.5rem] z-10 shadow-sm"
                    >
                        <div class="relative">
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Cari produk, kategori, atau deskripsi..."
                                class="w-full px-4 py-2 pl-10 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg focus:outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                autoFocus
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
                </transition>

                <div class="p-4 sm:p-6 space-y-8 w-full max-w-full overflow-x-hidden">
                    <section
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6"
                    >
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300">
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
                                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ store.name }}</p>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-[#FDA1A2]/20 to-[#EF3B33]/20 dark:from-[#8E0D3C]/30 dark:to-[#EF3B33]/20 rounded-xl p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Saldo Penjualan</p>
                                        <p class="text-3xl font-bold text-[#EF3B33] dark:text-[#FDA1A2]">Rp. {{ formatPrice(store.balance || 0) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Dari {{ store.totalSold || 0 }} penjualan</p>
                                    </div>
                                    <button
                                        @click="showWithdrawModal = true"
                                        :disabled="
                                            !store.balance || store.balance <= 0
                                        "
                                        class="px-6 py-3 bg-[#EF3B33] hover:bg-[#d92f25] disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-semibold rounded-lg shadow-md transition-all duration-150 cursor-pointer hover:shadow-lg active:scale-95 active:shadow-inner whitespace-nowrap"
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
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner',
                                    activeOrderSection === 'paid'
                                        ? 'ring-2 ring-[#EF3B33] dark:ring-[#FDA1A2]'
                                        : '',
                                ]"
                            >
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.incoming }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Pesanan Masuk</p>
                            </button>
                            <button
                                @click="showOrdersSection('processing')"
                                :class="[
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner',
                                    activeOrderSection === 'processing'
                                        ? 'ring-2 ring-[#EF3B33] dark:ring-[#FDA1A2]'
                                        : '',
                                ]"
                            >
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.needShip }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Perlu Dikirim</p>
                            </button>
                            <button
                                @click="showOrdersSection('shipping')"
                                :class="[
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner',
                                    activeOrderSection === 'shipping'
                                        ? 'ring-2 ring-[#EF3B33] dark:ring-[#FDA1A2]'
                                        : '',
                                ]"
                            >
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.shipped }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Dikirim</p>
                            </button>
                            <button
                                @click="showOrdersSection('history')"
                                :class="[
                                    'bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg p-4 text-center cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner',
                                    activeOrderSection === 'history'
                                        ? 'ring-2 ring-[#EF3B33] dark:ring-[#FDA1A2]'
                                        : '',
                                ]"
                            >
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ store.stats.history }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Riwayat Penjualan</p>
                            </button>
                        </div>
                    </section>

                    <section v-if="activeOrderSection" class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <h2 class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]">{{ getSectionTitle(activeOrderSection) }}</h2>
                                <button
                                    @click="activeOrderSection = null"
                                    class="p-1 text-gray-500 cursor-pointer transition-all duration-150 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 rounded active:scale-95"
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

                        <div v-if="ordersLoading" class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Memuat pesanan...</p>
                        </div>

                        <div v-else-if="filteredOrdersBySection.length === 0" class="text-center py-8">
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

                        <div v-else class="space-y-4">
                            <div
                                v-for="order in filteredOrdersBySection"
                                :key="order.id"
                                class="border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 rounded-lg p-4"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span
                                                class="px-2 py-1 rounded-full text-xs font-semibold"
                                                :class="getStatusClass(order.status)"
                                            >
                                                {{ getStatusLabel(order.status) }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ order.id }}</span>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Pesanan dari: {{ order.buyer_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ formatDate(order.created_at) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">Rp. {{ formatPrice(order.total_price) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ order.items.length }} item</p>
                                    </div>
                                </div>

                                <div class="space-y-2 mb-3">
                                    <div
                                        v-for="item in order.items"
                                        :key="item.id"
                                        class="flex items-center gap-3 p-2 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded"
                                    >
                                        <div class="w-12 h-12 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded flex items-center justify-center overflow-hidden flex-shrink-0 border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20">
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
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ item.product?.name || "Produk" }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ item.qty }} pcs × Rp. {{ formatPrice(item.price) }}</p>
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Rp. {{ formatPrice(item.price * item.qty) }}</p>
                                    </div>
                                </div>

                                <div
                                    v-if="order.shipping_address"
                                    class="mb-3 p-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 rounded text-xs"
                                >
                                    <p class="font-semibold text-[#8E0D3C] dark:text-[#FDA1A2] mb-1">Alamat Pengiriman:</p>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        {{ order.shipping_address.name }} -
                                        {{ order.shipping_address.phone }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ order.shipping_address.address }}
                                    </p>
                                </div>

                                <div
                                    v-if="order.tracking_number"
                                    class="mb-3 p-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 rounded text-xs"
                                >
                                    <p class="font-semibold text-[#8E0D3C] dark:text-[#FDA1A2] mb-1">Nomor Resi:</p>
                                    <p class="font-mono text-gray-900 dark:text-white">{{ order.tracking_number }}</p>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <button
                                        v-if="order.status === 'paid'"
                                        @click="
                                            updateOrderStatus(
                                                order.id,
                                                'processing'
                                            )
                                        "
                                        class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-medium cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner"
                                    >
                                        Mulai Kemas
                                    </button>
                                    <button
                                        v-if="order.status === 'processing'"
                                        @click="contactBuyer(order)"
                                        class="px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-xs font-medium cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner flex items-center gap-1"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-9.746 9.798c0 2.718.997 5.335 2.823 7.357L2.667 24l7.994-2.59a9.874 9.874 0 004.772 1.286h.005c5.432 0 9.748-4.317 9.748-9.747 0-2.605-.994-5.052-2.799-6.897a9.875 9.875 0 00-7.035-2.9"
                                            />
                                        </svg>
                                        Hubungi Pembeli
                                    </button>
                                    <button
                                        v-if="order.status === 'processing'"
                                        @click="updateOrderStatus(order.id, 'shipping')"
                                        class="px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-xs font-medium cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner"
                                    >
                                        Tandai Dikirim
                                    </button>
                                    <button
                                        v-if="order.status === 'return_requested'"
                                        @click="handleApproveReturn(order)"
                                        class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs font-medium cursor-pointer transition-all duration-150 hover:shadow-lg active:scale-95 active:shadow-inner"
                                    >
                                        Terima Pengembalian
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6 space-y-4 w-full max-w-full overflow-hidden"
                    >
                        <div class="flex items-center justify-between">
                            <h2
                                class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                            >
                                Produk
                            </h2>
                            <button
                                class="px-4 py-2 bg-[#EF3B33] text-white text-sm font-medium rounded-lg shadow-md cursor-pointer transition-all duration-150 hover:bg-[#d92f25] hover:shadow-lg active:scale-95 active:shadow-inner"
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
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
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
                                            >Foto Produk (bisa lebih dari 1)</label
                                        >
                                        <div class="flex items-center gap-3 flex-wrap">
                                            <label
                                                class="w-28 h-28 border border-dashed border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg flex items-center justify-center bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 cursor-pointer"
                                            >
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    class="hidden"
                                                    multiple
                                                    @change="onImageChange"
                                                />
                                                <span
                                                    class="text-xs text-gray-500 dark:text-gray-400"
                                                    >Upload</span
                                                >
                                            </label>
                                            <div
                                                v-for="(preview, index) in form.imagePreviews"
                                                :key="`preview-${index}`"
                                                class="relative w-28 h-28"
                                            >
                                                <img
                                                    :src="preview"
                                                    alt="preview"
                                                    class="w-full h-full object-cover rounded-lg border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                                                />
                                                <button
                                                    type="button"
                                                    class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-red-500 text-white text-xs"
                                                    @click="removeImage(index)"
                                                >
                                                    x
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="px-4 py-2 bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg cursor-pointer transition-all duration-150 hover:bg-[#1D1842]/30 dark:hover:bg-[#1D1842]/40 hover:shadow-lg active:scale-95 active:shadow-inner"
                                        @click="cancelForm"
                                    >
                                        Batal
                                    </button>
                                    <button
                                        class="px-4 py-2 bg-[#EF3B33] text-white rounded-lg shadow-md cursor-pointer transition-all duration-150 hover:bg-[#d92f25] hover:shadow-lg active:scale-95 active:shadow-inner"
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

                        <div class="overflow-x-auto -mx-4 sm:mx-0 max-w-full">
                            <div class="inline-block min-w-full align-middle">
                                <div class="overflow-hidden">
                                    <div class="grid grid-cols-[120px_150px_100px_80px_100px_100px] sm:grid-cols-6 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-sm font-semibold text-[#8E0D3C] dark:text-[#FDA1A2] rounded-lg px-4 py-3 gap-2">
                                        <div class="truncate">Nama Toko</div>
                                        <div class="truncate">Nama</div>
                                        <div class="truncate">Kategori</div>
                                        <div class="truncate">Stok</div>
                                        <div class="truncate">Harga</div>
                                        <div class="truncate">Aksi</div>
                                    </div>

                                    <div class="space-y-2 mt-2" v-if="filteredProducts.length">
                                        <div
                                            v-for="p in filteredProducts"
                                            :key="p.id"
                                            class="grid grid-cols-[120px_150px_100px_80px_100px_100px] sm:grid-cols-6 items-center bg-white dark:bg-[#1D1842] border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 rounded-lg px-4 py-4 gap-2"
                                        >
                                            <div class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ store.name }}</div>
                                            <div class="text-sm text-[#1D1842] dark:text-[#FDA1A2] font-semibold truncate">{{ p.name }}</div>
                                            <div class="text-sm text-[#EF3B33] dark:text-[#EF3B33] truncate">{{ p.category?.name || "-" }}</div>
                                            <div class="text-sm text-[#1D1842] dark:text-[#FDA1A2]">{{ p.stock }}</div>
                                            <div class="text-sm text-[#EF3B33] dark:text-[#EF3B33] font-semibold">Rp. {{ formatPrice(p.price) }}</div>
                                        <div class="flex gap-2">
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] cursor-pointer transition-all duration-150 hover:bg-[#1D1842]/30 dark:hover:bg-[#1D1842]/40 hover:shadow-md active:scale-95 active:shadow-inner"
                                                @click="editProduct(p)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-[#EF3B33]/20 dark:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#FDA1A2] cursor-pointer transition-all duration-150 hover:bg-[#EF3B33]/30 dark:hover:bg-[#EF3B33]/30 hover:shadow-md active:scale-95 active:shadow-inner"
                                                @click="deleteProduct(p.id)"
                                            >
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-else-if="products.length === 0"
                                    class="text-sm text-gray-500 dark:text-gray-400 mt-3"
                                >
                                    Belum ada produk.
                                </div>
                                <div
                                    v-else-if="searchQuery && filteredProducts.length === 0"
                                    class="text-sm text-gray-500 dark:text-gray-400 mt-3"
                                >
                                    Tidak ada produk yang cocok dengan pencarian "{{ searchQuery }}".
                                </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <transition name="modal">
            <div
                v-if="showShippingForm"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                @click.self="showShippingForm = false"
            >
                <div class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Kirim Paket</h3>
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

        <transition name="modal">
            <div
                v-if="showWithdrawModal"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                @click.self="showWithdrawModal = false"
            >
                <div class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tarik Saldo</h3>
                    <div class="space-y-4">
                        <div class="bg-[#FDA1A2]/10 dark:bg-[#8E0D3C]/20 rounded-lg p-4 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Saldo Tersedia</p>
                            <p class="text-2xl font-bold text-[#EF3B33] dark:text-[#FDA1A2]">Rp. {{ formatPrice(store.balance || 0) }}</p>
                        </div>

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
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Contoh: Rp 100.000 atau 100000</p>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                            >
                                Rekening Tujuan
                            </label>
                            <select
                                v-if="userBanks.length > 0"
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
                            <div v-else class="p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                <p class="text-sm text-yellow-700 dark:text-yellow-300 mb-2">
                                    Anda belum menambahkan rekening bank.
                                </p>
                                <a href="/profile" class="text-[#EF3B33] font-semibold text-sm hover:underline">Tambah rekening di profil &rarr;</a>
                            </div>
                            <p v-if="userBanks.length > 0" class="text-xs text-gray-500 dark:text-gray-400 mt-1"><a href="/profile" class="text-[#EF3B33] hover:underline">Kelola rekening di profil</a></p>
                        </div>

                        <div
                            v-if="withdrawError"
                            class="bg-red-100 dark:bg-red-900/30 border border-red-300 dark:border-red-700 text-red-700 dark:text-red-300 text-sm px-4 py-3 rounded-lg"
                        >
                            {{ withdrawError }}
                        </div>

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

        <ConfirmModal
            :visible="confirmModal.visible"
            :title="confirmModal.title"
            :message="confirmModal.message"
            @confirm="handleConfirm"
            @cancel="closeConfirmModal"
        />

        <ToastNotification
            :visible="toast.visible"
            :message="toast.message"
            :type="toast.type"
            @close="toast.visible = false"
        />
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import axios from "axios";
import ConfirmModal from "../components/ConfirmModal.vue";
import ToastNotification from "../components/ToastNotification.vue";

const sidebarCollapsed = ref(window.innerWidth <= 768);
const user = ref(null);
const cartCount = ref(0);
const searchQuery = ref("");
const showMobileSearch = ref(false);
const confirmModal = ref({ visible: false, title: "", message: "", onConfirm: null });
const toast = ref({ visible: false, message: "", type: "success" });
const unreadOrdersCount = ref(0);

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
    imageFiles: [],
    imagePreviews: [],
});

const incomingOrders = ref([]);
const ordersLoading = ref(false);
const activeOrderSection = ref(null);
const showShippingForm = ref(false);
const selectedOrderId = ref(null);
const trackingNumber = ref("");
const shippingCourier = ref("");

const showWithdrawModal = ref(false);
const withdrawAmount = ref("");
const withdrawAmountNumber = ref(0);
const withdrawBankId = ref("");
const withdrawError = ref("");
const withdrawProcessing = ref(false);
const userBanks = ref([]);
const orderFilterStatus = ref("");

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const filteredProducts = computed(() => {
    if (!searchQuery.value || !searchQuery.value.trim()) {
        return products.value;
    }
    
    const q = searchQuery.value.toLowerCase().trim();
    return products.value.filter((product) => {
        const name = (product.name || "").toLowerCase();
        const category = (product.category?.name || "").toLowerCase();
        const description = (product.description || "").toLowerCase();
        
        return (
            name.includes(q) ||
            category.includes(q) ||
            description.includes(q)
        );
    });
});

const parsePrice = (priceString) => {
    if (!priceString) return 0;
    const cleaned = priceString.toString().replace(/[^\d.]/g, "");
    const numberString = cleaned.replace(/\./g, "");
    const parsed = parseInt(numberString, 10);
    return isNaN(parsed) ? 0 : parsed;
};

const formatPriceString = (price) => {
    if (!price || price === 0) return "";
    return `Rp ${formatPrice(price)}`;
};

const priceInput = ref("");

const handlePriceInput = (event) => {
    const value = event.target.value;
    priceInput.value = value;
    form.value.price = parsePrice(value);
};

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
        unpaid: "Menunggu Pembayaran",
        pending: "Menunggu Pembayaran",
        paid: "Sudah Dibayar",
        processing: "Sedang Dikemas",
        shipping: "Sedang Dikirim",
        delivered: "Sudah Diterima",
        completed: "Selesai",
        failed: "Dibatalkan",
        cancelled: "Dibatalkan",
        canceled: "Dibatalkan",
        expired: "Dibatalkan",
        return_requested: "Proses Pengembalian",
        returned: "Dikembalikan",
    };
    return labels[status] || status;
};

const getStatusClass = (status) => {
    const classes = {
        unpaid:
            "bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300",
        pending:
            "bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300",
        paid: "bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300",
        processing:
            "bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300",
        shipping:
            "bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300",
        delivered:
            "bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300",
        completed:
            "bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300",
        returned:
            "bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300",
        cancelled:
            "bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300",
        canceled:
            "bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300",
        failed:
            "bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300",
        expired: "bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300",
        return_requested: "bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300",
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
        filtered = filtered.filter(
            (order) =>
                order.status === "pending" ||
                order.status === "unpaid" ||
                order.status === "paid"
        );
    } else if (activeOrderSection.value === "processing") {
        filtered = filtered.filter((order) => order.status === "processing");
    } else if (activeOrderSection.value === "shipping") {
        filtered = filtered.filter((order) => order.status === "shipping" || order.status === "return_requested");
    } else if (activeOrderSection.value === "history") {
        filtered = filtered.filter(
            (order) =>
                order.status === "completed" || 
                order.status === "delivered" ||
                order.status === "expired" ||
                order.status === "failed" ||
                order.status === "cancelled" ||
                order.status === "canceled" ||
                order.status === "returned"
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


const handleLogout = () => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }

    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Keluar",
        message: "Apakah Anda yakin ingin keluar?"
    };
};

const closeConfirmModal = () => {
    confirmModal.value.visible = false;
};

const handleConfirm = async () => {
    if (confirmModal.value.onConfirm && typeof confirmModal.value.onConfirm === 'function') {
        const onConfirmFn = confirmModal.value.onConfirm;
        
        confirmModal.value.visible = false;
        confirmModal.value.onConfirm = null;
        
        try {
            await onConfirmFn();
        } catch (error) {
            console.error("Error in confirm action:", error);
            toast.value = {
                visible: true,
                message: error.response?.data?.message || "Terjadi kesalahan",
                type: "error"
            };
        }
    } else {
        handleConfirmLogout();
    }
};

const handleConfirmLogout = async () => {
    closeConfirmModal();
    
    try {
        await axios.post("/logout");
        window.location.href = "/";
    } catch (error) {
        console.error("Error logging out:", error);
        window.location.href = "/";
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
        imageFiles: [],
        imagePreviews: [],
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
        imageFiles: [],
        imagePreviews: Array.isArray(p.image_urls) ? p.image_urls : [p.image_url].filter(Boolean),
    };
    priceInput.value = p.price > 0 ? formatPriceString(p.price) : "";
    showForm.value = true;
};

const deleteProduct = (id) => {
    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Hapus",
        message: "Hapus produk ini?",
        onConfirm: async () => {
            try {
                await axios.delete(`/api/products/${id}`);
                await fetchProducts();
                
                toast.value = {
                    visible: true,
                    message: "Produk berhasil dihapus",
                    type: "success"
                };
            } catch (error) {
                toast.value = {
                    visible: true,
                    message: "Gagal menghapus produk",
                    type: "error"
                };
            }
        }
    };
};

const submitForm = async () => {
    const missingFields = [];

    if (!form.value.name || !form.value.name.trim()) {
        missingFields.push("Nama produk");
    }
    if (!form.value.category || !form.value.category.trim()) {
        missingFields.push("Kategori");
    }
    if (form.value.price === null || form.value.price === "" || Number(form.value.price) <= 0) {
        missingFields.push("Harga");
    }
    if (form.value.stock === null || form.value.stock === "" || Number(form.value.stock) < 0) {
        missingFields.push("Stok");
    }
    if (!form.value.id && (!form.value.imageFiles || form.value.imageFiles.length === 0)) {
        missingFields.push("Foto produk");
    }

    if (missingFields.length > 0) {
        toast.value = {
            visible: true,
            message:
                "Lengkapi data produk terlebih dahulu: " +
                missingFields.join(", "),
            type: "error",
        };
        return;
    }
    const payload = new FormData();
    payload.append("name", form.value.name);
    payload.append("category", form.value.category || "");
    payload.append("description", form.value.description || "");
    payload.append("price", form.value.price);
    payload.append("stock", form.value.stock);
    if (form.value.imageFiles.length > 0) {
        form.value.imageFiles.forEach((file) => {
            payload.append("images[]", file);
        });
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

        if (!form.value.id && response.data) {
            const newProduct = {
                ...response.data,
                image_url: response.data.image_url || null,
            };
            products.value.unshift(newProduct);
        } else if (form.value.id && response.data) {
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

        await fetchProducts();
        resetForm();
        showForm.value = false;
    } catch (error) {
        console.error("Error saving product:", error);

        let message = "Gagal menyimpan produk. ";

        if (error.response?.status === 422 && error.response.data?.errors) {
            const errors = error.response.data.errors;
            const firstField = Object.keys(errors)[0];
            const firstError = errors[firstField]?.[0];
            message += firstError || "Pastikan semua data produk sudah diisi dengan benar.";
        } else if (error.response?.data?.message) {
            if (error.response.data.message === "Server Error") {
                message += "Terjadi kesalahan pada server. Coba lagi beberapa saat lagi.";
            } else {
                message += error.response.data.message;
            }
        } else {
            message += "Silakan cek koneksi internet Anda dan coba lagi.";
        }

        toast.value = {
            visible: true,
            message,
            type: "error",
        };
    }
};

const resizeImage = (file, maxWidth, maxHeight) => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = (e) => {
            const img = new Image();
            img.src = e.target.result;
            img.onload = () => {
                const canvas = document.createElement("canvas");
                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob(
                    (blob) => {
                        if (blob) {
                            const resizedFile = new File([blob], file.name, {
                                type: "image/jpeg",
                                lastModified: Date.now(),
                            });
                            resolve(resizedFile);
                        } else {
                            reject(new Error("Canvas to Blob failed"));
                        }
                    },
                    "image/jpeg",
                    0.8
                );
            };
            img.onerror = (err) => reject(err);
        };
        reader.onerror = (err) => reject(err);
    });
};

const onImageChange = async (event) => {
    const files = Array.from(event.target.files || []);
    if (!files.length) return;

    for (const file of files) {
        try {
            const resizedFile = await resizeImage(file, 1200, 1200);
            form.value.imageFiles.push(resizedFile);
            form.value.imagePreviews.push(URL.createObjectURL(resizedFile));
        } catch (error) {
            form.value.imageFiles.push(file);
            form.value.imagePreviews.push(URL.createObjectURL(file));
        }
    }
};

const removeImage = (index) => {
    form.value.imageFiles.splice(index, 1);
    form.value.imagePreviews.splice(index, 1);
};

const fetchProducts = async () => {
    if (!user.value) {
        console.log("User not authenticated, cannot fetch products");
        products.value = [];
        return;
    }
    try {
        const response = await axios.get("/api/my-products");
        const fetchedProducts = Array.isArray(response.data)
            ? response.data
            : [];

        console.log("Fetched products count:", fetchedProducts.length);

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
    if (photoUrl.includes("?")) {
        return photoUrl.split("?")[0] + "?t=" + Date.now();
    }
    return photoUrl + "?t=" + Date.now();
};

const checkAuth = async () => {
    try {
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

const handleUserUpdated = async (event) => {
    await checkAuth();
};

const fetchCartCount = async () => {
    if (!user.value) {
        cartCount.value = 0;
        return;
    }
    try {
        const response = await axios.get("/api/cart/count", {
            params: { _t: Date.now() }
        });
        const newCount = response.data?.count ?? 0;
        cartCount.value = newCount;
    } catch (error) {
        console.error("Error fetching cart count:", error);
        cartCount.value = 0;
    }
};

const fetchUnreadOrdersCount = async () => {
    if (!user.value) return;
    try {
        const response = await axios.get("/api/seller/unread-orders-count");
        unreadOrdersCount.value = response.data.count || 0;
    } catch (error) {
        console.error("Error fetching unread orders count:", error);
    }
};

const markOrdersAsRead = async () => {
    if (!user.value) return;
    try {
        await axios.post("/api/seller/mark-orders-as-read");
        unreadOrdersCount.value = 0;
        // Dispatch event for other pages
        window.dispatchEvent(new CustomEvent('sellerOrdersOptimized'));
    } catch (error) {
        console.error("Error marking orders as read:", error);
    }
};

const fetchIncomingOrders = async () => {
    if (!user.value) {
        ordersLoading.value = false;
        return;
    }

    try {
        ordersLoading.value = true;
        const response = await axios.get("/api/seller/orders");
        const orders = response.data || [];

        incomingOrders.value = orders;

        store.value.stats = {
            incoming: orders.filter(
                (o) => o.status === "pending" || o.status === "unpaid" || o.status === "paid"
            ).length,
            needShip: orders.filter((o) => o.status === "processing").length,
            shipped: orders.filter((o) => o.status === "shipping" || o.status === "return_requested").length,
            history: orders.filter(
                (o) => o.status === "completed" || o.status === "delivered"
                    || o.status === "returned"
                    || o.status === "expired"
                    || o.status === "failed"
                    || o.status === "cancelled"
                    || o.status === "canceled"
            ).length,
        };
    } catch (error) {
        console.error("Error fetching incoming orders:", error);
        incomingOrders.value = [];
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

const updateOrderStatus = (orderId, newStatus) => {
    confirmModal.value = {
        visible: true,
        title: "Konfirmasi",
        message: `Ubah status pesanan menjadi "${getStatusLabel(newStatus)}"?`,
        onConfirm: async () => {
            try {
                await axios.post(`/api/seller/orders/${orderId}/update-status`, {
                    status: newStatus,
                });

                await fetchIncomingOrders();
                
                toast.value = {
                    visible: true,
                    message: "Status pesanan berhasil diupdate",
                    type: "success"
                };
            } catch (error) {
                console.error("Error updating order status:", error);
                const message =
                    error.response?.data?.message || "Gagal mengupdate status";
                toast.value = {
                    visible: true,
                    message: message,
                    type: "error"
                };
            }
        }
    };
};

const handleApproveReturn = (order) => {
    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Pengembalian",
        message: `Apakah Anda yakin ingin menyetujui pengembalian untuk pesanan #${order.id}?`,
        onConfirm: async () => {
            try {
                await axios.post(`/api/seller/orders/${order.id}/approve-return`);
                
                await fetchIncomingOrders();
                
                toast.value = {
                    visible: true,
                    message: "Pengembalian berhasil disetujui",
                    type: "success"
                };
            } catch (error) {
                console.error("Error approving return:", error);
                const message = error.response?.data?.message || "Gagal memproses pengembalian";
                toast.value = {
                    visible: true,
                    message: message,
                    type: "error"
                };
            }
        }
    };
};

const contactBuyer = (order) => {
    let phoneNumber = null;
    let buyerName = order.buyer_name || "Pembeli";

    if (order.shipping_address?.phone) {
        phoneNumber = order.shipping_address.phone;
        buyerName = order.shipping_address.name || buyerName;
    }
    else if (order.user?.phone) {
        phoneNumber = order.user.phone;
        buyerName = order.user.name || buyerName;
    }

    if (!phoneNumber) {
        toast.value = {
            visible: true,
            message: "Nomor WhatsApp pembeli tidak tersedia",
            type: "error"
        };
        return;
    }

    phoneNumber = phoneNumber.toString().replace(/[^\d+]/g, "");

    if (phoneNumber.startsWith("0")) {
        phoneNumber = "62" + phoneNumber.substring(1);
    }

    if (!phoneNumber.startsWith("+")) {
        phoneNumber = "+" + phoneNumber;
    }

    const orderId = order.id;
    const itemsList = order.items.map(item => 
        `- ${item.product?.name || 'Produk'} (${item.qty || item.quantity || 0} pcs)`
    ).join('\n');
    const message = `Halo ${buyerName},\n\nSaya ingin mengkonfirmasi pesanan Anda.\n\nID Pesanan: #${orderId}\nProduk:\n${itemsList}\nTotal: Rp. ${formatPrice(order.total_price || 0)}\n\nTerima kasih.`;

    const whatsappUrl = `https://wa.me/${phoneNumber.replace("+", "")}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, "_blank");
};

const confirmShipping = async () => {
    if (!trackingNumber.value.trim()) {
        toast.value = {
            visible: true,
            message: "Masukkan nomor resi terlebih dahulu",
            type: "error"
        };
        return;
    }

    try {
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

        await fetchIncomingOrders();
        
        toast.value = {
            visible: true,
            message: "Paket berhasil dikonfirmasi dikirim",
            type: "success"
        };
    } catch (error) {
        console.error("Error confirming shipping:", error);
        const message =
            error.response?.data?.message || "Gagal mengkonfirmasi pengiriman";
        toast.value = {
            visible: true,
            message: message,
            type: "error"
        };
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

    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Penarikan Saldo",
        message: `Tarik saldo Rp ${formatPrice(withdrawAmountNumber.value)}?\n\nPencairan akan diproses dalam 1-2 hari kerja.`,
        onConfirm: async () => {
            try {
                withdrawProcessing.value = true;

                const response = await axios.post("/seller-withdraw", {
                    amount: withdrawAmountNumber.value,
                    bank_account_id: withdrawBankId.value,
                });

                withdrawAmount.value = "";
                withdrawAmountNumber.value = 0;
                withdrawBankId.value = "";
                showWithdrawModal.value = false;

                await fetchSellerBalance();
                
                toast.value = {
                    visible: true,
                    message: "Permintaan penarikan berhasil dibuat! Status dapat dipantau di halaman profil Anda.",
                    type: "success"
                };
            } catch (error) {
                console.error("Error withdrawing balance:", error);
                withdrawError.value =
                    error.response?.data?.message || "Gagal memproses penarikan saldo";
                toast.value = {
                    visible: true,
                    message: error.response?.data?.message || "Gagal memproses penarikan saldo",
                    type: "error"
                };
            } finally {
                withdrawProcessing.value = false;
            }
        }
    };
};

const fetchSellerBalance = async () => {
    if (!user.value) return;

    try {
        const response = await axios.get("/seller-balance");
        store.value.balance = response.data.balance || 0;
        store.value.totalSold = response.data.total_sold || 0;
    } catch (error) {
        console.error("Error fetching seller balance:", error);
        store.value.balance = 0;
        store.value.totalSold = 0;
    }
};

const fetchUserBanks = async () => {
    if (!user.value) return;

    try {
        const response = await axios.get("/user-banks");
        userBanks.value = response.data || [];
    } catch (error) {
        console.error("Error fetching user banks:", error);
        userBanks.value = [];
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
        await fetchUnreadOrdersCount();
        
        // Mark as read when shop page is accessed
        await markOrdersAsRead();
    }

    window.addEventListener("cartUpdated", fetchCartCount);

    window.addEventListener("userUpdated", handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener("cartUpdated", fetchCartCount);
    window.removeEventListener("userUpdated", handleUserUpdated);
    window.removeEventListener("sellerOrdersOptimized", fetchUnreadOrdersCount);
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

@media (max-width: 640px) {
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    
    .overflow-x-auto::-webkit-scrollbar {
        display: none;
    }
}
</style>
