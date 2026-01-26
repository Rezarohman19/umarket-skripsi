<template>
    <div
        v-if="visible"
        class="fixed inset-0 flex items-center justify-center z-[100] px-3 sm:px-4 animate-fade-in"
    >
        <!-- Backdrop (optional, clickable to close) - Hanya untuk error -->
        <div 
            v-if="type !== 'success'"
            class="absolute inset-0 bg-black/20 backdrop-blur-sm"
            @click="$emit('close')"
        ></div>
        <div 
            v-else
            class="absolute inset-0 bg-black/20 backdrop-blur-sm"
        ></div>

        <!-- Card -->
        <div
            class="bg-white dark:bg-[#1D1842] rounded-xl sm:rounded-2xl shadow-2xl p-4 sm:p-6 max-w-sm w-full relative z-10 flex flex-col items-center text-center transform transition-all scale-100 border border-gray-100 dark:border-[#8E0D3C]/30"
        >
            <!-- Icon/Logo based on type -->
            <div
                class="w-12 h-12 sm:w-16 sm:h-16 rounded-full flex items-center justify-center mb-3 sm:mb-4 shadow-md"
                :class="
                    type === 'success'
                        ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400'
                        : 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400'
                "
            >
                <!-- Success Icon -->
                <svg
                    v-if="type === 'success'"
                    class="w-6 h-6 sm:w-8 sm:h-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="3"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                <!-- Error Icon -->
                <svg
                    v-else
                    class="w-6 h-6 sm:w-8 sm:h-8"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="3"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </div>

            <!-- Title - Hanya muncul untuk error -->
            <h3
                v-if="type !== 'success'"
                class="text-lg sm:text-xl font-bold mb-1.5 sm:mb-2 text-red-600 dark:text-red-400"
            >
                Gagal
            </h3>

            <!-- Message -->
            <p class="text-gray-600 dark:text-gray-300 text-base sm:text-lg font-medium" :class="type === 'success' ? 'mb-0' : 'mb-4 sm:mb-6'">
                {{ message }}
            </p>

            <!-- Close Button - Hanya muncul untuk error -->
            <button
                v-if="type !== 'success'"
                @click="$emit('close')"
                class="px-5 py-2 sm:px-6 sm:py-2 rounded-full text-sm sm:text-base font-semibold transition-colors shadow-sm mt-4 sm:mt-6 bg-red-600 hover:bg-red-700 text-white"
            >
                Tutup
            </button>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, watch } from "vue";

const props = defineProps({
    message: String,
    type: {
        type: String,
        default: "success", // 'success' or 'error'
    },
    visible: Boolean,
    duration: {
        type: Number,
        default: null, // null means auto: 1000ms for success, 3000ms for error
    },
});

const emit = defineEmits(["close"]);

let timer = null;

const startTimer = () => {
    if (timer) clearTimeout(timer);
    // Auto duration: 1000ms for success, 3000ms for error
    const duration = props.duration !== null ? props.duration : (props.type === 'success' ? 1000 : 3000);
    if (duration > 0) {
        timer = setTimeout(() => {
            emit("close");
        }, duration);
    }
};

watch(
    () => props.visible,
    (newVal) => {
        if (newVal) {
            startTimer();
        } else {
            if (timer) clearTimeout(timer);
        }
    }
);
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
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
