<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="flex">
            <!-- Left Sidebar - Hanya muncul di desktop jika user sudah login -->
            <aside
                v-if="user"
                :class="[
                    'bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                    sidebarCollapsed ? 'w-16' : 'w-64',
                ]"
            >
                <!-- Logo & Toggle Button -->
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
                            'p-2 rounded-lg hover:bg-[#EF3B33]/20 transition',
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
                    <a
                        href="#"
                        :class="[
                            'flex items-center rounded-lg bg-[#FDA1A2]/30 text-white font-medium transition',
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

                    <a
                        href="#"
                        @click.prevent="handleMyOrders"
                        :class="[
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

                    <a
                        href="#"
                        @click.prevent="handleOpenShop"
                        :class="[
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
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Buka Toko</span>
                    </a>
                </nav>

                <nav
                    :class="[
                        'space-y-3 border-t border-[#EF3B33]/30 pt-4 mt-4',
                        sidebarCollapsed ? 'px-2' : 'px-4'
                    ]"
                >
                    <a
                        href="/terms-and-conditions"
                        :class="[
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

                    <a
                        href="/contact-us"
                        :class="[
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

            <!-- Main Content -->
            <main
                :class="[
                    'flex-1 transition-all duration-300',
                    user && sidebarCollapsed
                        ? 'ml-16'
                        : user
                        ? 'ml-64'
                        : 'ml-0',
                ]"
            >
                <!-- Header -->
                <header
                    class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm px-4 sm:px-6 py-3 sm:py-4 sticky top-0 z-10"
                >
                    <div class="flex items-center justify-between gap-2 sm:gap-4">
                        <!-- Greeting -->
                        <div class="flex-1 min-w-0" :class="user ? '' : 'mx-2 sm:mx-6'">
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

                        <!-- Search Bar (Desktop) -->
                        <div class="hidden md:flex flex-1 mx-2 md:mx-4">
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

                        <!-- Search Icon (Mobile only) -->
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

                        <!-- Cart Icon - Hanya muncul jika user sudah login -->
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

                        <!-- Profile Icon / Login Button -->
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
                        <button
                            v-else
                            @click="goToLogin"
                            class="px-3 py-1.5 sm:px-4 sm:py-2 bg-[#EF3B33] text-white text-sm sm:text-base font-medium rounded-lg shadow-md"
                        >
                            Login
                        </button>
                    </div>
                </header>

                <!-- Mobile Search Bar (Expandable) -->
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
                                placeholder="Cari produk..."
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

                <!-- Website Info Card (hanya tampil jika bukan dari tombol back login) -->
                <div v-if="showWelcomeCard && !user" class="p-3 sm:p-6 pb-0">
                    <div class="bg-[#FDA1A2]/30 dark:bg-[#8E0D3C]/30 rounded-2xl shadow-lg overflow-hidden border border-[#FDA1A2]/50 dark:border-[#8E0D3C]/50">
                        <div class="p-4 sm:p-6 md:p-8">
                            <div class="flex flex-col md:flex-row items-center gap-6">
                                <!-- Info Content -->
                                <div class="flex-1 text-center md:text-left">
                                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#8E0D3C] dark:text-[#FDA1A2] mb-2">
                                        Selamat Datang di <span class="text-[#EF3B33]">U Market</span>
                                    </h2>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm md:text-base leading-relaxed mb-4">
                                        Platform e-commerce terpercaya untuk mahasiswa dan masyarakat umum. 
                                        Temukan berbagai produk berkualitas dari penjual lokal atau mulai buka toko Anda sendiri!
                                    </p>
                                    
                                    <!-- Features -->
                                    <div class="flex flex-wrap justify-center md:justify-start gap-3">
                                        <div class="flex items-center gap-2 bg-white/60 dark:bg-[#1D1842]/60 px-3 py-1.5 rounded-full">
                                            <svg class="w-4 h-4 text-[#EF3B33]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-[#8E0D3C] dark:text-[#FDA1A2] text-xs font-medium">Gratis Daftar</span>
                                        </div>
                                        <div class="flex items-center gap-2 bg-white/60 dark:bg-[#1D1842]/60 px-3 py-1.5 rounded-full">
                                            <svg class="w-4 h-4 text-[#EF3B33]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            <span class="text-[#8E0D3C] dark:text-[#FDA1A2] text-xs font-medium">Transaksi Aman</span>
                                        </div>
                                        <div class="flex items-center gap-2 bg-white/60 dark:bg-[#1D1842]/60 px-3 py-1.5 rounded-full">
                                            <svg class="w-4 h-4 text-[#EF3B33]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <span class="text-[#8E0D3C] dark:text-[#FDA1A2] text-xs font-medium">Buka Toko Sendiri</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CTA Button -->
                                <div class="flex-shrink-0">
                                    <button
                                        @click="goToLoginFromWelcome"
                                        class="bg-white dark:bg-[#1D1842] text-[#8E0D3C] dark:text-[#FDA1A2] font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-xl shadow-lg border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 text-sm sm:text-base"
                                    >
                                        Mulai Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="p-3 sm:p-6">
                    <div v-if="loading" class="text-center py-12">
                        <p class="text-gray-600 dark:text-gray-400">
                            Memuat produk...
                        </p>
                    </div>

                    <div
                        v-else-if="filteredProducts.length === 0"
                        class="text-center py-12"
                    >
                        <p class="text-gray-600 dark:text-gray-400">
                            Tidak ada produk ditemukan.
                        </p>
                    </div>

                    <div
                        v-else
                        class="grid gap-2 sm:gap-3"
                        style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));"
                    >
                        <div
                            v-for="product in filteredProducts"
                            :key="product.id"
                            class="relative bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 overflow-hidden shadow-md cursor-pointer"
                            @click="goToProductDetail(product.id)"
                        >
                            <!-- Product Image -->
                            <div
                                class="w-full h-28 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 flex items-center justify-center overflow-hidden"
                            >
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

                            <!-- Product Info -->
                            <div class="p-2 pb-1">
                                <p
                                    @click.stop="goToStore(product.user_id || product.user?.id)"
                                    class="text-[10px] font-semibold text-gray-500 dark:text-gray-400 hover:text-[#EF3B33] cursor-pointer transition-colors"
                                >
                                    {{
                                        product.store_name ||
                                        product.user?.name ||
                                        "Toko"
                                    }}
                                </p>
                                <h3
                                    class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2"
                                >
                                    {{ product.name }}
                                </h3>
                                <p
                                    class="text-base font-bold text-[#EF3B33] dark:text-[#EF3B33] mb-1"
                                >
                                    Rp. {{ formatPrice(product.price) }}
                                </p>

                                <div
                                    class="mt-2 flex flex-col gap-2"
                                    @click.stop
                                >
                                    <div
                                        class="w-full flex items-center justify-between px-1 py-0.5 border border-[#EF3B33]/30 dark:border-[#EF3B33]/30 rounded-md bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10"
                                    >
                                        <button
                                            @click.stop="
                                                decreaseQuantity(product.id)
                                            "
                                            class="p-1 text-gray-600 dark:text-gray-400 cursor-pointer transition-all duration-150 hover:text-[#EF3B33] hover:bg-[#EF3B33]/20 active:scale-95 flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-3 h-3"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M20 12H4"
                                                />
                                            </svg>
                                        </button>
                                        <span
                                            class="text-xs text-gray-900 dark:text-white font-medium text-center flex-1"
                                            >{{ getQuantity(product.id) }}</span
                                        >
                                        <button
                                            @click.stop="
                                                increaseQuantity(product.id)
                                            "
                                            class="p-1 text-gray-600 dark:text-gray-400 cursor-pointer transition-all duration-150 hover:text-[#EF3B33] hover:bg-[#EF3B33]/20 active:scale-95 flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-3 h-3"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 4v16m8-8H4"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                    <button
                                        @click.stop="handleAddToCart(product)"
                                        class="w-full bg-[#EF3B33] text-white font-medium py-1.5 px-2 rounded-md text-xs cursor-pointer transition-all duration-150 hover:bg-[#d92f25] hover:shadow-lg active:scale-95 active:shadow-inner active:bg-[#c0271f]"
                                    >
                                        Tambah Keranjang
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Legacy Notification removed -->

        <!-- Login Required Modal -->
        <transition name="modal">
            <div
                v-if="showLoginModal"
                class="fixed inset-0 bg-white bg-opacity-10 dark:bg-gray-900 dark:bg-opacity-10 flex items-center justify-center z-50 p-4 backdrop-blur-md"
                @click.self="closeLoginModal"
            >
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full transform transition-all modal-content"
                >
                    <!-- Card Header -->
                    <div class="bg-[#FDA1A2] rounded-t-2xl p-6">
                        <div class="flex items-center justify-center mb-2">
                            <div
                                class="w-16 h-16 bg-white rounded-full flex items-center justify-center"
                            >
                                <img
                                    src="/images/logo-u.png"
                                    alt="U Marketplace Logo"
                                    class="w-10 h-10 object-contain"
                                />
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white text-center">
                            Login Diperlukan
                        </h3>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <p
                            class="text-gray-700 dark:text-gray-300 text-center mb-6 leading-relaxed"
                        >
                            Anda harus melakukan
                            <span
                                class="font-semibold text-[#8E0D3C] dark:text-[#FDA1A2]"
                                >login</span
                            >
                            sebelum melakukan aksi lebih lanjut.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <button
                                @click="closeLoginModal"
                                class="flex-1 px-4 py-3 bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] font-medium rounded-lg"
                            >
                                Batal
                            </button>
                            <button
                                @click="goToLogin"
                                class="flex-1 px-4 py-3 bg-[#FDA1A2] text-white font-medium rounded-lg shadow-lg"
                            >
                                Login
                            </button>
                        </div>
                    </div>

                    <!-- Decorative bottom border -->
                    <div class="h-1 bg-[#FDA1A2] rounded-b-2xl"></div>
                </div>
            </div>
        </transition>
        <!-- Toast Notification -->
        <ToastNotification
            :visible="toast.visible"
            :message="toast.message"
            :type="toast.type"
            @close="handleToastClose"
        />

        <!-- Confirm Modal untuk Logout -->
        <ConfirmModal
            :visible="confirmModal.visible"
            :title="confirmModal.title"
            :message="confirmModal.message"
            @confirm="handleConfirmLogout"
            @cancel="closeConfirmModal"
        />
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount, nextTick } from "vue";
import axios from "axios";
import Logo from "../components/Logo.vue";
import ToastNotification from "../components/ToastNotification.vue";
import ConfirmModal from "../components/ConfirmModal.vue";

const sidebarCollapsed = ref(false);
const mobileMenuOpen = ref(false);
const showMobileSearch = ref(false);
const products = ref([]);
const loading = ref(true);
const searchQuery = ref("");
const quantities = ref({});
const user = ref(window.auth_user || null);
const cartCount = ref(0);
const showLoginModal = ref(false);
const showWelcomeCard = ref(true);
const toast = ref({ visible: false, message: "", type: "success" });
const confirmModal = ref({ visible: false, title: "", message: "" });

// Cek apakah user kembali dari halaman login (tidak jadi login)
const checkWelcomeCardVisibility = () => {
    const hideWelcome = sessionStorage.getItem('hideWelcomeCard');
    if (hideWelcome === 'true') {
        showWelcomeCard.value = false;
    }
};

// Fungsi untuk navigasi ke login dari welcome card
const goToLoginFromWelcome = () => {
    // Set flag agar saat back, card tidak muncul
    sessionStorage.setItem('hideWelcomeCard', 'true');
    window.location.href = '/login?from=welcome';
};

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const filteredProducts = computed(() => {
    if (!searchQuery.value) {
        return products.value;
    }
    const query = searchQuery.value.toLowerCase();
    return products.value.filter((product) => {
        const productName = product.name.toLowerCase();
        const storeName = (product.store_name || product.user?.name || "").toLowerCase();
        const description = (product.description || "").toLowerCase();
        return productName.includes(query) || storeName.includes(query) || description.includes(query);
    });
});

const getQuantity = (productId) => {
    return quantities.value[productId] || 0;
};

const increaseQuantity = (productId) => {
    if (!quantities.value[productId]) {
        quantities.value[productId] = 0;
    }
    quantities.value[productId]++;
};

const decreaseQuantity = (productId) => {
    if (!quantities.value[productId] || quantities.value[productId] <= 0) {
        quantities.value[productId] = 0;
        return;
    }
    quantities.value[productId]--;
};

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price);
};

const getProductCategory = (name) => {
    // Simple category extraction from product name
    const categories = ["Mochi", "Risol", "Pie", "Kue", "Snack"];
    for (const category of categories) {
        if (name.toLowerCase().includes(category.toLowerCase())) {
            return category;
        }
    }
    return "Produk";
};

const getPhotoUrl = (photoUrl) => {
    if (!photoUrl) return null;
    
    // Jika path tidak diawali dengan /storage/ dan bukan full URL, tambahkan /storage/
    if (!photoUrl.startsWith("/storage/") && !photoUrl.startsWith("http")) {
        photoUrl = "/storage/" + photoUrl;
    }

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
    } catch (error) {
        // 401 adalah expected jika user belum login (halaman landing bisa diakses tanpa login)
        // Jadi kita tidak perlu log error untuk 401
        if (error.response?.status !== 401) {
            console.error("Error checking auth:", error);
        }
        user.value = null;
    }
};

const fetchProducts = async () => {
    try {
        loading.value = true;
        const response = await axios.get("/api/products");
        products.value = response.data || [];

        console.log("Fetched products from API:", products.value);
    } catch (error) {
        console.error("Error fetching products:", error);
        products.value = [];
    } finally {
        loading.value = false;
    }
};

// Simpan product ID yang baru ditambahkan untuk reset quantity setelah toast tertutup
const lastAddedProductId = ref(null);

const handleToastClose = async () => {
    toast.value.visible = false;
    // Reset quantity selector ke 0 untuk produk yang baru ditambahkan
    if (lastAddedProductId.value !== null) {
        quantities.value[lastAddedProductId.value] = 0;
        lastAddedProductId.value = null;
    }
    
    // Fetch cart count lagi setelah toast tertutup untuk memastikan update
    if (user.value) {
        await fetchCartCount();
        // Pastikan reactivity dengan nextTick
        await nextTick();
    }
};

const handleAddToCart = async (product) => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    const quantity = getQuantity(product.id);

    // Validasi: quantity harus lebih dari 0
    if (quantity <= 0) {
        toast.value = { visible: true, message: "Jumlah produk harus lebih dari 0", type: "error" };
        return;
    }

    // Validasi: quantity tidak boleh melebihi stok
    const stock = product.stock || 0;
    if (quantity > stock) {
        toast.value = { visible: true, message: `Stok tidak mencukupi. Sisa stok: ${stock}`, type: "error" };
        return;
    }

    // Optimistic update: tampilkan toast langsung tanpa menunggu API
    toast.value = { visible: true, message: "Produk berhasil ditambahkan ke keranjang", type: "success" };
    
    // Simpan product ID untuk reset quantity setelah toast tertutup
    lastAddedProductId.value = product.id;

    try {
        // Tambahkan produk ke cart via API
        await axios.post("/api/cart/add", {
            product_id: product.id,
            quantity: quantity,
        });

        // Fetch cart count untuk update yang akurat (cek apakah produk baru atau update existing)
        // Cart count hanya bertambah jika produk baru, tidak bertambah jika produk sudah ada
        // Pastikan fetch dilakukan dan update cartCount
        await fetchCartCount();
        
        // Pastikan reactivity dengan nextTick
        await nextTick();

        // Trigger cart update event for other components
        window.dispatchEvent(new CustomEvent("cartUpdated"));

    } catch (error) {
        console.error("Error adding to cart:", error);
        const message =
            error.response?.data?.message ||
            "Gagal menambahkan produk ke keranjang";
        
        // Tutup toast sukses dan tampilkan error
        toast.value = { visible: true, message: message, type: "error" };
    }
};

const fetchCartCount = async () => {
    if (!user.value) {
        cartCount.value = 0;
        return;
    }

    try {
        const response = await axios.get("/api/cart/count", {
            params: { _t: Date.now() } // Cache busting untuk memastikan data terbaru
        });
        const newCount = response.data?.count ?? 0;
        // Pastikan update dengan assign langsung
        cartCount.value = newCount;
    } catch (error) {
        console.error("Error fetching cart count:", error);
        cartCount.value = 0;
    }
};

const handleMyOrders = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = "/orders";
};

const handleOpenShop = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = "/open-shop";
};

const handleCart = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = "/cart";
};

const handleProfile = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    window.location.href = "/profile";
};

const goToProductDetail = (productId) => {
    window.location.href = `/product/${productId}`;
};

const goToStore = (userId) => {
    if (!userId) return;
    window.location.href = `/store/${userId}`;
};

const handleLogout = () => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }

    // Tampilkan confirm modal
    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Keluar",
        message: "Apakah Anda yakin ingin keluar?"
    };
};

const closeConfirmModal = () => {
    confirmModal.value.visible = false;
};

const handleConfirmLogout = async () => {
    closeConfirmModal();
    
    try {
        await axios.post("/logout");
        sessionStorage.removeItem('hideWelcomeCard');
        window.location.href = "/";
    } catch (error) {
        console.error("Error logging out:", error);
        sessionStorage.removeItem('hideWelcomeCard');
        window.location.href = "/";
    }
};

const closeLoginModal = () => {
    showLoginModal.value = false;
};

const goToLogin = () => {
    window.location.href = "/login";
};

// Handler untuk update user data (setelah edit profil)
const handleUserUpdated = async (event) => {
    // Refresh user data untuk update foto profil
    await checkAuth();
};

onMounted(async () => {
    // Cek apakah welcome card harus disembunyikan (user kembali dari login)
    checkWelcomeCardVisibility();
    
    await checkAuth();
    await fetchProducts();
    await fetchCartCount();

    // Listen untuk cart update event
    window.addEventListener("cartUpdated", fetchCartCount);

    // Listen untuk user update event (setelah edit profil)
    window.addEventListener("userUpdated", handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener("cartUpdated", fetchCartCount);
    window.removeEventListener("userUpdated", handleUserUpdated);
});
</script>

<style scoped>
/* Sidebar sudah menggunakan fixed positioning */

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

/* Modal Animation */
.modal-enter-active {
    transition: opacity 0.3s ease;
}

.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-active .modal-content {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
        opacity 0.3s ease;
}

.modal-leave-active .modal-content {
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.modal-enter-from {
    opacity: 0;
}

.modal-leave-to {
    opacity: 0;
}

.modal-enter-from .modal-content {
    transform: scale(0.8) translateY(-30px);
    opacity: 0;
}

.modal-leave-to .modal-content {
    transform: scale(0.95) translateY(10px);
    opacity: 0;
}

</style>
