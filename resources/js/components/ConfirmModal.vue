<template>
    <div
        v-if="visible"
        class="fixed inset-0 flex items-center justify-center z-[100] px-4 animate-fade-in"
    >
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        <!-- Card -->
        <div
            class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl p-6 max-w-sm w-full relative z-10 flex flex-col items-center text-center border border-gray-100 dark:border-[#8E0D3C]/30"
        >
            <!-- Logo Icon (Question) -->
            <div
                class="w-16 h-16 rounded-full bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#EF3B33] dark:text-[#FDA1A2] flex items-center justify-center mb-4 shadow-sm"
            >
                <svg
                    class="w-8 h-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2.5"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>

            <!-- Title -->
            <h3 class="text-xl font-bold text-[#1D1842] dark:text-[#FDA1A2] mb-2">
                {{ title }}
            </h3>

            <!-- Message -->
            <p class="text-gray-600 dark:text-gray-300 mb-8">
                {{ message }}
            </p>

            <!-- Actions -->
            <div class="flex items-center gap-3 w-full">
                <button
                    @click="$emit('cancel')"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-white/5 transition-colors"
                >
                    Batal
                </button>
                <button
                    @click="$emit('confirm')"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-[#EF3B33] text-white font-medium hover:bg-[#d92f25] shadow-md transition-colors"
                >
                    Ya
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: "Konfirmasi",
    },
    message: {
        type: String,
        default: "Apakah Anda yakin?",
    },
    visible: Boolean,
});

defineEmits(["confirm", "cancel"]);
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
