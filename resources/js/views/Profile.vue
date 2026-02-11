<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] py-4 sm:py-6 px-3 sm:px-4 md:px-6">
        <div class="max-w-4xl mx-auto space-y-6">
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

            <div
                class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6"
            >
                <div class="flex flex-col items-center space-y-3 relative">
                    <div
                        class="w-20 h-20 rounded-full overflow-hidden bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/30 flex items-center justify-center text-[#8E0D3C] dark:text-[#FDA1A2] text-sm border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40"
                    >
                        <img v-if="imagePreview || profile.photo_url" :src="imagePreview || profile.photo_url" alt="Foto Profil" class="w-full h-full object-cover" />
                        <span v-else>Foto</span>
                    </div>
                    
                    <button
                        v-if="isEditing"
                        data-edit-button
                        class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 transition"
                        @click.stop="showPhotoMenu = !showPhotoMenu"
                    >
                        Edit
                    </button>
                    
                    <div
                        v-if="showPhotoMenu && isEditing"
                        data-photo-menu
                        class="absolute top-full mt-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-10 min-w-[160px] overflow-hidden"
                    >
                        <label class="block cursor-pointer">
                            <input type="file" accept="image/*" class="hidden" @change="onPhotoChange" />
                            <div class="px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">Ganti Foto</div>
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

            <div
                class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6"
            >
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Rekening Bank
                    </h3>
                    <button
                        @click="showAddBankModal = true"
                        class="px-4 py-2 bg-[#EF3B33] text-white text-sm rounded-lg shadow-sm hover:bg-[#d92f25] transition"
                    >
                        Tambah Rekening
                    </button>
                </div>

                <div v-if="loadingBanks" class="text-center py-4">
                    <p class="text-gray-500 text-sm">Memuat rekening...</p>
                </div>
                <div v-else-if="banks.length === 0" class="text-center py-4">
                    <p class="text-gray-500 text-sm">Belum ada rekening terdaftar.</p>
                </div>
                <div v-else class="space-y-3">
                    <div
                        v-for="bank in banks"
                        :key="bank.id"
                        class="flex items-center justify-between p-4 bg-[#FDA1A2]/10 dark:bg-[#8E0D3C]/10 rounded-xl border border-[#FDA1A2]/20 dark:border-[#8E0D3C]/20"
                    >
                        <div>
                            <p class="font-semibold text-[#8E0D3C] dark:text-[#FDA1A2]">
                                {{ bank.bank_name }}
                            </p>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                {{ bank.account_number }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                a.n. {{ bank.account_holder }}
                            </p>
                        </div>
                        <button
                            @click="deleteBank(bank.id)"
                            class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-4 sm:p-6"
            >
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Riwayat Penarikan Saldo
                </h3>

                <div v-if="loadingWithdrawals" class="text-center py-4">
                    <p class="text-gray-500 text-sm">Memuat riwayat...</p>
                </div>
                <div v-else-if="withdrawals.length === 0" class="text-center py-4">
                    <p class="text-gray-500 text-sm">Belum ada riwayat penarikan.</p>
                </div>
                <div v-else class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Rekening</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <tr v-for="w in withdrawals" :key="w.id" class="text-gray-700 dark:text-gray-300">
                                <td class="px-4 py-3">{{ formatDate(w.created_at) }}</td>
                                <td class="px-4 py-3 font-semibold">Rp {{ formatPrice(w.amount) }}</td>
                                <td class="px-4 py-3">
                                    <div class="text-xs">
                                        {{ w.bank_account?.bank_name }}<br>
                                        {{ w.bank_account?.account_number }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium"
                                        :class="getWithdrawalStatusClass(w.status)"
                                    >
                                        {{ getWithdrawalStatusLabel(w.status) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <transition name="modal">
            <div
                v-if="showAddBankModal"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                @click.self="showAddBankModal = false"
            >
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                        Tambah Rekening Baru
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Bank</label>
                            <input
                                v-model="bankForm.bank_name"
                                type="text"
                                placeholder="Contoh: BCA, Mandiri, BRI"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Rekening</label>
                            <input
                                v-model="bankForm.account_number"
                                type="text"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Pemilik Rekening</label>
                            <input
                                v-model="bankForm.account_holder"
                                type="text"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg dark:bg-gray-800 dark:text-white"
                            />
                        </div>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <button
                            @click="showAddBankModal = false"
                            class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium"
                        >
                            Batal
                        </button>
                        <button
                            @click="addBank"
                            :disabled="submittingBank"
                            class="flex-1 px-4 py-2 bg-[#EF3B33] text-white rounded-lg font-semibold disabled:bg-gray-400"
                        >
                            {{ submittingBank ? 'Menyimpa...' : 'Simpan' }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>

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

        <transition name="modal">
            <div
                v-if="showSuccessModal"
                class="fixed inset-0 bg-[#FDA1A2]/40 dark:bg-[#1D1842]/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                @click.self="showSuccessModal = false"
            >
                <div
                    class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all"
                >
                    <div class="flex flex-col items-center text-center">
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

                        <h3
                            class="text-xl font-semibold text-gray-900 dark:text-white mb-2"
                        >
                            Berhasil!
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Perubahan profil Anda telah berhasil disimpan.
                        </p>

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

const banks = ref([]);
const withdrawals = ref([]);
const loadingBanks = ref(false);
const loadingWithdrawals = ref(false);
const showAddBankModal = ref(false);
const submittingBank = ref(false);
const bankForm = ref({
    bank_name: "",
    account_number: "",
    account_holder: "",
});

const goBack = () => window.history.back();

const fetchProfile = async () => {
    try {
        const response = await axios.get("/api/user", {
            params: { _t: Date.now() }
        });
        const user = response.data;

        let photoUrl = user.photo_url || null;
        if (!photoUrl && user.photo) {
            photoUrl = user.photo.startsWith("/")
                ? user.photo
                : "/storage/" + user.photo;
        }

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
    showPhotoMenu.value = false;
    if (profile.value.photo_url) {
        imagePreview.value = profile.value.photo_url;
    } else {
        imagePreview.value = null;
    }
    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;
    showPhotoMenu.value = false;
    form.value = { ...profile.value, password: "" };
    photoFile.value = null;
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

        const updatedUser = response.data.user;
        let photoUrl = updatedUser.photo_url;

        if (!photoUrl && updatedUser.photo) {
            photoUrl = updatedUser.photo.startsWith("/")
                ? updatedUser.photo
                : "/storage/" + updatedUser.photo;
        }

        if (photoUrl) {
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

        window.dispatchEvent(new CustomEvent('userUpdated', { 
            detail: { user: updatedUser, photoUrl: photoUrl } 
        }));

        showSuccessModal.value = true;

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
        showPhotoMenu.value = false;
    }
};

const removePhoto = () => {
    photoFile.value = null;
    imagePreview.value = null;
    showPhotoMenu.value = false;
};

const showNotification = (message, type = "success") => {
    notification.value = { show: true, message, type };
    setTimeout(() => {
        notification.value.show = false;
    }, 3000);
};

const fetchBanks = async () => {
    loadingBanks.value = true;
    try {
        const response = await axios.get("/user-banks");
        banks.value = response.data;
    } catch (error) {
        console.error("Error fetching banks:", error);
    } finally {
        loadingBanks.value = false;
    }
};

const addBank = async () => {
    if (!bankForm.value.bank_name || !bankForm.value.account_number || !bankForm.value.account_holder) {
        showNotification("Semua field harus diisi", "error");
        return;
    }
    submittingBank.value = true;
    try {
        await axios.post("/user-banks", bankForm.value);
        showAddBankModal.value = false;
        bankForm.value = { bank_name: "", account_number: "", account_holder: "" };
        showNotification("Rekening berhasil ditambahkan");
        fetchBanks();
    } catch (error) {
        showNotification(error.response?.data?.message || "Gagal menambah rekening", "error");
    } finally {
        submittingBank.value = false;
    }
};

const deleteBank = async (id) => {
    if (!confirm("Hapus rekening ini?")) return;
    try {
        await axios.delete(`/user-banks/${id}`);
        showNotification("Rekening berhasil dihapus");
        fetchBanks();
    } catch (error) {
        showNotification("Gagal menghapus rekening", "error");
    }
};

const fetchWithdrawals = async () => {
    loadingWithdrawals.value = true;
    try {
        const response = await axios.get("/user-withdrawals");
        withdrawals.value = response.data;
    } catch (error) {
        console.error("Error fetching withdrawals:", error);
    } finally {
        loadingWithdrawals.value = false;
    }
};

const formatPrice = (price) => new Intl.NumberFormat("id-ID").format(price);

const formatDate = (date) => {
    if (!date) return "";
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const getWithdrawalStatusLabel = (status) => {
    const labels = {
        pending: "Menunggu",
        processing: "Diproses",
        completed: "Selesai",
        rejected: "Ditolak",
    };
    return labels[status] || status;
};

const getWithdrawalStatusClass = (status) => {
    const classes = {
        pending: "bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400",
        processing: "bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400",
        completed: "bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400",
        rejected: "bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400",
    };
    return classes[status] || "bg-gray-100 text-gray-700";
};

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
    await fetchBanks();
    await fetchWithdrawals();
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
