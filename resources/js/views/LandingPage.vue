<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] overflow-x-hidden">
        <div class="flex">
            <aside
                v-if="user"
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

            <main
                :class="[
                    'flex-1 min-w-0 transition-all duration-300 overflow-x-hidden max-w-full',
                    user && sidebarCollapsed
                        ? 'ml-16'
                        : user
                        ? 'ml-64'
                        : 'ml-0',
                ]"
            >
                <header
                    class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm px-4 sm:px-6 py-3 sm:py-4 sticky top-0 z-10"
                >
                    <div class="flex items-center justify-between gap-2 sm:gap-4">
                        <div class="flex-1 min-w-0 flex items-center gap-1.5 sm:gap-2" :class="user ? '' : 'mx-2 sm:mx-6'">
                            <img
                                v-if="!user"
                                src="/images/logo-u.png"
                                alt="U Marketplace"
                                class="h-5 w-5 sm:h-6 sm:w-6 md:h-8 md:w-8 object-contain flex-shrink-0"
                            />
                            <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 truncate">
                                Halo,
                                <template v-if="user?.name">
                                    <span class="font-semibold">{{ user?.name }}</span>
                                </template>
                                <template v-else>
                                    <span>Pengunjung <span class="font-semibold italic">U Market</span></span>
                                </template>
                            </p>
                        </div>

                        <div class="hidden md:flex flex-1 max-w-md mx-2 md:mx-2">
                            <div class="relative w-full">
                                <input v-model="searchQuery" type="text" placeholder="Cari nama produk atau nama toko..." class="w-full px-4 py-2 pl-10 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg focus:outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
                                <svg
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
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
                        <button
                            v-else
                            @click="goToLogin"
                            class="px-3 py-1.5 sm:px-4 sm:py-2 bg-[#EF3B33] text-white text-sm sm:text-base font-medium rounded-lg shadow-md"
                        >
                            Login
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
                                placeholder="Cari nama produk atau nama toko..."
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

                <div v-if="!user && showWelcomeCard && slides.length > 0" class="p-2 sm:p-6 pb-0 w-full max-w-full min-w-0 overflow-x-hidden box-border" @mouseenter="pauseCarousel" @mouseleave="resumeCarousel">
                    <div class="relative bg-[#FDA1A2]/30 dark:bg-[#8E0D3C]/30 rounded-xl sm:rounded-2xl shadow-lg overflow-hidden border border-[#FDA1A2]/50 dark:border-[#8E0D3C]/50 group w-full max-w-full min-w-0 box-border" style="width: 100%; max-width: 100%;">
                        
                        <div 
                            class="flex transition-transform duration-500 ease-in-out h-full w-full min-w-0 shrink-0"
                            :style="{ transform: `translateX(-${currentSlide * 100}%)` }"
                        >
                            <div 
                                v-for="(slide, index) in slides" 
                                :key="index" 
                                class="min-w-full w-full flex-shrink-0 overflow-hidden flex-[0_0_100%]"
                            >
                                <div v-if="slide.type === 'welcome'" class="relative p-2.5 sm:p-4 md:p-6 h-full flex flex-col justify-center min-h-[120px] sm:min-h-[200px] md:min-h-[220px] overflow-hidden w-full min-w-0 max-w-full box-border">
                                    <div class="absolute inset-0 opacity-10 dark:opacity-5 pointer-events-none">
                                        <svg class="absolute top-2 right-2 w-20 h-20 md:w-28 md:h-28 text-[#EF3B33] transform rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <svg class="absolute bottom-4 left-4 w-16 h-16 md:w-24 md:h-24 text-[#8E0D3C] dark:text-[#FDA1A2] transform -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <svg class="absolute top-1/2 left-4 w-12 h-12 md:w-16 md:h-16 text-[#EF3B33] transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    
                                    <div class="absolute inset-0 bg-gradient-to-br from-[#FDA1A2]/20 via-transparent to-[#EF3B33]/10 dark:from-[#8E0D3C]/20 dark:via-transparent dark:to-[#FDA1A2]/10"></div>
                                    
                                    <div class="relative z-10 flex flex-col items-center gap-1 sm:gap-2 md:gap-3 w-full max-w-full min-w-0 px-1 sm:px-0">
                                        <div class="flex-1 text-center w-full min-w-0 max-w-full">
                                            <h2 class="text-base sm:text-2xl md:text-3xl font-bold text-[#8E0D3C] dark:text-[#FDA1A2] mb-0.5 sm:mb-1.5 drop-shadow-sm break-words leading-tight">
                                                Selamat Datang di <span class="text-[#EF3B33]">U Market</span>
                                            </h2>
                                            <p class="text-gray-700 dark:text-gray-300 text-xs sm:text-sm leading-snug mb-1 sm:mb-2.5 max-w-2xl mx-auto px-1 sm:px-4 break-words line-clamp-2 sm:line-clamp-none">
                                                Platform e-commerce terpercaya dan spesial untuk warga Unila serta masyarakat umum. 
                                                Temukan berbagai produk berkualitas dari penjual lokal atau kelola toko Anda sendiri!
                                            </p>
                                            
                                            <div class="flex flex-wrap justify-center gap-1 sm:gap-2 mb-1 sm:mb-3 w-full max-w-full min-w-0">
                                                <div class="flex items-center gap-1 sm:gap-2 bg-white/80 dark:bg-[#1D1842]/80 px-2 py-1 sm:px-4 sm:py-2 rounded-full shadow-md border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 hover:scale-105 transition-transform flex-shrink-0 min-w-0 max-w-full">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-[#EF3B33] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span class="text-[9px] sm:text-sm font-semibold break-words text-[#8E0D3C] dark:text-[#FDA1A2]">Gratis Daftar</span>
                                                </div>
                                                <div class="flex items-center gap-1 sm:gap-2 bg-white/80 dark:bg-[#1D1842]/80 px-2 py-1 sm:px-4 sm:py-2 rounded-full shadow-md border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 hover:scale-105 transition-transform flex-shrink-0 min-w-0 max-w-full">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-[#EF3B33] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                    <span class="text-[9px] sm:text-sm font-semibold break-words text-[#8E0D3C] dark:text-[#FDA1A2]">Transaksi Aman</span>
                                                </div>
                                                <div class="flex items-center gap-1 sm:gap-2 bg-white/80 dark:bg-[#1D1842]/80 px-2 py-1 sm:px-4 sm:py-2 rounded-full shadow-md border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 hover:scale-105 transition-transform flex-shrink-0 min-w-0 max-w-full">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-[#EF3B33] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                    </svg>
                                                    <span class="text-[9px] sm:text-sm font-semibold break-words text-[#8E0D3C] dark:text-[#FDA1A2]">Toko Saya</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-shrink-0 w-full max-w-full flex justify-center px-1" v-if="!user">
                                            <button
                                                @click="goToLoginFromWelcome"
                                                class="bg-white dark:bg-[#1D1842] text-[#8E0D3C] dark:text-[#FDA1A2] font-semibold px-3 py-1.5 sm:px-5 sm:py-2 rounded-lg sm:rounded-xl shadow-md border border-[#FDA1A2]/50 dark:border-[#8E0D3C]/50 text-xs sm:text-sm hover:scale-105 hover:shadow-lg transition-all transform max-w-full"
                                            >
                                                Mulai Sekarang
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline-block ml-1.5 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div v-else class="relative h-full min-h-[100px] sm:min-h-[250px] flex items-center justify-center p-2 sm:p-6 overflow-hidden" @click="goToProductDetail(slide.data.id)">
                                    <div class="absolute inset-0 z-0">
                                        <img 
                                            v-if="slide.data.image_url"
                                            :src="slide.data.image_url" 
                                            :alt="slide.data.name"
                                            class="w-full h-full object-cover opacity-20 dark:opacity-10"
                                        />
                                        <div v-else class="w-full h-full bg-gradient-to-br from-[#FDA1A2]/30 to-[#EF3B33]/20 dark:from-[#8E0D3C]/30 dark:to-[#FDA1A2]/20"></div>
                                        <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/90 to-white/70 dark:from-[#1D1842]/95 dark:via-[#1D1842]/90 dark:to-[#1D1842]/70"></div>
                                    </div>

                                    <div class="relative z-10 w-full max-w-4xl flex flex-row items-center gap-2 sm:gap-4 md:gap-8 pb-7 sm:pb-0">
                                        <div class="flex-shrink-0 w-14 h-14 sm:w-36 sm:h-36 md:w-48 md:h-48 bg-white dark:bg-[#1D1842] rounded-lg sm:rounded-xl shadow-xl overflow-hidden border-2 sm:border-4 border-white dark:border-[#8E0D3C]/50 transform rotate-1 hover:rotate-0 transition-transform duration-300 cursor-pointer group">
                                            <div v-if="!slide.data.image_url" class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FDA1A2]/20 to-[#EF3B33]/20">
                                                <svg class="w-6 h-6 sm:w-16 sm:h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <img 
                                                v-else
                                                :src="slide.data.image_url" 
                                                :alt="slide.data.name"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                            />
                                        </div>

                                        <div class="text-left flex-1 min-w-0 px-0 flex flex-col justify-center gap-y-1 sm:gap-y-1.5">
                                            <div class="inline-block w-fit px-1.5 py-0.5 sm:px-2 sm:py-0.5 bg-[#EF3B33] text-white text-[9px] sm:text-xs font-bold rounded-full shadow-md">
                                                ⭐ Produk Terpopuler
                                            </div>
                                            <h2 class="text-xs sm:text-xl md:text-2xl lg:text-3xl font-extrabold text-[#8E0D3C] dark:text-[#FDA1A2] line-clamp-1 drop-shadow-sm">
                                                {{ slide.data.name }}
                                            </h2>
                                            <p class="text-[10px] sm:text-base md:text-lg font-bold text-[#EF3B33]">
                                                Rp. {{ formatPrice(slide.data.price) }}
                                            </p>
                                            <p class="text-gray-700 dark:text-gray-300 text-[10px] sm:text-sm line-clamp-2 max-w-lg leading-tight">
                                                {{ slide.data.description || 'Dapatkan produk berkualitas ini dengan harga terbaik. Jangan lewatkan penawaran menarik ini!' }}
                                            </p>
                                            <button 
                                                class="bg-[#EF3B33] hover:bg-[#d92f25] text-white font-semibold px-2 py-0.5 sm:px-5 sm:py-2.5 rounded-full shadow-md sm:shadow-lg transition-all transform hover:scale-105 active:scale-95 flex items-center gap-0.5 sm:gap-1 w-fit text-[9px] sm:text-sm group"
                                            >
                                                <span>Lihat Detail</span>
                                                <svg class="w-2.5 h-2.5 sm:w-3.5 sm:h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button 
                            @click="prevSlide"
                            class="absolute left-2 top-1/2 transform -translate-y-1/2 p-1.5 rounded-full bg-white/80 dark:bg-[#1D1842]/80 text-[#8E0D3C] dark:text-[#FDA1A2] shadow-md hover:bg-white dark:hover:bg-[#1D1842] transition-all opacity-0 group-hover:opacity-100 z-20 focus:outline-none"
                            aria-label="Previous Slide"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button 
                            @click="nextSlide"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 p-1.5 rounded-full bg-white/80 dark:bg-[#1D1842]/80 text-[#8E0D3C] dark:text-[#FDA1A2] shadow-md hover:bg-white dark:hover:bg-[#1D1842] transition-all opacity-0 group-hover:opacity-100 z-20 focus:outline-none"
                            aria-label="Next Slide"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1.5 z-20">
                            <button
                                v-for="(slide, index) in slides"
                                :key="index"
                                @click="currentSlide = index"
                                :class="[
                                    'w-1.5 h-1.5 rounded-full transition-all duration-300',
                                    currentSlide === index 
                                        ? 'bg-[#EF3B33] w-4' 
                                        : 'bg-gray-300/80 dark:bg-gray-600/80 hover:bg-[#EF3B33]/50'
                                ]"
                                :aria-label="'Go to slide ' + (index + 1)"
                            ></button>
                        </div>
                    </div>
                </div>

                <div class="p-3 sm:p-6 max-w-full overflow-x-hidden">
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
                            class="relative bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 overflow-hidden shadow-md cursor-pointer flex flex-col h-full"
                            @click="goToProductDetail(product.id)"
                        >
                            <div
                                class="w-full aspect-[3/2] bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 flex items-center justify-center overflow-hidden"
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

                            <div class="p-2 pb-1 flex flex-col flex-1">
                                <div>
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
                                        class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 mb-0.5 leading-4 sm:leading-5 min-h-[2rem] sm:min-h-[2.5rem]"
                                    >
                                        {{ product.name }}
                                    </h3>
                                    <p
                                        class="text-sm sm:text-base font-bold text-[#EF3B33] dark:text-[#EF3B33] mb-1"
                                    >
                                        Rp. {{ formatPrice(product.price) }}
                                    </p>
                                </div>

                                <div
                                    class="mt-auto pt-1.5 flex items-center gap-1 sm:gap-1.5"
                                    @click.stop
                                >
                                    <div
                                        class="flex-shrink-0 flex items-center justify-between px-0.5 sm:px-1 py-0.5 border border-[#EF3B33]/30 dark:border-[#EF3B33]/30 rounded-md bg-[#EF3B33]/10 dark:bg-[#EF3B33]/10 min-w-[55px] sm:min-w-[65px]"
                                    >
                                        <button
                                            @click.stop="
                                                decreaseQuantity(product.id)
                                            "
                                            class="p-0.5 text-gray-600 dark:text-gray-400 cursor-pointer transition-all duration-150 hover:text-[#EF3B33] hover:bg-[#EF3B33]/20 active:scale-95 flex items-center justify-center"
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
                                            class="text-xs text-gray-900 dark:text-white font-medium text-center flex-1 px-0.5 min-w-[18px]"
                                            >{{ getQuantity(product.id) }}</span
                                        >
                                        <button
                                            @click.stop="
                                                increaseQuantity(product.id)
                                            "
                                            class="p-0.5 text-gray-600 dark:text-gray-400 cursor-pointer transition-all duration-150 hover:text-[#EF3B33] hover:bg-[#EF3B33]/20 active:scale-95 flex items-center justify-center"
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
                                        class="flex-1 bg-[#EF3B33] text-white font-medium py-1 px-0.5 sm:px-1.5 rounded-md text-[8px] sm:text-[10px] cursor-pointer transition-all duration-150 hover:bg-[#d92f25] hover:shadow-lg active:scale-95 active:shadow-inner active:bg-[#c0271f] text-center flex flex-col items-center justify-center leading-[1.05]"
                                    >
                                        <span class="block sm:whitespace-nowrap">Tambah ke</span>
                                        <span class="block">Keranjang</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <transition name="modal">
            <div
                v-if="showLoginModal"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 flex items-center justify-center z-50 p-4 backdrop-blur-sm"
                @click.self="closeLoginModal"
            >
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all modal-content"
                >
                    <div class="bg-[#FDA1A2] rounded-t-2xl p-4 sm:p-6">
                        <div class="flex items-center justify-center mb-2">
                            <div
                                class="w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-full flex items-center justify-center shadow-md"
                            >
                                <img
                                    src="/images/logo-u.png"
                                    alt="U Marketplace Logo"
                                    class="w-8 h-8 sm:w-10 sm:h-10 object-contain"
                                />
                            </div>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-white text-center drop-shadow-sm">
                            Login Diperlukan
                        </h3>
                    </div>

                    <div class="p-4 sm:p-6 bg-white dark:bg-[#1D1842]">
                        <p
                            class="text-sm sm:text-base text-gray-800 dark:text-gray-200 text-center mb-4 sm:mb-6 leading-relaxed"
                        >
                            Anda harus melakukan
                            <span
                                class="font-semibold text-[#EF3B33] dark:text-[#FDA1A2]"
                                >login</span
                            >
                            sebelum melakukan aksi lebih lanjut.
                        </p>

                        <div class="flex gap-2 sm:gap-3">
                            <button
                                @click="closeLoginModal"
                                class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm sm:text-base font-semibold rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-150 shadow-sm"
                            >
                                Batal
                            </button>
                            <button
                                @click="goToLogin"
                                class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-[#EF3B33] hover:bg-[#d92f25] text-white text-sm sm:text-base font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-150 transform hover:scale-[1.02] active:scale-[0.98]"
                            >
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="h-1 bg-[#FDA1A2] rounded-b-2xl"></div>
                </div>
            </div>
        </transition>
        <ToastNotification
            :visible="toast.visible"
            :message="toast.message"
            :type="toast.type"
            @close="handleToastClose"
        />

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
import ToastNotification from "../components/ToastNotification.vue";
import ConfirmModal from "../components/ConfirmModal.vue";

const sidebarCollapsed = ref(window.innerWidth <= 768);
const showMobileSearch = ref(false);
const products = ref([]);
const loading = ref(true);
const searchQuery = ref("");
const quantities = ref({});
const user = ref(window.auth_user || null);
const cartCount = ref(0);
const showLoginModal = ref(false);
const showWelcomeCard = ref(true);
const unreadOrdersCount = ref(0);
const toast = ref({ visible: false, message: "", type: "success" });
const confirmModal = ref({ visible: false, title: "", message: "" });

const checkWelcomeCardVisibility = () => {
    const hideWelcome = sessionStorage.getItem('hideWelcomeCard');
    if (hideWelcome === 'true') {
        showWelcomeCard.value = false;
    }
};

const goToLoginFromWelcome = () => {
    sessionStorage.setItem('hideWelcomeCard', 'true');
    window.location.href = '/login?from=welcome';
};

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};


const filteredProducts = computed(() => {
    if (!searchQuery.value) return products.value;
    const query = searchQuery.value.toLowerCase();
    return products.value.filter((product) => {
        const productName = (product.name || "").toLowerCase();
        const storeName = (product.store_name || product.user?.name || "").toLowerCase();
        const description = (product.description || "").toLowerCase();
        const category = String(product.category || "").toLowerCase();
        return productName.includes(query) || storeName.includes(query) || description.includes(query) || category.includes(query);
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

const currentSlide = ref(0);
const carouselInterval = ref(null);
const isPaused = ref(false);

const slides = computed(() => {
    const welcomeSlide = {
        type: 'welcome',
        id: 'welcome-card'
    };
    
    const productSlides = products.value.slice(0, 3).map(product => ({
        type: 'product',
        id: `product-${product.id}`,
        data: product
    }));

    return [welcomeSlide, ...productSlides];
});

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length;
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.value.length) % slides.value.length;
};

const startAutoSlide = () => {
    stopAutoSlide();
    carouselInterval.value = setInterval(() => {
        if (!isPaused.value && slides.value.length > 1) {
            nextSlide();
        }
    }, 5000);
};

const stopAutoSlide = () => {
    if (carouselInterval.value) {
        clearInterval(carouselInterval.value);
        carouselInterval.value = null;
    }
};

const pauseCarousel = () => {
    isPaused.value = true;
};

const resumeCarousel = () => {
    isPaused.value = false;
};

const getPhotoUrl = (photoUrl) => {
    if (!photoUrl) return null;
    
    if (!photoUrl.startsWith("/storage/") && !photoUrl.startsWith("http")) {
        photoUrl = "/storage/" + photoUrl;
    }

    if (photoUrl.includes("?")) {
        return photoUrl.split("?")[0] + "?t=" + Date.now();
    }
    return photoUrl + "?t=" + Date.now();
};

const isInitialLoad = ref(true);

const checkAuth = async () => {
    if (isInitialLoad.value && window.auth_user) {
        user.value = window.auth_user;
        isInitialLoad.value = false;
    }

    try {
        const response = await axios.get("/api/user", {
            params: { _t: Date.now() },
        });
        
        if (response.data && response.data.id) {
            user.value = response.data;
        } else if (!window.auth_user) {
            user.value = null;
        }
    } catch (error) {
        if (error.response?.status === 401) {
            if (!window.auth_user) {
                user.value = null;
            }
        }
        console.error("Auth check failed, but keeping session if Blade says OK:", error.message);
    } finally {
        isInitialLoad.value = false;
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

const lastAddedProductId = ref(null);

const handleToastClose = async () => {
    toast.value.visible = false;
    if (lastAddedProductId.value !== null) {
        quantities.value[lastAddedProductId.value] = 0;
        lastAddedProductId.value = null;
    }
    
    if (user.value) {
        await fetchCartCount();
        await nextTick();
    }
};

const handleAddToCart = async (product) => {
    if (!user.value) {
        showLoginModal.value = true;
        return;
    }
    const quantity = getQuantity(product.id);
    if (quantity <= 0) {
        toast.value = { visible: true, message: "Jumlah produk harus lebih dari 0", type: "error" };
        return;
    }
    const stock = product.stock || 0;
    if (quantity > stock) {
        toast.value = { visible: true, message: `Stok tidak mencukupi. Sisa stok: ${stock}`, type: "error" };
        return;
    }
    try {
        await axios.post("/api/cart/add", { product_id: product.id, quantity });
        
        toast.value = { visible: true, message: "Produk berhasil ditambahkan ke keranjang!", type: "success" };
        lastAddedProductId.value = product.id;
        
        await fetchCartCount();
        await nextTick();
        window.dispatchEvent(new CustomEvent("cartUpdated"));
    } catch (error) {
        console.error("Error adding to cart:", error);
        const message = error.response?.data?.message || "Gagal menambahkan produk ke keranjang";
        toast.value = { visible: true, message: message, type: "error" };
    }
};

const fetchCartCount = async () => {
    if (!user.value) {
        cartCount.value = 0;
        return;
    }

    try {
        const response = await axios.get("/api/cart/count", { params: { _t: Date.now() } });
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

const handleUserUpdated = async (event) => {
    await checkAuth();
};

onMounted(async () => {
    console.log("Blade injected user:", window.auth_user);
    checkWelcomeCardVisibility();
    await checkAuth();
    await fetchProducts();
    await fetchCartCount();
    await fetchUnreadOrdersCount();
    startAutoSlide();
    window.addEventListener("cartUpdated", fetchCartCount);
    window.addEventListener("userUpdated", handleUserUpdated);
    window.addEventListener("sellerOrdersOptimized", fetchUnreadOrdersCount);
});

onBeforeUnmount(() => {
    stopAutoSlide();
    
    window.removeEventListener("cartUpdated", fetchCartCount);
    window.removeEventListener("userUpdated", handleUserUpdated);
    window.removeEventListener("sellerOrdersOptimized", fetchUnreadOrdersCount);
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

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
