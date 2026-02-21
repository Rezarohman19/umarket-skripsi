<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842]">
        <div class="flex">
            <aside
                :class="[
                    'bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                    sidebarCollapsed ? 'w-16' : 'w-64',
                ]"
            >
                <div
                    :class="[
                        'p-4 border-b border-[#EF3B33]/30',
                        sidebarCollapsed
                            ? 'flex flex-col items-center gap-2'
                            : 'flex items-center justify-between',
                    ]"
                >
                    <div
                        :class="[
                            'flex items-center justify-center',
                            sidebarCollapsed ? 'w-full' : 'flex-1',
                        ]"
                    >
                        <img
                            src="/images/logo-u-marketplace.png"
                            alt="U Marketplace"
                            :class="[
                                'object-contain',
                                sidebarCollapsed ? 'h-10 w-10' : 'h-20 w-auto',
                            ]"
                        />
                    </div>
                    <button
                        @click="toggleSidebar"
                        :class="[
                            'p-2 rounded-lg hover:bg-[#EF3B33]/20 transition',
                            sidebarCollapsed
                                ? 'w-full flex justify-center'
                                : '',
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white transition-transform duration-300',
                                sidebarCollapsed
                                    ? 'w-5 h-5 rotate-180'
                                    : 'w-5 h-5',
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

                <nav :class="['space-y-3', sidebarCollapsed ? 'px-2' : 'px-4']">
                    <a
                        href="/"
                        :class="[
                            'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                            sidebarCollapsed
                                ? 'px-2 py-3 justify-center'
                                : 'px-4 py-3',
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3',
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
                        :class="[
                            'flex items-center rounded-lg bg-[#FDA1A2]/30 text-white font-medium transition',
                            sidebarCollapsed
                                ? 'px-2 py-3 justify-center'
                                : 'px-4 py-3',
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3',
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
                            sidebarCollapsed
                                ? 'px-2 py-3 justify-center'
                                : 'px-4 py-3',
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3',
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
                        sidebarCollapsed ? 'px-2' : 'px-4',
                    ]"
                >
                    <a
                        href="/terms-and-conditions"
                        :class="[
                            'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                            sidebarCollapsed
                                ? 'px-2 py-3 justify-center'
                                : 'px-4 py-3',
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3',
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
                            sidebarCollapsed
                                ? 'px-2 py-3 justify-center'
                                : 'px-4 py-3',
                        ]"
                    >
                        <svg
                            :class="[
                                'text-white flex-shrink-0',
                                sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3',
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

                <div :class="['mt-auto', sidebarCollapsed ? 'p-2' : 'p-4']">
                    <button
                        @click="handleLogout"
                        :class="[
                            'w-full bg-[#EF3B33]/30 text-white font-medium py-3 rounded-lg transition hover:bg-[#EF3B33]/40 cursor-pointer',
                            sidebarCollapsed
                                ? 'px-2 flex justify-center'
                                : 'px-4',
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
                    'flex-1 transition-all duration-300',
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
                                    placeholder="Cari pesanan, nama toko, atau produk..."
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
                                placeholder="Cari pesanan, nama toko, atau produk..."
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

                <div v-if="loading" class="p-4 sm:p-6 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Memuat pesanan...</p>
                </div>

                <div v-else class="p-4 sm:p-6 space-y-6 sm:space-y-8">
                    <section
                        v-for="section in sections"
                        :key="section.key"
                        class="space-y-4"
                    >
                        <h2 class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]">{{ section.title }}</h2>

                        <div
                            v-for="orderGroup in getFilteredOrders(section.key)"
                            :key="orderGroup.id"
                            class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-3 sm:p-4 md:p-5"
                        >
                            <div
                                class="flex items-start justify-between gap-2 mb-4 pb-4 border-b border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                            >
                                <div class="flex-1">
                                    <p class="text-base font-semibold text-gray-700 dark:text-gray-300">{{ orderGroup.store }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Dari Toko</p>
                                </div>
                                <span
                                    :class="[
                                        'px-2 py-1 rounded-full text-xs font-medium',
                                        getStatusBadgeClass(getOrderGroupDisplayStatus(orderGroup)),
                                    ]"
                                >
                                    {{ getStatusLabel(getOrderGroupDisplayStatus(orderGroup)) }}
                                </span>
                            </div>

                            <div class="space-y-3 mb-4">
                                <div
                                    v-for="item in orderGroup.items"
                                    :key="item.id"
                                    class="flex items-start gap-4 p-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg"
                                >
                                    <div
                                        class="w-16 h-16 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-md flex items-center justify-center overflow-hidden flex-shrink-0 border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                    >
                                        <img
                                            v-if="item.image_url"
                                            :src="item.image_url"
                                            :alt="item.product"
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

                                    <div class="flex-1 space-y-1">
                                        <div
                                            class="flex flex-col md:flex-row md:items-center md:justify-between gap-2"
                                        >
                                            <div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">{{ item.product }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ item.category || "" }}</p>
                                            </div>
                                            <div
                                                class="flex flex-col md:items-end text-sm text-gray-700 dark:text-gray-300"
                                            >
                                                <span>{{ item.qty }} pcs</span>
                                                <span class="font-semibold text-[#1D1842] dark:text-[#FDA1A2]">Rp. {{ formatPrice(item.price) }}</span>
                                                <span class="font-semibold text-[#EF3B33] dark:text-[#EF3B33]">Subtotal: Rp. {{ formatPrice(item.total) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex justify-end mb-4 pt-4 border-t border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                            >
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Pesanan</p>
                                    <p class="text-lg font-bold text-[#EF3B33] dark:text-[#EF3B33]">Rp. {{ formatPrice(orderGroup.total) }}</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <button
                                    v-for="action in orderGroup.actions"
                                    :key="action.label"
                                    @click="handleAction(action.type, orderGroup)"
                                    :disabled="action.disabled"
                                    :class="[
                                        'px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition-all duration-150',
                                        action.disabled
                                            ? 'opacity-80 cursor-not-allowed pointer-events-none'
                                            : '',
                                        action.variant === 'primary'
                                            ? 'bg-[#EF3B33] text-white shadow-md hover:bg-[#d92f25] hover:shadow-lg active:scale-95 active:shadow-inner'
                                            : action.variant === 'warning'
                                                ? 'bg-yellow-500 hover:bg-yellow-600 text-white shadow-md hover:shadow-lg active:scale-95 active:shadow-inner'
                                                : 'bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] hover:bg-[#1D1842]/30 dark:hover:bg-[#1D1842]/40 active:scale-95',
                                    ]"
                                >
                                    {{ action.label }}
                                </button>

                                <button
                                    @click="contactSellerWhatsApp(orderGroup)"
                                    class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white rounded-full text-sm font-medium shadow-md transition-all duration-150 cursor-pointer hover:shadow-lg active:scale-95 active:shadow-inner"
                                    title="Hubungi penjual melalui WhatsApp"
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
                                    Hubungi Penjual
                                </button>
                            </div>
                        </div>

                        <div
                            v-if="getFilteredOrders(section.key).length === 0"
                            class="text-sm text-gray-500 dark:text-gray-400 py-4 text-center"
                        >
                            <template v-if="searchQuery">
                                Tidak ada pesanan yang cocok dengan pencarian "{{ searchQuery }}" di status {{ section.title }}.
                            </template>
                            <template v-else>
                                Tidak ada pesanan di status ini.
                            </template>
                        </div>
                    </section>
                </div>
            </main>
        </div>

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
const mobileMenuOpen = ref(false);
const user = ref(null);
const cartCount = ref(0);
const searchQuery = ref("");
const showMobileSearch = ref(false);
const confirmModal = ref({ visible: false, title: "", message: "", onConfirm: null });
const toast = ref({ visible: false, message: "", type: "success" });
const unreadOrdersCount = ref(0);

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};


const sections = [
    { key: "belum_bayar", title: "Belum Bayar" },
    { key: "dikemas", title: "Dikemas" },
    { key: "dikirim", title: "Dikirim" },
    { key: "riwayat", title: "Riwayat" },
];

const orders = ref([]);
const loading = ref(true);

const getGroupedOrders = (status) => {
    const filtered = orders.value.filter((order) => order.status === status);

    const grouped = {};
    filtered.forEach((order) => {
        const key = `${order.transaction_id}-${order.store}`;
        if (!grouped[key]) {
            grouped[key] = {
                id: key,
                transaction_id: order.transaction_id,
                store: order.store,
                status: order.status,
                items: [],
                total: 0,
                actions: order.actions || [],
                transaction: order.transaction,
            };
        }
        grouped[key].items.push({
            id: order.id,
            product: order.product,
            category: order.category,
            qty: order.qty,
            price: order.price,
            total: order.total,
            image_url: order.image_url,
        });
        grouped[key].total += order.total;
    });
    return Object.values(grouped);
};

const getFilteredOrders = (status) => {
    const grouped = getGroupedOrders(status);
    if (!searchQuery.value) {
        return grouped;
    }
    const q = searchQuery.value.toLowerCase().trim();
    return grouped.filter((group) => {
        return (
            (group.store || "").toLowerCase().includes(q) ||
            group.items.some(
                (item) =>
                    (item.product || "").toLowerCase().includes(q) ||
                    (item.category || "").toLowerCase().includes(q),
            )
        );
    });
};

const getStatusLabel = (status) => {
    const statusMap = {
        belum_bayar: "Belum Bayar",
        dikemas: "Dikemas",
        dikirim: "Dikirim",
        riwayat: "Selesai",
        pending: "Menunggu Pembayaran",
        paid: "Sudah Dibayar",
        processing: "Diproses",
        shipping: "Dikirim",
        completed: "Selesai",
        delivered: "Selesai",
        failed: "Gagal",
        expired: "Dibatalkan",
        cancelled: "Dibatalkan",
        return_requested: "Pengembalian Diajukan",
        returned: "Dikembalikan",
    };
    return statusMap[status] || status;
};

const getOrderGroupDisplayStatus = (orderGroup) => {
    const groupStatus = orderGroup?.status;
    const transactionStatus = orderGroup?.transaction?.status;

    if (groupStatus !== "riwayat") return groupStatus;

    if (transactionStatus === "returned") return "returned";

    if (
        transactionStatus === "expired" ||
        transactionStatus === "failed" ||
        transactionStatus === "cancelled" ||
        transactionStatus === "canceled"
    ) {
        return "cancelled";
    }

    return "riwayat";
};

const getStatusBadgeClass = (status) => {
    const classMap = {
        belum_bayar:
            "bg-[#EF3B33]/20 dark:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#FDA1A2]",
        dikemas:
            "bg-[#FDA1A2]/30 dark:bg-[#FDA1A2]/20 text-[#8E0D3C] dark:text-[#FDA1A2]",
        dikirim:
            "bg-[#8E0D3C]/20 dark:bg-[#8E0D3C]/30 text-[#8E0D3C] dark:text-[#FDA1A2]",
        riwayat:
            "bg-[#1D1842]/20 dark:bg-[#1D1842]/40 text-[#1D1842] dark:text-[#FDA1A2]",
        pending:
            "bg-[#EF3B33]/20 dark:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#FDA1A2]",
        paid: "bg-[#FDA1A2]/30 dark:bg-[#FDA1A2]/20 text-[#8E0D3C] dark:text-[#FDA1A2]",
        processing:
            "bg-[#FDA1A2]/30 dark:bg-[#FDA1A2]/20 text-[#8E0D3C] dark:text-[#FDA1A2]",
        shipping:
            "bg-[#8E0D3C]/20 dark:bg-[#8E0D3C]/30 text-[#8E0D3C] dark:text-[#FDA1A2]",
        completed:
            "bg-[#1D1842]/20 dark:bg-[#1D1842]/40 text-[#1D1842] dark:text-[#FDA1A2]",
        delivered:
            "bg-[#1D1842]/20 dark:bg-[#1D1842]/40 text-[#1D1842] dark:text-[#FDA1A2]",
        failed: "bg-[#EF3B33]/20 dark:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#FDA1A2]",
        expired: "bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700",
        cancelled:
            "bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700",
        return_requested: "bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300",
        returned: "bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300",
    };
    return (
        classMap[status] ||
        "bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-gray-800 dark:text-gray-300"
    );
};

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const fetchTransactions = async () => {
    if (!user.value) {
        loading.value = false;
        return;
    }

    try {
        loading.value = true;
        const purchaseResponse = await axios.get("/api/transactions");
        const purchaseTransactions = purchaseResponse.data || [];
        orders.value = purchaseTransactions.flatMap((transaction) => {
            if (transaction.items && transaction.items.length > 0) {
                return transaction.items.map((item) => {
                    const status = mapTransactionStatus(transaction.status);
                    const actions = getPurchaseActions(status, transaction);
                    let imageUrl = null;
                    if (item.product?.image) {
                        imageUrl = `/storage/${item.product.image}`;
                    } else {
                        imageUrl = "/images/placeholder-product.png";
                    }

                    return {
                        id: `${transaction.id}-${item.id}`,
                        transaction_id: transaction.id,
                        status: status,
                        store:
                            item.product?.user?.name ||
                            transaction.store_name ||
                            "Toko",
                        product:
                            item.product?.name ||
                            "Produk Tidak Tersedia (Dihapus)",
                        category: item.product?.description || "",
                        qty: item.qty || 1,
                        price: item.price || item.product?.price || 0,
                        total:
                            (item.price || item.product?.price || 0) *
                            (item.qty || 1),
                        image_url: imageUrl,
                        actions: actions,
                        transaction: transaction,
                    };
                });
            } else {
                const status = mapTransactionStatus(transaction.status);
                const actions = getPurchaseActions(status, transaction);

                return [
                    {
                        id: transaction.id,
                        transaction_id: transaction.id,
                        status: status,
                        store: transaction.store_name || "Toko",
                        product: "Produk",
                        category: "",
                        qty: 1,
                        price: transaction.total_price || 0,
                        total: transaction.total_price || 0,
                        image_url: null,
                        actions: actions,
                        transaction: transaction,
                    },
                ];
            }
        });
    } catch (error) {
        console.error("Error fetching transactions:", error);
        orders.value = [];
    } finally {
        loading.value = false;
    }
};

const mapTransactionStatus = (status) => {
    const statusMap = {
        pending: "belum_bayar",
        unpaid: "belum_bayar",
        paid: "dikemas",
        processing: "dikemas",
        packing: "dikemas",
        shipping: "dikirim",
        sent: "dikirim",
        completed: "riwayat",
        delivered: "riwayat",
        failed: "riwayat",
        expired: "riwayat",
        return_requested: "dikirim",
        returned: "riwayat",
    };
    return statusMap[status] || "riwayat";
};

const getPurchaseActions = (status, transaction) => {
    const actions = [];
    if (status === "belum_bayar" && transaction?.snap_token) {
        actions.push({
            label: "Lanjutkan Pembayaran",
            type: "continue_payment",
            variant: "primary",
        });
    }
    if (status === "dikirim" || transaction?.status === "shipping" || transaction?.status === "return_requested") {
        if (transaction?.status === 'shipping') {
            actions.push({
                label: "Tandai Diterima",
                type: "mark_delivered",
                variant: "primary",
            });
            actions.push({
                label: "Ajukan Pengembalian",
                type: "request_return",
                variant: "warning",
            });
        } else if (transaction?.status === 'return_requested') {
             actions.push({
                label: "Pengembalian Diajukan",
                type: "info",
                variant: "warning",
                disabled: true,
            });
        }
    }
    return actions;
};

const handleAction = (type, orderGroup) => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }

    if (type === "continue_payment") {
        handleContinuePayment(orderGroup);
    } else if (type === "contact") {
        contactSellerWhatsApp(orderGroup);
    } else if (type === "mark_delivered") {
        handleMarkDelivered(orderGroup);
    } else if (type === "request_return") {
        handleRequestReturn(orderGroup);
    }
};

const handleRequestReturn = (orderGroup) => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }

    confirmModal.value = {
        visible: true,
        title: "Ajukan Pengembalian",
        message: "Apakah Anda yakin ingin mengajukan pengembalian dana/barang untuk pesanan ini?",
        onConfirm: async () => {
            try {
                const transactionId = orderGroup.transaction_id || orderGroup.transaction?.id;
                if (!transactionId) {
                    throw new Error("Transaction ID tidak ditemukan");
                }

                await axios.post(`/api/transactions/${transactionId}/request-return`);

                await fetchTransactions();

                toast.value = {
                    visible: true,
                    message: "Pengajuan pengembalian berhasil dikirim",
                    type: "success"
                };
            } catch (error) {
                console.error("Error requesting return:", error);
                const message = error.response?.data?.message || "Gagal mengajukan pengembalian";
                toast.value = {
                    visible: true,
                    message: message,
                    type: "error"
                };
            }
        }
    };
};

const handleMarkDelivered = (orderGroup) => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }

    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Penerimaan",
        message: "Apakah Anda yakin pesanan ini sudah diterima?",
        onConfirm: async () => {
            try {
                const transactionId = orderGroup.transaction_id || orderGroup.transaction?.id;
                if (!transactionId) {
                    throw new Error("Transaction ID tidak ditemukan");
                }

                await axios.post(`/api/transactions/${transactionId}/mark-delivered`);
                await fetchTransactions();

                toast.value = {
                    visible: true,
                    message: "Pesanan berhasil ditandai diterima",
                    type: "success"
                };
            } catch (error) {
                console.error("Error marking as delivered:", error);
                const message = error.response?.data?.message || "Gagal menandai pesanan diterima";
                toast.value = {
                    visible: true,
                    message: message,
                    type: "error"
                };
            }
        }
    };
};

const handleContinuePayment = (orderGroup) => {
    const snapToken = orderGroup.transaction?.snap_token;

    if (!snapToken) {
        alert(
            "Token pembayaran tidak tersedia. Silakan hubungi customer service.",
        );
        return;
    }

    if (window.snap) {
        window.snap.pay(snapToken, {
            onSuccess: function (result) {
                console.log("Payment success:", result);
                setTimeout(() => {
                    fetchTransactions();
                }, 2000);
            },
            onPending: function (result) {
                console.log("Payment pending:", result);
                setTimeout(() => {
                    fetchTransactions();
                }, 2000);
            },
            onError: function (result) {
                console.error("Payment error:", result);
                if (
                    result.status_message &&
                    result.status_message.includes("expired")
                ) {
                    deleteExpiredTransaction(orderGroup.transaction_id);
                } else {
                    alert("Pembayaran gagal. Silakan coba lagi.");
                }
            },
            onClose: function () {
                console.log("Payment modal closed");
            },
        });
    } else {
        const script = document.createElement("script");
        script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
        script.setAttribute("data-client-key", "Mid-client-t4gCXBa6b1_ar6Ji");
        script.onload = () => {
            if (window.snap) {
                window.snap.pay(snapToken, {
                    onSuccess: function (result) {
                        console.log("Payment success:", result);
                        setTimeout(() => {
                            fetchTransactions();
                        }, 2000);
                    },
                    onPending: function (result) {
                        console.log("Payment pending:", result);
                        setTimeout(() => {
                            fetchTransactions();
                        }, 2000);
                    },
                    onError: function (result) {
                        console.error("Payment error:", result);
                        if (
                            result.status_message &&
                            result.status_message.includes("expired")
                        ) {
                            deleteExpiredTransaction(orderGroup.transaction_id);
                        } else {
                            alert("Pembayaran gagal. Silakan coba lagi.");
                        }
                    },
                    onClose: function () {
                        console.log("Payment modal closed");
                    },
                });
            }
        };
        document.head.appendChild(script);
    }
};

const deleteExpiredTransaction = async (transactionId) => {
    try {
        await axios.delete(`/api/transactions/${transactionId}`);
        console.log("Expired transaction deleted");
        await fetchTransactions();
    } catch (error) {
        console.error("Error deleting expired transaction:", error);
    }
};
const contactSellerWhatsApp = (orderGroup) => {
    let phoneNumber = null;
    let sellerName = orderGroup.store || "Penjual";

    if (
        orderGroup.transaction?.items &&
        orderGroup.transaction.items.length > 0
    ) {
        const firstItem = orderGroup.transaction.items[0];
        phoneNumber = firstItem.product?.user?.phone;
        sellerName = firstItem.product?.user?.name || sellerName;
    }

    if (!phoneNumber && orderGroup.transaction?.user?.phone) {
        phoneNumber = orderGroup.transaction.user.phone;
        sellerName = orderGroup.transaction.user.name || sellerName;
    }

    if (!phoneNumber) {
        toast.value = {
            visible: true,
            message: "Nomor WhatsApp penjual tidak tersedia. Silakan hubungi customer service.",
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

    const orderId = orderGroup.transaction_id || orderGroup.id;
    const itemsList = orderGroup.items
        .map((item) => `- ${item.product} (${item.qty} pcs)`)
        .join("\n");
    const message = `Halo ${sellerName},\n\nSaya ingin menanyakan tentang pesanan saya.\n\nID Pesanan: #${orderId}\nProduk:\n${itemsList}\nTotal: Rp. ${formatPrice(orderGroup.total)}\n\nTerima kasih.`;

    const encodedMessage = encodeURIComponent(message);

    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    window.open(whatsappUrl, "_blank");
};

const handleOpenShop = () => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }
    window.location.href = "/open-shop";
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

const handleLogout = () => {
    if (!user.value) {
        window.location.href = "/login";
        return;
    }

    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Keluar",
        message: "Apakah Anda yakin ingin keluar?",
        onConfirm: null
    };
};

const closeConfirmModal = () => {
    confirmModal.value.visible = false;
    confirmModal.value.onConfirm = null;
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
        }
    } else {
        closeConfirmModal();
        try {
            await axios.post("/logout");
            window.location.href = "/";
        } catch (error) {
            console.error("Error logging out:", error);
            window.location.href = "/";
        }
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
    } catch (error) {
        user.value = null;
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
            params: { _t: Date.now() },
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

onMounted(async () => {
    await checkAuth();
    await fetchCartCount();
    await fetchUnreadOrdersCount();
    await fetchTransactions();
    window.addEventListener("sellerOrdersOptimized", fetchUnreadOrdersCount);

    window.addEventListener("cartUpdated", fetchCartCount);

    if (!window.snap) {
        const script = document.createElement("script");
        script.src = "https://app.sandbox.midtrans.com/snap/snap.js";
        script.setAttribute("data-client-key", "Mid-client-t4gCXBa6b1_ar6Ji");
        document.head.appendChild(script);
    }

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
</style>
