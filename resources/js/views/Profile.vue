<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] py-4 sm:py-6 px-3 sm:px-4 md:px-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Back -->
            <div
                class="flex items-center gap-2 text-[#1D1842] dark:text-[#FDA1A2] cursor-pointer"
                @click="goBack"
            >
                <svg
                    class="w-5 h-5"
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
                <span>Kembali</span>
            </div>

            <!-- Profile Card -->
            <div
                class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6"
            >
                <div class="flex flex-col items-center space-y-3 relative">
                    <!-- Foto Profil -->
                    <div
                        class="w-20 h-20 rounded-full overflow-hidden bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/30 flex items-center justify-center text-[#8E0D3C] dark:text-[#FDA1A2] text-sm border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40"
                    >
                        <img
                            v-if="imagePreview || profile.photo_url"
                            :src="imagePreview || profile.photo_url"
                            alt="Foto Profil"
                            class="w-full h-full object-cover"
                        />
                        <span v-else>Foto</span>
                    </div>
                    
                    <!-- Teks Edit (Hanya muncul saat mode editing) -->
                    <button
                        v-if="isEditing"
                        data-edit-button
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition"
                        @click.stop="showPhotoMenu = !showPhotoMenu"
                    >
                        Edit
                    </button>
                    
                    <!-- Card Menu Edit Foto (Muncul saat klik Edit) -->
                    <div
                        v-if="showPhotoMenu && isEditing"
                        data-photo-menu
                        class="absolute top-full mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-10 min-w-[160px] overflow-hidden"
                    >
                        <label class="block cursor-pointer">
                            <input
                                type="file"
                                accept="image/*"
                                class="hidden"
                                @change="onPhotoChange"
                            />
                            <div class="px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                Ganti Foto
                            </div>
                        </label>
                        <button
                            v-if="profile.photo_url || imagePreview"
                            class="w-full px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-left border-t border-gray-200 dark:border-gray-700"
                            @click="removePhoto"
                        >
                            Hapus Foto
                        </button>
                    </div>
                </div>

                <div
                    class="mt-6 space-y-4 text-sm"
                >
                    <div class="grid grid-cols-[130px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 gap-y-1 items-start">
                        <span class="text-gray-700 dark:text-gray-300 whitespace-nowrap text-left">Nama</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <div class="min-w-0">
                            <input
                                v-if="isEditing"
                                v-model="form.name"
                                type="text"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            />
                            <span v-else class="text-gray-900 dark:text-white break-words">{{ profile.name }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[130px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 gap-y-1 items-start">
                        <span class="text-gray-700 dark:text-gray-300 whitespace-nowrap text-left">Deskripsi</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <div class="min-w-0">
                            <textarea
                                v-if="isEditing"
                                v-model="form.description"
                                rows="2"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            ></textarea>
                            <span v-else class="text-gray-900 dark:text-white break-words">{{ profile.description }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[130px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 gap-y-1 items-start">
                        <span class="text-gray-700 dark:text-gray-300 whitespace-nowrap text-left">Telepon</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <div class="min-w-0">
                            <input
                                v-if="isEditing"
                                v-model="form.phone"
                                type="text"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            />
                            <span v-else class="text-gray-900 dark:text-white break-words">{{ profile.phone }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[130px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 gap-y-1 items-start">
                        <span class="text-gray-700 dark:text-gray-300 whitespace-nowrap text-left">Email</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <div class="min-w-0">
                            <input
                                v-if="isEditing"
                                v-model="form.email"
                                type="email"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            />
                            <span v-else class="text-gray-900 dark:text-white break-words">{{ profile.email }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[130px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 gap-y-1 items-start">
                        <span class="text-gray-700 dark:text-gray-300 whitespace-nowrap text-left">Alamat Lengkap</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <div class="min-w-0">
                            <textarea
                                v-if="isEditing"
                                v-model="form.address"
                                rows="2"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            ></textarea>
                            <span v-else class="text-gray-900 dark:text-white break-words">{{ profile.address }}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-[130px_auto_1fr] sm:grid-cols-[140px_auto_1fr] gap-x-2 gap-y-1 items-start">
                        <span class="text-gray-700 dark:text-gray-300 whitespace-nowrap text-left">Password</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <div class="min-w-0">
                            <input
                                v-if="isEditing"
                                v-model="form.password"
                                type="password"
                                placeholder="Isi untuk ubah password"
                                class="w-full px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-gray-900 dark:text-white focus:outline-none"
                            />
                            <span v-else class="text-gray-900 dark:text-white">********</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-end gap-2">
                    <button
                        v-if="isEditing"
                        class="px-5 py-2 bg-[#1D1842]/20 dark:bg-[#1D1842]/30 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg"
                        @click="cancelEdit"
                    >
                        Batal
                    </button>
                    <button
                        v-if="isEditing"
                        class="px-5 py-2 bg-[#EF3B33] text-white rounded-lg shadow-md"
                        @click="saveProfile"
                    >
                        Simpan
                    </button>
                    <button
                        v-else
                        class="px-5 py-2 bg-[#EF3B33] text-white rounded-lg shadow-md"
                        @click="startEdit"
                    >
                        Ubah
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Toast -->
        <transition name="fade">
            <div
                v-if="notification.show"
                :class="[
                    'fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm',
                    notification.type === 'success'
                        ? 'bg-green-500 text-white'
                        : 'bg-red-500 text-white',
                ]"
            >
                <div class="flex items-center gap-3">
                    <svg
                        v-if="notification.type === 'success'"
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
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
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                    <p class="font-medium">{{ notification.message }}</p>
                </div>
            </div>
        </transition>

        <!-- Success Modal -->
        <transition name="modal">
            <div
                v-if="showSuccessModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
                @click.self="showSuccessModal = false"
            >
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all"
                >
                    <div class="flex flex-col items-center text-center">
                        <!-- Success Icon -->
                        <div
                            class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-8 h-8 text-green-600 dark:text-green-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>

                        <!-- Message -->
                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white mb-2"
                        >
                            Berhasil!
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Perubahan profil Anda telah berhasil disimpan.
                        </p>

                        <!-- OK Button -->
                        <button
                            @click="showSuccessModal = false"
                            class="w-full px-6 py-3 bg-[#EF3B33] text-white rounded-lg font-semibold shadow-lg"
                        >
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import axios from "axios";

const profile = ref({
    name: "Nama",
    description: "Deskripsi",
    phone: "",
    email: "",
    address: "",
});

const form = ref({ ...profile.value, password: "" });
const isEditing = ref(false);
const imagePreview = ref(null);
const photoFile = ref(null);
const notification = ref({ show: false, message: "", type: "success" });
const showSuccessModal = ref(false);
const showPhotoMenu = ref(false);

const goBack = () => window.history.back();

const fetchProfile = async () => {
    try {
        // Tambahkan cache busting untuk memastikan data terbaru
        const response = await axios.get("/api/user", {
            params: { _t: Date.now() }
        });
        const user = response.data;

        // Gunakan photo_url dari API jika ada, atau generate dari photo path
        let photoUrl = user.photo_url || null;
        if (!photoUrl && user.photo) {
            photoUrl = user.photo.startsWith("/")
                ? user.photo
                : "/storage/" + user.photo;
        }

        // Tambahkan cache busting ke URL foto
        if (photoUrl && !photoUrl.includes('?')) {
            photoUrl = photoUrl + "?t=" + Date.now();
        } else if (photoUrl && photoUrl.includes('?')) {
            photoUrl = photoUrl.split('?')[0] + "?t=" + Date.now();
        }

        profile.value = {
            name: user.name || "Nama",
            description: user.description || "Deskripsi",
            phone: user.phone || "",
            email: user.email || "",
            address: user.address || "",
            photo_url: photoUrl,
        };
        form.value = { ...profile.value, password: "" };
        if (photoUrl) {
            imagePreview.value = photoUrl;
        }
    } catch (error) {
        window.location.href = "/login";
    }
};

const startEdit = () => {
    form.value = { ...profile.value, password: "" };
    photoFile.value = null;
    showPhotoMenu.value = false; // Reset menu saat mulai edit
    // Set imagePreview dari foto profil yang ada
    if (profile.value.photo_url) {
        imagePreview.value = profile.value.photo_url;
    } else {
        imagePreview.value = null;
    }
    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;
    showPhotoMenu.value = false; // Tutup menu saat cancel
    form.value = { ...profile.value, password: "" };
    photoFile.value = null;
    // Reset imagePreview ke foto profil yang ada
    if (profile.value.photo_url) {
        imagePreview.value = profile.value.photo_url;
    } else {
        imagePreview.value = null;
    }
};

const saveProfile = async () => {
    try {
        const payload = new FormData();
        payload.append("name", form.value.name);
        payload.append("description", form.value.description || "");
        payload.append("phone", form.value.phone || "");
        payload.append("email", form.value.email);
        payload.append("address", form.value.address || "");
        if (form.value.password) {
            payload.append("password", form.value.password);
        }
        if (photoFile.value) {
            payload.append("photo", photoFile.value);
        }
        if (!imagePreview.value && profile.value.photo_url) {
            payload.append("remove_photo", "1");
        }

        const response = await axios.post("/api/profile", payload, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        // Update profile dengan data terbaru
        const updatedUser = response.data.user;
        let photoUrl = updatedUser.photo_url;

        // Generate photo_url jika belum ada dari API
        if (!photoUrl && updatedUser.photo) {
            photoUrl = updatedUser.photo.startsWith("/")
                ? updatedUser.photo
                : "/storage/" + updatedUser.photo;
        }

        // Cache busting: tambah timestamp agar browser reload gambar
        if (photoUrl) {
            // Hapus query string lama jika ada, lalu tambah timestamp baru
            photoUrl = photoUrl.split('?')[0] + "?t=" + Date.now();
        }

        profile.value = {
            name: updatedUser.name,
            description: updatedUser.description || "",
            phone: updatedUser.phone || "",
            email: updatedUser.email,
            address: updatedUser.address || "",
            photo_url: photoUrl,
        };

        if (photoUrl) {
            imagePreview.value = photoUrl;
        } else {
            imagePreview.value = null;
        }

        form.value = { ...profile.value, password: "" };
        photoFile.value = null;
        isEditing.value = false;

        // Trigger event untuk refresh data user di halaman lain
        window.dispatchEvent(new CustomEvent('userUpdated', { 
            detail: { user: updatedUser, photoUrl: photoUrl } 
        }));

        // Tampilkan modal sukses
        showSuccessModal.value = true;

        // Reload halaman setelah 1.5 detik untuk update nama di header dan foto di semua halaman
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    } catch (error) {
        const message =
            error.response?.data?.message || "Gagal memperbarui profil";
        showNotification(message, "error");
    }
};

const onPhotoChange = (event) => {
    const file = event.target.files?.[0];
    if (file) {
        photoFile.value = file;
        imagePreview.value = URL.createObjectURL(file);
        showPhotoMenu.value = false; // Tutup menu setelah memilih foto
    }
};

const removePhoto = () => {
    photoFile.value = null;
    imagePreview.value = null;
    showPhotoMenu.value = false; // Tutup menu setelah menghapus foto
};

const showNotification = (message, type = "success") => {
    notification.value = { show: true, message, type };
    setTimeout(() => {
        notification.value.show = false;
    }, 3000);
};

// Fungsi untuk menutup menu saat klik di luar
const handleClickOutside = (event) => {
    const target = event.target;
    const photoMenu = document.querySelector('[data-photo-menu]');
    const editButton = document.querySelector('[data-edit-button]');
    
    if (showPhotoMenu.value && photoMenu && editButton) {
        if (!photoMenu.contains(target) && !editButton.contains(target)) {
            showPhotoMenu.value = false;
        }
    }
};

onMounted(async () => {
    await fetchProfile();
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
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
</style>
