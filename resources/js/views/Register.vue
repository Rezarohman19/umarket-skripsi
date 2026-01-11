<template>
    <div class="min-h-screen bg-[#FDA1A2]/20 dark:bg-[#1D1842] flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo Container -->
            <div class="flex justify-center mb-8">
                <img
                    src="/images/logo-u-marketplace.png"
                    alt="U Marketplace"
                    class="h-32 w-auto object-contain"
                />
            </div>

            <!-- Register Card -->
            <div class="bg-white/98 backdrop-blur-sm dark:bg-[#1D1842] rounded-3xl shadow-md shadow-gray-300/30 dark:shadow-[#1D1842]/50 p-8 md:p-10 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/30">
                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-[#8E0D3C] dark:text-[#FDA1A2] mb-2">
                        Daftar
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Buat akun baru untuk mulai berbelanja
                    </p>
                </div>

                <!-- Error Message dari Laravel -->
                <div 
                    v-if="laravelErrors.name || laravelErrors.email || laravelErrors.password || laravelErrors.password_confirmation" 
                    class="mb-6 p-4 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 border border-[#EF3B33]/40 dark:border-[#EF3B33]/40 rounded-lg"
                >
                    <p v-if="laravelErrors.name" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.name }}</p>
                    <p v-if="laravelErrors.email" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.email }}</p>
                    <p v-if="laravelErrors.password" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.password }}</p>
                    <p v-if="laravelErrors.password_confirmation" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.password_confirmation }}</p>
                </div>

                <!-- Success Message -->
                <div 
                    v-if="success" 
                    class="mb-6 p-4 bg-[#FDA1A2]/20 dark:bg-[#FDA1A2]/20 border border-[#FDA1A2]/40 dark:border-[#FDA1A2]/40 rounded-lg"
                >
                    <p class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ success }}</p>
                </div>

                <!-- Register Form - Form submission tradisional Laravel -->
                <form method="POST" action="/register" class="space-y-6">
                    <!-- Nama Input -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                            Nama
                        </label>
                        <div class="relative">
                            <input
                                id="name"
                                name="name"
                                type="text"
                                required
                                autocomplete="name"
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF3B33] focus:border-transparent transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Masukkan nama lengkap"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <p v-if="laravelErrors.name" class="mt-1 text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">
                            {{ laravelErrors.name }}
                        </p>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                required
                                autocomplete="email"
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF3B33] focus:border-transparent transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="nama@email.com"
                            />
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>
                        <p v-if="laravelErrors.email" class="mt-1 text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">
                            {{ laravelErrors.email }}
                        </p>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <input
                                id="password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF3B33] focus:border-transparent transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
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
                        <p v-if="laravelErrors.password" class="mt-1 text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">
                            {{ laravelErrors.password }}
                        </p>
                    </div>

                    <!-- Konfirmasi Password Input -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                            Konfirmasi Kata Sandi
                        </label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                :type="showPasswordConfirmation ? 'text' : 'password'"
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#EF3B33] focus:border-transparent transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Konfirmasi kata sandi"
                            />
                            <button
                                type="button"
                                @click="showPasswordConfirmation = !showPasswordConfirmation"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                            >
                                <svg v-if="showPasswordConfirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.953 9.953 0 00-1.563 3.029M6.29 6.29L3 3m3.29 3.29l4.243 4.243" />
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <p v-if="laravelErrors.password_confirmation" class="mt-1 text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">
                            {{ laravelErrors.password_confirmation }}
                        </p>
                    </div>

                    <!-- CSRF Token (Laravel membutuhkan ini) -->
                    <input type="hidden" name="_token" :value="csrfToken" />

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full bg-[#8E0D3C] dark:bg-[#8E0D3C] text-white font-semibold py-3.5 px-4 rounded-xl shadow-md shadow-[#8E0D3C]/20 dark:shadow-[#8E0D3C]/20 flex items-center justify-center"
                    >
                        <span>Daftar</span>
                        <svg
                            class="w-5 h-5 ml-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                            />
                        </svg>
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Sudah Punya Akun?
                        <a
                            href="/login"
                            class="ml-1 font-semibold text-[#EF3B33] dark:text-[#FDA1A2] hover:text-[#8E0D3C] dark:hover:text-[#EF3B33] transition-colors duration-200"
                        >
                            Masuk
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from 'vue';

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);
const csrfToken = ref('');
const success = ref('');
const laravelErrors = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
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
        const errorTexts = errorElement.querySelectorAll('div[data-field]');
        errorTexts.forEach((errorDiv) => {
            const field = errorDiv.getAttribute('data-field');
            const errorText = errorDiv.textContent.trim();
            if (errorText && field) {
                // Assign error ke field yang sesuai
                if (field === 'name') {
                    laravelErrors.name = errorText;
                } else if (field === 'email') {
                    laravelErrors.email = errorText;
                } else if (field === 'password') {
                    laravelErrors.password = errorText;
                } else if (field === 'password_confirmation') {
                    laravelErrors.password_confirmation = errorText;
                }
            }
        });
        // Hapus element setelah diambil
        errorElement.remove();
    }

    // Cek apakah ada success message dari Laravel (setelah redirect)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('registered') === 'success') {
        success.value = 'Registrasi berhasil! Silakan masuk dengan akun Anda.';
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

