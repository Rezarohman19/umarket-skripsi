<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 py-6 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Back -->
            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300 cursor-pointer hover:underline" @click="goBack">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>Kembali</span>
            </div>

            <!-- Profile Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-300 dark:border-gray-800 shadow-sm p-6">
                <div class="flex flex-col items-center space-y-3">
                    <label class="relative cursor-pointer group">
                        <input type="file" accept="image/*" class="hidden" @change="onPhotoChange" />
                        <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 text-sm border border-gray-300 dark:border-gray-700 group-hover:ring-2 group-hover:ring-blue-500 transition">
                            <img v-if="imagePreview" :src="imagePreview" alt="Foto" class="w-full h-full object-cover" />
                            <span v-else>Foto</span>
                        </div>
                        <div class="text-center mt-1 text-sm text-gray-500 dark:text-gray-400 group-hover:underline">Edit</div>
                    </label>
                    <button
                        v-if="imagePreview"
                        class="text-xs text-red-500 hover:text-red-600"
                        @click="removePhoto"
                    >
                        Hapus Foto
                    </button>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32">Nama</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.name"
                            type="text"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white">{{ profile.name }}</span>
                    </div>
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32">Deskripsi</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <textarea
                            v-if="isEditing"
                            v-model="form.description"
                            rows="2"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        ></textarea>
                        <span v-else class="text-gray-900 dark:text-white">{{ profile.description }}</span>
                    </div>
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32">Telepon</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.phone"
                            type="text"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white">{{ profile.phone }}</span>
                    </div>
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32">Email</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.email"
                            type="email"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white">{{ profile.email }}</span>
                    </div>
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32">Alamat Lengkap</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <textarea
                            v-if="isEditing"
                            v-model="form.address"
                            rows="2"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        ></textarea>
                        <span v-else class="text-gray-900 dark:text-white">{{ profile.address }}</span>
                    </div>
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32">Password</span>
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.password"
                            type="password"
                            placeholder="Isi untuk ubah password"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white">********</span>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button
                        v-if="isEditing"
                        class="px-5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                        @click="cancelEdit"
                    >
                        Batal
                    </button>
                    <button
                        v-if="isEditing"
                        class="px-5 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg shadow hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
                        @click="saveProfile"
                    >
                        Simpan
                    </button>
                    <button
                        v-else
                        class="px-5 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg shadow hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
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
                    notification.type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                ]"
            >
                <div class="flex items-center gap-3">
                    <svg v-if="notification.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <p class="font-medium">{{ notification.message }}</p>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const profile = ref({
    name: 'Nama',
    description: 'Deskripsi',
    phone: '',
    email: '',
    address: '',
});

const form = ref({ ...profile.value, password: '' });
const isEditing = ref(false);
const imagePreview = ref(null);
const photoFile = ref(null);
const notification = ref({ show: false, message: '', type: 'success' });

const goBack = () => window.history.back();

const fetchProfile = async () => {
    try {
        const response = await axios.get('/api/user');
        const user = response.data;
        profile.value = {
            name: user.name || 'Nama',
            description: user.description || 'Deskripsi',
            phone: user.phone || '',
            email: user.email || '',
            address: user.address || '',
        };
        form.value = { ...profile.value, password: '' };
        if (user.photo_url) {
            imagePreview.value = user.photo_url;
        }
    } catch (error) {
        window.location.href = '/login';
    }
};

const startEdit = () => {
    form.value = { ...profile.value, password: '' };
    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;
    form.value = { ...profile.value, password: '' };
    photoFile.value = null;
    if (!profile.value.photo_url) {
        imagePreview.value = null;
    }
};

const saveProfile = async () => {
    try {
        // TODO: Sambungkan ke endpoint update profil jika tersedia.
        // const payload = new FormData();
        // payload.append('name', form.value.name);
        // payload.append('description', form.value.description);
        // payload.append('phone', form.value.phone);
        // payload.append('email', form.value.email);
        // payload.append('address', form.value.address);
        // if (form.value.password) payload.append('password', form.value.password);
        // if (photoFile.value) payload.append('photo', photoFile.value);
        // await axios.post('/api/profile', payload);

        // Untuk sekarang, simpan ke state lokal
        profile.value = { ...form.value };
        isEditing.value = false;
        showNotification('Profil berhasil diperbarui', 'success');
    } catch (error) {
        showNotification('Gagal memperbarui profil', 'error');
    }
};

const onPhotoChange = (event) => {
    const file = event.target.files?.[0];
    if (file) {
        photoFile.value = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const removePhoto = () => {
    photoFile.value = null;
    imagePreview.value = null;
};

const showNotification = (message, type = 'success') => {
    notification.value = { show: true, message, type };
    setTimeout(() => {
        notification.value.show = false;
    }, 3000);
};

onMounted(async () => {
    await fetchProfile();
});
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s, transform 0.3s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
</style>

