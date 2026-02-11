<template>
    <div class="min-h-screen bg-[#FDA1A2]/20 dark:bg-[#1D1842] flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="flex justify-center mb-8">
                <button @click="goToLanding" class="cursor-pointer hover:opacity-80 transition-opacity">
                    <img
                        src="/images/logo-u.png"
                        alt="U Marketplace"
                        class="h-32 w-auto object-contain"
                    />
                </button>
            </div>

            <div class="bg-white/98 backdrop-blur-sm dark:bg-[#1D1842] rounded-3xl shadow-md shadow-gray-300/30 dark:shadow-[#1D1842]/50 p-6 sm:p-8 md:p-10 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/30 max-h-[95vh] overflow-y-auto">
                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-3xl font-bold text-[#8E0D3C] dark:text-[#FDA1A2] mb-2">
                        Daftar
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Buat akun baru untuk mulai berbelanja
                    </p>
                </div>

                <div 
                    v-if="laravelErrors.name || laravelErrors.email || laravelErrors.password || laravelErrors.password_confirmation" 
                    class="mb-6 p-4 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 border border-[#EF3B33]/40 dark:border-[#EF3B33]/40 rounded-lg"
                >
                    <p v-if="laravelErrors.name" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.name }}</p>
                    <p v-if="laravelErrors.email" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.email }}</p>
                    <p v-if="laravelErrors.password" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.password }}</p>
                    <p v-if="laravelErrors.password_confirmation" class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ laravelErrors.password_confirmation }}</p>
                </div>

                <div 
                    v-if="success" 
                    class="mb-6 p-4 bg-[#FDA1A2]/20 dark:bg-[#FDA1A2]/20 border border-[#FDA1A2]/40 dark:border-[#FDA1A2]/40 rounded-lg"
                >
                    <p class="text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">{{ success }}</p>
                </div>

                <form method="POST" action="/register" class="space-y-6" @submit="handleSubmit">
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
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
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
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
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
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Masukkan kata sandi"
                            />
                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                            >
                                <svg v-if="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <p v-if="laravelErrors.password" class="mt-1 text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">
                            {{ laravelErrors.password }}
                        </p>
                    </div>

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
                                class="w-full px-4 py-3 bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-xl focus:outline-none transition-all duration-200 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                placeholder="Konfirmasi kata sandi"
                            />
                            <button
                                type="button"
                                @click="showPasswordConfirmation = !showPasswordConfirmation"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                            >
                                <svg v-if="showPasswordConfirmation" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <p v-if="laravelErrors.password_confirmation" class="mt-1 text-sm text-[#8E0D3C] dark:text-[#FDA1A2]">
                            {{ laravelErrors.password_confirmation }}
                        </p>
                    </div>

                    <input type="hidden" name="_token" :value="csrfToken" />

                    <button
                        type="submit"
                        :disabled="isLoading"
                        :class="{'opacity-50 cursor-not-allowed': isLoading, 'hover:shadow-lg': !isLoading}"
                        class="w-full bg-[#8E0D3C] dark:bg-[#8E0D3C] text-white font-semibold py-3.5 px-4 rounded-xl shadow-md shadow-[#8E0D3C]/20 dark:shadow-[#8E0D3C]/20 flex items-center justify-center transition-all duration-200"
                    >
                        <span v-if="!isLoading">Daftar</span>
                        <span v-else>Memproses...</span>
                        <svg
                            v-if="!isLoading"
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
                        <svg
                            v-else
                            class="w-5 h-5 ml-2 animate-spin"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                             <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                             <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>

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
const isLoading = ref(false);

const handleSubmit = (e) => {
    if (isLoading.value) {
        e.preventDefault();
        return;
    }
    isLoading.value = true;
};

onMounted(() => {
    const token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        csrfToken.value = token.content;
    }

    const errorElement = document.getElementById('laravel-errors');
    if (errorElement) {
        const errorTexts = errorElement.querySelectorAll('div[data-field]');
        errorTexts.forEach((errorDiv) => {
            const field = errorDiv.getAttribute('data-field');
            const errorText = errorDiv.textContent.trim();
            if (errorText && field) {
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
        errorElement.remove();
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('registered') === 'success') {
        success.value = 'Registrasi berhasil! Silakan masuk dengan akun Anda.';
    }
});

const goToLanding = () => {
    sessionStorage.removeItem('hideWelcomeCard');
    window.location.href = '/';
};
</script>

<style scoped>
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

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px rgba(253, 161, 162, 0.1) inset !important;
    -webkit-text-fill-color: #1f2937 !important;
    transition: background-color 5000s ease-in-out 0s;
}

.dark input:-webkit-autofill,
.dark input:-webkit-autofill:hover,
.dark input:-webkit-autofill:focus,
.dark input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 30px rgba(29, 24, 66, 0.5) inset !important;
    -webkit-text-fill-color: #ffffff !important;
}
</style>
