<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] overflow-x-hidden">
        <div class="flex">
            <!-- Left Sidebar -->
            <aside
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
                            'p-2 rounded-lg hover:bg-[#EF3B33]/20 transition cursor-pointer active:scale-95',
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

                <!-- Navigation -->
                <nav :class="[
                    'flex-1 space-y-3',
                    sidebarCollapsed ? 'px-2' : 'px-4'
                ]">
                    <a
                        href="/admin/dashboard"
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
                        href="/admin/products"
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
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Produk</span>
                    </a>

                    <a
                        href="/admin/users"
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
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Pengguna</span>
                    </a>

                    <a
                        href="/admin/transactions"
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
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Penjualan</span>
                    </a>
                </nav>

                <!-- Logout Button -->
                <div :class="[
                    'mt-auto border-t border-[#EF3B33]/30',
                    sidebarCollapsed ? 'p-2' : 'p-4'
                ]">
                    <button
                        @click="handleLogout"
                        :class="[
                            'w-full bg-[#EF3B33]/30 text-white font-medium rounded-lg transition cursor-pointer hover:bg-[#EF3B33]/40 active:scale-95',
                            sidebarCollapsed ? 'py-2 px-2 flex justify-center' : 'py-3 px-4'
                        ]"
                    >
                        <span :class="[
                            'flex items-center',
                            sidebarCollapsed ? 'justify-center' : 'justify-center'
                        ]">
                            <svg
                                :class="[
                                    'flex-shrink-0',
                                    sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-2'
                                ]"
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
                            <span v-if="!sidebarCollapsed">Keluar</span>
                        </span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <main :class="[
                'flex-1 transition-all duration-300 overflow-x-hidden',
                sidebarCollapsed ? 'ml-16' : 'ml-64'
            ]">
                <!-- Top Header (match user landing page style) -->
                <header
                    class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm px-3 sm:px-6 py-3 sm:py-4 sticky top-0 z-10 w-full max-w-full overflow-hidden"
                >
                    <div class="flex flex-row items-center justify-between gap-2 sm:gap-0">

                        <!-- Greeting -->
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-base text-[#1D1842] dark:text-[#FDA1A2]">
                                Halo, <span class="font-semibold">Admin</span>
                            </p>
                        </div>

                        <!-- Profile Icon -->
                        <button
                            @click="handleProfile"
                            class="w-7 h-7 sm:w-10 sm:h-10 rounded-full overflow-hidden flex items-center justify-center border-2 border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 flex-shrink-0 cursor-pointer hover:border-[#FDA1A2]/60 dark:hover:border-[#8E0D3C]/60 transition active:scale-95"
                            :class="
                                admin?.photo_url
                                    ? ''
                                    : 'bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20'
                            "
                        >
                            <img
                                v-if="admin?.photo_url"
                                :src="getPhotoUrl(admin.photo_url)"
                                alt="Admin"
                                class="w-full h-full object-cover"
                            />
                            <svg
                                v-else
                                class="w-4 h-4 sm:w-6 sm:h-6 text-gray-600 dark:text-gray-400"
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

                <!-- Dashboard Content -->
                <div class="p-3 sm:p-6 overflow-x-hidden">
                    <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
                        <!-- Main Content Area -->
                        <div class="flex-1 space-y-4 sm:space-y-6 min-w-0">
                            <!-- Stats Cards -->
                            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2 sm:gap-6">
                                <!-- Jumlah Pengguna -->
                                <div
                                    class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-2 sm:p-6"
                                >
                                    <h3
                                        class="text-[10px] sm:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1 sm:mb-2"
                                    >
                                        Jumlah Pengguna
                                    </h3>
                                    <p
                                        class="text-lg sm:text-3xl lg:text-4xl font-bold text-[#EF3B33] dark:text-[#EF3B33]"
                                    >
                                        {{ stats.totalUsers }}
                                    </p>
                                </div>

                                <!-- Riwayat Transaksi -->
                                <div
                                    class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-2 sm:p-6"
                                >
                                    <h3
                                        class="text-[10px] sm:text-sm font-medium text-gray-600 dark:text-gray-400 mb-1 sm:mb-2"
                                    >
                                        Riwayat Transaksi
                                    </h3>
                                    <p
                                        class="text-xs sm:text-2xl lg:text-3xl xl:text-4xl font-bold text-[#EF3B33] dark:text-[#EF3B33] break-words"
                                    >
                                        Rp.
                                        {{
                                            formatPrice(stats.totalTransactions)
                                        }}
                                    </p>
                                </div>
                            </div>

                            <!-- Diagram Penjualan -->
                            <div
                                class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-3 sm:p-6"
                            >
                                <div
                                    class="flex items-center justify-between mb-3 sm:mb-4"
                                >
                                    <h3
                                        class="text-sm sm:text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                                    >
                                        Diagram Penjualan
                                    </h3>
                                    <div class="relative group">
                                        <button class="p-1.5 sm:p-2 rounded-lg cursor-pointer active:scale-95 flex items-center gap-1 text-xs sm:text-sm text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                            <svg
                                                class="w-4 h-4 sm:w-5 sm:h-5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"
                                                />
                                            </svg>
                                            <span class="hidden sm:inline">{{ selectedPeriodLabel }}</span>
                                        </button>
                                        <!-- Dropdown content -->
                                        <div class="absolute right-0 top-full mt-1 bg-white dark:bg-[#1D1842] border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 rounded-lg shadow-xl z-20 hidden group-hover:block min-w-[120px] overflow-hidden">
                                            <div class="py-1">
                                                <button @click="changePeriod(7)" class="w-full text-left px-4 py-2 text-xs sm:text-sm hover:bg-[#FDA1A2]/10 dark:hover:bg-[#8E0D3C]/10 text-[#1D1842] dark:text-[#FDA1A2]" :class="{'bg-[#FDA1A2]/20 font-bold': selectedPeriod === 7}">7 Hari</button>
                                                <button @click="changePeriod(30)" class="w-full text-left px-4 py-2 text-xs sm:text-sm hover:bg-[#FDA1A2]/10 dark:hover:bg-[#8E0D3C]/10 text-[#1D1842] dark:text-[#FDA1A2]" :class="{'bg-[#FDA1A2]/20 font-bold': selectedPeriod === 30}">30 Hari</button>
                                                <button @click="changePeriod(90)" class="w-full text-left px-4 py-2 text-xs sm:text-sm hover:bg-[#FDA1A2]/10 dark:hover:bg-[#8E0D3C]/10 text-[#1D1842] dark:text-[#FDA1A2]" :class="{'bg-[#FDA1A2]/20 font-bold': selectedPeriod === 90}">90 Hari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-48 sm:h-64 relative">
                                    <canvas ref="salesChartCanvas"></canvas>
                                    <div v-if="loadingChart" class="absolute inset-0 flex items-center justify-center bg-white/50 dark:bg-[#1D1842]/50">
                                        <p class="text-xs sm:text-sm text-gray-500">Memuat grafik...</p>
                                    </div>
                                    <div v-if="!loadingChart && salesData.length === 0" class="absolute inset-0 flex items-center justify-center">
                                        <p class="text-xs sm:text-sm text-gray-400">Belum ada data penjualan</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Produk Populer - Hanya muncul di Mobile, di Desktop akan di sidebar -->
                            <aside
                                class="lg:hidden bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-3 sm:p-6 h-fit"
                            >
                                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                                        <h3
                                            class="text-sm sm:text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                                        >
                                            Produk Populer
                                        </h3>
                                    </div>
                                    <div class="space-y-2 sm:space-y-4">
                                        <div
                                            v-for="product in displayedProducts"
                                            :key="product.id"
                                            class="flex items-center gap-2 p-1.5 sm:p-2 rounded-lg cursor-pointer hover:bg-[#FDA1A2]/5 dark:hover:bg-[#8E0D3C]/10 transition"
                                        >
                                            <div
                                                class="w-10 h-10 sm:w-12 sm:h-12 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg flex items-center justify-center flex-shrink-0 border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                            >
                                                <img
                                                    v-if="product.image_url"
                                                    :src="product.image_url"
                                                    :alt="product.name"
                                                    class="w-full h-full object-cover rounded-lg"
                                                />
                                                <svg
                                                    v-else
                                                    class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400"
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
                                                    class="text-xs sm:text-sm font-medium text-[#1D1842] dark:text-[#FDA1A2] truncate"
                                                >
                                                    {{ product.name }}
                                                </p>
                                                <p
                                                    class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 truncate"
                                                >
                                                    {{
                                                        product.description ||
                                                        "Tidak ada deskripsi"
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        v-if="popularProducts.length > 4"
                                        @click="toggleShowAllProducts"
                                        class="w-full mt-3 sm:mt-4 px-3 sm:px-4 py-1.5 sm:py-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg text-xs sm:text-sm font-medium hover:bg-[#FDA1A2]/30 dark:hover:bg-[#8E0D3C]/30 transition cursor-pointer active:scale-95"
                                    >
                                        {{ showAllProducts ? "Tutup" : "Lihat Semua" }}
                                    </button>
                                </aside>
                        </div>

                        <!-- Right Sidebar - Produk Populer (Desktop Only) -->
                        <aside
                            class="hidden lg:block w-80 bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6 h-fit"
                        >
                            <div class="flex items-center justify-between mb-4">
                                <h3
                                    class="text-base sm:text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]"
                                >
                                    Produk Populer
                                </h3>
                            </div>
                            <div class="space-y-4">
                                <div
                                    v-for="product in displayedProducts"
                                    :key="product.id"
                                    class="flex items-center gap-2 p-2 rounded-lg cursor-pointer hover:bg-[#FDA1A2]/5 dark:hover:bg-[#8E0D3C]/10 transition"
                                >
                                    <div
                                        class="w-12 h-12 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 rounded-lg flex items-center justify-center flex-shrink-0 border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                    >
                                        <img
                                            v-if="product.image_url"
                                            :src="product.image_url"
                                            :alt="product.name"
                                            class="w-full h-full object-cover rounded-lg"
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
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-medium text-[#1D1842] dark:text-[#FDA1A2] truncate"
                                        >
                                            {{ product.name }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-500 dark:text-gray-400 truncate"
                                        >
                                            {{
                                                product.description ||
                                                "Tidak ada deskripsi"
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <button
                                v-if="popularProducts.length > 4"
                                @click="toggleShowAllProducts"
                                class="w-full mt-4 px-4 py-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg text-sm font-medium hover:bg-[#FDA1A2]/30 dark:hover:bg-[#8E0D3C]/30 transition cursor-pointer active:scale-95"
                            >
                                {{ showAllProducts ? "Tutup" : "Lihat Semua" }}
                            </button>
                        </aside>
                    </div>
                </div>
            </main>
        </div>

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
import Chart from "chart.js/auto";
import Logo from "../components/Logo.vue";
import ConfirmModal from "../components/ConfirmModal.vue";

// Default collapsed di mobile, expanded di desktop
const sidebarCollapsed = ref(window.innerWidth <= 768);
const admin = ref(null);

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};
const stats = ref({
    totalUsers: 0,
    totalTransactions: 0,
});
const popularProducts = ref([]);
const showAllProducts = ref(false);
const confirmModal = ref({ visible: false, title: "", message: "" });

// Chart State
const salesChartCanvas = ref(null);
let salesChart = null;
const salesData = ref([]);
const loadingChart = ref(true);
const selectedPeriod = ref(30);

const selectedPeriodLabel = computed(() => {
    switch (selectedPeriod.value) {
        case 7: return "7 Hari";
        case 90: return "90 Hari";
        default: return "30 Hari";
    }
});

const changePeriod = (days) => {
    selectedPeriod.value = days;
    fetchSalesData();
};

const formatPrice = (price) => {
    return new Intl.NumberFormat("id-ID").format(price || 0);
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
        admin.value = response.data;
    } catch (error) {
        admin.value = null;
        window.location.href = "/admin/login";
    }
};

const fetchStats = async () => {
    try {
        // Fetch jumlah pengguna
        const usersResponse = await axios.get("/api/admin/users");
        stats.value.totalUsers = usersResponse.data?.length || 0;

        // Fetch total transaksi
        const transactionsResponse = await axios.get("/api/admin/transactions");
        const transactions = transactionsResponse.data || [];
        stats.value.totalTransactions = transactions.reduce(
            (sum, t) => sum + (parseFloat(t.total_price || t.total) || 0),
            0
        );
    } catch (error) {
        console.error("Error fetching stats:", error);
    }
};

const fetchSalesData = async () => {
    try {
        loadingChart.value = true;
        const response = await axios.get("/api/admin/sales-data", {
            params: { days: selectedPeriod.value }
        });
        salesData.value = response.data || [];
        
        await nextTick();
        initChart();
    } catch (error) {
        console.error("Error fetching sales data:", error);
    } finally {
        loadingChart.value = false;
    }
};

const initChart = () => {
    if (!salesChartCanvas.value) return;
    
    // Destroy existing chart if it exists
    if (salesChart) {
        salesChart.destroy();
    }
    
    const ctx = salesChartCanvas.value.getContext('2d');
    
    // Group and format data
    const labels = salesData.value.map(item => {
        const date = new Date(item.date);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    
    const totals = salesData.value.map(item => parseFloat(item.total));
    
    salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: totals,
                borderColor: '#EF3B33',
                backgroundColor: 'rgba(239, 59, 51, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#EF3B33'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp. ' + formatPrice(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) return (value / 1000000).toFixed(1) + 'jt';
                            if (value >= 1000) return (value / 1000) + 'rb';
                            return value;
                        },
                        font: { size: 10 }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    ticks: {
                        font: { size: 10 }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
};

const fetchPopularProducts = async () => {
    try {
        const response = await axios.get("/api/admin/popular-products");
        popularProducts.value = response.data || [];
    } catch (error) {
        console.error("Error fetching popular products:", error);
    }
};

const displayedProducts = computed(() => {
    if (showAllProducts.value) {
        return popularProducts.value;
    }
    return popularProducts.value.slice(0, 4);
});

const toggleShowAllProducts = () => {
    showAllProducts.value = !showAllProducts.value;
};

const handleProfile = () => {
    window.location.href = "/admin/profile";
};

const handleLogout = () => {
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
        window.location.href = "/";
    } catch (error) {
        console.error("Error logging out:", error);
        // Tetap redirect meskipun ada error
        window.location.href = "/";
    }
};

const handleUserUpdated = async () => {
    await checkAuth();
};

onMounted(async () => {
    await checkAuth();
    await fetchStats();
    await fetchPopularProducts();
    await fetchSalesData();
    window.addEventListener("userUpdated", handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener("userUpdated", handleUserUpdated);
});
</script>
