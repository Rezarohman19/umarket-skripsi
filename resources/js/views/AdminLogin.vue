<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo Container -->
            <div class="flex justify-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <span class="text-4xl font-bold text-white">U</span>
                </div>
            </div>

            <!-- Login Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 md:p-10 border border-gray-100 dark:border-gray-700">
                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Hi, Admin!
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Masuk sebagai Admin
                    </p>
                </div>

                <!-- Error Message dari Laravel -->
                <div 
                    v-if="laravelErrors.email" 
                    class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg"
                >
                    <p class="text-sm text-red-600 dark:text-red-400">{{ laravelErrors.email }}</p>
                </div>

                <!-- Login Form - Form submission tradisional Laravel -->
                <form method="POST" action="/login" class="space-y-6">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Admin
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autocomplete="email"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="admin@umarket.com"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>
                        <p v-if="laravelErrors.email" class="mt-1 text-sm text-red-600 dark:text-red-400">
                            {{ laravelErrors.email }}
                        </p>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Masukkan kata sandi"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                            >
                                <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.953 9.953 0 00-1.563 3.029M6.29 6.29L3 3m3.29 3.29l4.243 4.243" />
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <p v-if="laravelErrors.password" class="mt-1 text-sm text-red-600 dark:text-red-400">
                            {{ laravelErrors.password }}
                        </p>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-end">
                        <label class="flex items-center cursor-pointer group">
                            <input
                                name="remember"
                                type="checkbox"
                                value="1"
                                class="w-4 h-4 text-indigo-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:ring-2"
                            />
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                                Ingat Saya
                            </span>
                        </label>
                    </div>

                    <!-- CSRF Token (Laravel membutuhkan ini) -->
                    <input type="hidden" name="_token" :value="csrfToken" />

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk sebagai Admin
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';

const showPassword = ref(false);
const csrfToken = ref('');
const laravelErrors = reactive({
    email: '',
    password: ''
});

// Get CSRF token from meta tag dan error dari Laravel
onMounted(() => {
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        csrfToken.value = token.content;
    }

    // Cek apakah ada error dari Laravel
    const errorElement = document.getElementById('laravel-errors');
    if (errorElement) {
        const errorText = errorElement.textContent.trim();
        if (errorText) {
            laravelErrors.email = errorText;
            // Hapus element setelah diambil
            errorElement.remove();
        }
    }
});
</script>

<style scoped>
/* Custom animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bg-white {
    animation: fadeIn 0.5s ease-out;
}
</style>

