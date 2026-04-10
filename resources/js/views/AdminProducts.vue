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

                <nav :class="[
                    'flex-1 space-y-3',
                    sidebarCollapsed ? 'px-2' : 'px-4'
                ]">
                    <a
                        href="/admin/dashboard"
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
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            />
                        </svg>
                        <span v-if="!sidebarCollapsed">Beranda</span>
                    </a>

                    <a
                        href="/admin/products"
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

            <main :class="[
                'flex-1 transition-all duration-300 overflow-x-hidden',
                sidebarCollapsed ? 'ml-16' : 'ml-64'
            ]">
                <header
                    class="bg-white dark:bg-[#1D1842] border-b border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm px-3 sm:px-6 py-3 sm:py-4 sticky top-0 z-10 w-full max-w-full overflow-hidden"
                >
                    <div class="flex flex-row items-center justify-between gap-2 sm:gap-0">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-base text-[#1D1842] dark:text-[#FDA1A2]">Halo, <span class="font-semibold">Admin</span></p>
                        </div>

                        <div class="flex-1 max-w-md w-full sm:w-auto mx-0 sm:mx-4 min-w-0">
                            <div class="relative">
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari produk"
                                    class="w-full px-2 sm:px-4 py-1.5 sm:py-2 pl-7 sm:pl-10 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg text-xs sm:text-base text-[#1D1842] dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none"
                                />
                                <svg
                                    class="w-3.5 h-3.5 sm:w-5 sm:h-5 absolute left-2 sm:left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
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

                <div class="p-3 sm:p-6 overflow-x-hidden">
                    <div class="flex flex-row items-center justify-between gap-2 sm:gap-0 mb-4">
                        <h2 class="text-sm sm:text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2]">Daftar Produk</h2>
                        <button
                            @click="openCreateModal"
                            class="px-2 sm:px-4 py-1.5 sm:py-2 bg-[#EF3B33] text-white rounded-lg text-xs sm:text-sm font-medium shadow cursor-pointer hover:bg-[#d92f25] transition active:scale-95 whitespace-nowrap"
                        >
                            + Tambah Produk
                        </button>
                    </div>

                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm overflow-hidden"
                    >
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-xs sm:text-sm">
                                <thead
                                    class="bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#8E0D3C] dark:text-[#FDA1A2]"
                                >
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left font-semibold"
                                        >
                                            Nama Toko
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left font-semibold"
                                        >
                                            Nama
                                        </th>
                                        <th
                                            class="px-4 py-3 text-left font-semibold"
                                        >
                                            Kategori / Deskripsi
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center font-semibold"
                                        >
                                            Stok
                                        </th>
                                        <th
                                            class="px-4 py-3 text-right font-semibold"
                                        >
                                            Harga
                                        </th>
                                        <th
                                            class="px-4 py-3 text-center font-semibold"
                                        >
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="product in filteredProducts"
                                        :key="product.id"
                                        class="border-t border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                                    >
                                        <td class="px-4 py-3 align-middle">
                                            <span
                                                class="text-gray-800 dark:text-gray-200 text-xs font-medium"
                                            >
                                                {{
                                                    product.user?.name || "Toko"
                                                }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-medium"
                                            >
                                                {{ product.name }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 align-middle">
                                            <span
                                                class="block text-gray-600 dark:text-gray-400 truncate max-w-xs"
                                            >
                                                {{ product.description || "-" }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-center"
                                        >
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-medium"
                                            >
                                                {{ product.stock }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-right"
                                        >
                                            <span
                                                class="text-gray-800 dark:text-gray-200 font-semibold"
                                            >
                                                Rp.
                                                {{ formatPrice(product.price) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-4 py-3 align-middle text-center"
                                        >
                                            <button
                                                class="px-3 py-1 text-xs rounded-full bg-[#EF3B33]/20 dark:bg-[#EF3B33]/20 text-[#EF3B33] dark:text-[#EF3B33] cursor-pointer hover:bg-[#EF3B33]/30 dark:hover:bg-[#EF3B33]/30 transition active:scale-95"
                                                @click="openDeleteConfirm(product)"
                                            >
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    <tr
                                        v-if="
                                            !loading &&
                                            filteredProducts.length === 0
                                        "
                                    >
                                        <td
                                            colspan="6"
                                            class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            Tidak ada produk yang cocok.
                                        </td>
                                    </tr>
                                    <tr v-if="loading">
                                        <td
                                            colspan="6"
                                            class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            Memuat produk...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div
                    v-if="showModal"
                    class="fixed inset-0 z-20 flex items-center justify-center bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 backdrop-blur-sm p-3 sm:p-4"
                >
                    <div
                        class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-xl w-full max-w-lg p-4 sm:p-6 border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 max-h-[90vh] overflow-y-auto"
                    >
                        <h3
                            class="text-lg font-semibold text-[#1D1842] dark:text-[#FDA1A2] mb-4"
                        >
                            Tambah Produk
                        </h3>

                        <div class="space-y-4 text-sm">
                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Nama Produk</label
                                >
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Kategori</label
                                >
                                <input
                                    v-model="form.category"
                                    type="text"
                                    placeholder="Masukkan kategori produk"
                                    class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Deskripsi</label
                                >
                                <textarea
                                    v-model="form.description"
                                    rows="3"
                                    class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                ></textarea>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                        >Harga</label
                                    >
                                    <input
                                        v-model="priceInput"
                                        type="text"
                                        placeholder="Contoh: Rp 10.000 atau 10000"
                                        @input="handlePriceInput"
                                        @blur="formatPriceInput"
                                        class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                        >Stok</label
                                    >
                                    <input
                                        v-model.number="form.stock"
                                        type="number"
                                        min="0"
                                        class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-[#1D1842] dark:text-[#FDA1A2] mb-1"
                                    >Gambar Produk (bisa lebih dari 1)</label
                                >
                                <div class="flex items-center gap-3 flex-wrap">
                                    <label
                                        class="w-28 h-28 border border-dashed border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg flex items-center justify-center bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 cursor-pointer hover:bg-[#FDA1A2]/20 dark:hover:bg-[#1D1842]/60 transition"
                                    >
                                        <input
                                            type="file"
                                            accept="image/*"
                                            class="hidden"
                                            multiple
                                            @change="onImageChange"
                                        />
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Upload</span>
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

                        <div class="mt-6 flex justify-end gap-2">
                            <button
                                class="px-4 py-2 rounded-lg bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#1D1842] dark:text-[#FDA1A2] text-sm cursor-pointer hover:bg-[#FDA1A2]/30 dark:hover:bg-[#8E0D3C]/30 transition active:scale-95"
                                @click="closeModal"
                            >
                                Batal
                            </button>
                            <button
                                class="px-4 py-2 rounded-lg bg-[#EF3B33] text-white text-sm font-medium shadow cursor-pointer hover:bg-[#d92f25] transition active:scale-95"
                                @click="saveProduct"
                            >
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <ConfirmModal
            :visible="confirmModal.visible"
            :title="confirmModal.title"
            :message="confirmModal.message"
            @confirm="handleConfirmLogout"
            @cancel="closeConfirmModal"
        />

        <ConfirmModal
            :visible="deleteConfirm.visible"
            :title="deleteConfirm.title"
            :message="deleteConfirm.message"
            @confirm="handleConfirmDelete"
            @cancel="closeDeleteConfirm"
        />

        <ToastNotification
            :visible="toast.visible"
            :message="toast.message"
            :type="toast.type"
            :duration="2500"
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
const searchQuery = ref("");
const admin = ref(null);

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};
const products = ref([]);
const loading = ref(true);

const showModal = ref(false);
const confirmModal = ref({ visible: false, title: "", message: "" });
const deleteConfirm = ref({ visible: false, title: "", message: "", product: null });
const toast = ref({ visible: false, message: "", type: "success" });
const form = ref({
    name: "",
    category: "",
    description: "",
    price: 0,
    stock: 0,
    imageFiles: [],
    imagePreviews: [],
});

const formatPrice = (price) =>
    new Intl.NumberFormat("id-ID").format(price || 0);

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

const filteredProducts = computed(() => {
    if (!searchQuery.value) return products.value;
    const q = searchQuery.value.toLowerCase();
    return products.value.filter((p) => {
        return (
            (p.name || "").toLowerCase().includes(q) ||
            (p.description || "").toLowerCase().includes(q) ||
            (p.user?.name || "").toLowerCase().includes(q)
        );
    });
});

const fetchProducts = async () => {
    try {
        loading.value = true;
        const response = await axios.get("/api/products");
        products.value = response.data || [];
    } catch (error) {
        console.error("Error fetching products:", error);
        products.value = [];
    } finally {
        loading.value = false;
    }
};

const handleProfile = () => {
    window.location.href = "/admin/profile";
};

const resetForm = () => {
    form.value = {
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

const openCreateModal = () => {
    resetForm();
    showModal.value = true;
};

const openDeleteConfirm = (product) => {
    deleteConfirm.value = {
        visible: true,
        title: "Konfirmasi Hapus",
        message: `Apakah Anda yakin ingin menghapus produk "${product.name}"? Produk akan terhapus dari beranda dan landing page.`,
        product,
    };
};

const closeDeleteConfirm = () => {
    deleteConfirm.value = { visible: false, title: "", message: "", product: null };
};

const handleConfirmDelete = async () => {
    const product = deleteConfirm.value.product;
    if (!product) {
        closeDeleteConfirm();
        return;
    }
    try {
        await axios.delete(`/api/products/${product.id}`);
        closeDeleteConfirm();
        await fetchProducts();
        toast.value = { visible: true, message: "Berhasil menghapus produk", type: "success" };
    } catch (error) {
        console.error("Error deleting product:", error);
        alert("Gagal menghapus produk");
    }
};

const closeModal = () => {
    showModal.value = false;
    priceInput.value = "";
    form.value.imagePreviews = [];
};

const onImageChange = (event) => {
    const files = Array.from(event.target.files || []);
    if (!files.length) return;
    files.forEach((file) => {
        form.value.imageFiles.push(file);
        form.value.imagePreviews.push(URL.createObjectURL(file));
    });
};

const removeImage = (index) => {
    form.value.imageFiles.splice(index, 1);
    form.value.imagePreviews.splice(index, 1);
};

const saveProduct = async () => {
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
    if (!form.value.imageFiles.length) {
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
    payload.append("price", String(form.value.price || 0));
    payload.append("stock", String(form.value.stock || 0));
    form.value.imageFiles.forEach((file) => payload.append("images[]", file));

    try {
        await axios.post("/api/products", payload, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        await fetchProducts();
        closeModal();
        toast.value = {
            visible: true,
            message: "Produk berhasil disimpan",
            type: "success",
        };
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

const handleLogout = () => {
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
        window.location.href = "/";
    }
};

const handleUserUpdated = async () => {
    await checkAuth();
};

onMounted(async () => {
    await checkAuth();
    await fetchProducts();
    window.addEventListener("userUpdated", handleUserUpdated);
});

onBeforeUnmount(() => {
    window.removeEventListener("userUpdated", handleUserUpdated);
});
</script>
