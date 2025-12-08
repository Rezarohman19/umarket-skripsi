<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 py-6 px-4 sm:px-6">
        <div class="max-w-5xl mx-auto space-y-4">
            <!-- Back -->
            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300 cursor-pointer hover:underline" @click="goBack">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali</span>
            </div>

            <!-- Title -->
            <h1 class="text-xl font-semibold text-center text-gray-900 dark:text-white">Keranjang Saya</h1>

            <!-- Cart List -->
            <div class="space-y-4">
                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-800 shadow-sm p-4 flex items-center gap-4"
                >
                    <!-- Checkbox placeholder -->
                    <div class="w-5 h-5 bg-gray-200 dark:bg-gray-800 rounded"></div>

                    <!-- Image -->
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 flex items-center justify-center rounded-md">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ item.store }}</p>
                        <p class="text-sm text-gray-800 dark:text-gray-100 font-semibold">{{ item.product }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ item.category }}</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mt-1">Rp. {{ formatPrice(item.price) }}</p>
                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center gap-3">
                        <button
                            class="w-8 h-8 border border-gray-300 dark:border-gray-700 rounded-md text-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800"
                            @click="decrease(item.id)"
                        >-</button>
                        <div class="w-10 text-center text-gray-900 dark:text-white font-semibold">{{ item.qty }}</div>
                        <button
                            class="w-8 h-8 border border-gray-300 dark:border-gray-700 rounded-md text-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800"
                            @click="increase(item.id)"
                        >+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const cartItems = ref([
    { id: 1, store: 'Nama Toko', product: 'Nama Produk', category: 'Kategori', price: 3000, qty: 1 },
    { id: 2, store: 'Nama Toko', product: 'Nama Produk', category: 'Kategori', price: 3000, qty: 1 },
    { id: 3, store: 'Nama Toko', product: 'Nama Produk', category: 'Kategori', price: 3000, qty: 1 },
]);

const goBack = () => window.history.back();

const formatPrice = (price) => new Intl.NumberFormat('id-ID').format(price);

const increase = (id) => {
    const item = cartItems.value.find((i) => i.id === id);
    if (item) item.qty += 1;
};

const decrease = (id) => {
    const item = cartItems.value.find((i) => i.id === id);
    if (item && item.qty > 1) item.qty -= 1;
};
</script>

<style scoped>
</style>

