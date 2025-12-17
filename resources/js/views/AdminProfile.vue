<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-950 py-6 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <!-- Back -->
            <div
                class="flex items-center gap-2 text-gray-700 dark:text-gray-300 cursor-pointer hover:underline"
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
                class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-300 dark:border-gray-800 shadow-sm p-6"
            >
                <div class="flex flex-col items-center space-y-3 relative">
                    <!-- Foto Profil -->
                    <div
                        class="w-20 h-20 rounded-full overflow-hidden bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-300 text-sm border border-gray-300 dark:border-gray-700"
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
                    class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm"
                >
                    <!-- Nama -->
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32"
                            >Nama</span
                        >
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.name"
                            type="text"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white">{{
                            profile.name
                        }}</span>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32"
                            >Email</span
                        >
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.email"
                            type="email"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white">{{
                            profile.email
                        }}</span>
                    </div>

                    <!-- Telepon -->
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32"
                            >Telepon</span
                        >
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.phone"
                            type="text"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white">{{
                            profile.phone
                        }}</span>
                    </div>

                    <!-- Password -->
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-gray-700 dark:text-gray-300 w-32"
                            >Password</span
                        >
                        <span class="text-gray-700 dark:text-gray-300">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.password"
                            type="password"
                            placeholder="Isi untuk ubah password"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        <span v-else class="text-gray-900 dark:text-white"
                            >********</span
                        >
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
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import axios from "axios";

const profile = ref({
    name: "Nama",
    email: "",
    phone: "",
    photo_url: null,
});

const form = ref({ ...profile.value, password: "" });
const isEditing = ref(false);
const imagePreview = ref(null);
const photoFile = ref(null);
const showPhotoMenu = ref(false);

const goBack = () => window.history.back();

const fetchProfile = async () => {
    try {
        const response = await axios.get("/api/user", {
            params: { _t: Date.now() },
        });
        const user = response.data;

        let photoUrl = user.photo_url || null;
        if (!photoUrl && user.photo) {
            photoUrl = user.photo.startsWith("/")
                ? user.photo
                : "/storage/" + user.photo;
        }

        if (photoUrl) {
            photoUrl = photoUrl.split("?")[0] + "?t=" + Date.now();
        }

        profile.value = {
            name: user.name || "Nama",
            email: user.email || "",
            phone: user.phone || "",
            photo_url: photoUrl,
        };
        form.value = { ...profile.value, password: "" };
        imagePreview.value = photoUrl;
    } catch (error) {
        window.location.href = "/admin/login";
    }
};

const startEdit = () => {
    form.value = { ...profile.value, password: "" };
    photoFile.value = null;
    showPhotoMenu.value = false;
    imagePreview.value = profile.value.photo_url || null;
    isEditing.value = true;
};

const cancelEdit = () => {
    isEditing.value = false;
    showPhotoMenu.value = false;
    form.value = { ...profile.value, password: "" };
    photoFile.value = null;
    imagePreview.value = profile.value.photo_url || null;
};

const saveProfile = async () => {
    try {
        const payload = new FormData();
        payload.append("name", form.value.name);
        payload.append("phone", form.value.phone || "");
        payload.append("email", form.value.email);
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
            photoUrl = photoUrl.split("?")[0] + "?t=" + Date.now();
        }

        profile.value = {
            name: updatedUser.name,
            email: updatedUser.email,
            phone: updatedUser.phone || "",
            photo_url: photoUrl,
        };

        imagePreview.value = photoUrl || null;
        isEditing.value = false;

        // Trigger event untuk refresh data user di halaman lain
        window.dispatchEvent(
            new CustomEvent("userUpdated", {
                detail: { user: updatedUser, photoUrl: photoUrl },
            })
        );

        // Reload untuk update foto di semua halaman admin
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    } catch (error) {
        const message =
            error.response?.data?.message || "Gagal memperbarui profil";
        alert(message);
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

// Tutup menu foto saat klik di luar
const handleClickOutside = (event) => {
    const target = event.target;
    const photoMenu = document.querySelector("[data-photo-menu]");
    const editButton = document.querySelector("[data-edit-button]");

    if (showPhotoMenu.value && photoMenu && editButton) {
        if (!photoMenu.contains(target) && !editButton.contains(target)) {
            showPhotoMenu.value = false;
        }
    }
};

onMounted(async () => {
    await fetchProfile();
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>


