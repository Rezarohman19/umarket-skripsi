<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 dark:bg-[#1D1842] py-6 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center gap-2 text-[#1D1842] dark:text-[#FDA1A2] cursor-pointer" @click="goBack">
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
                class="bg-white dark:bg-[#1D1842] rounded-2xl border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 shadow-sm p-6"
            >
                <div class="flex flex-col items-center space-y-3 relative">
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

                    <button
                        v-if="isEditing"
                        data-edit-button
                        class="text-sm text-[#EF3B33] dark:text-[#EF3B33]"
                        @click.stop="showPhotoMenu = !showPhotoMenu"
                    >
                        Edit
                    </button>

                    <div
                        v-if="showPhotoMenu && isEditing"
                        data-photo-menu
                        class="absolute top-full mt-2 bg-white dark:bg-[#1D1842] border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 rounded-lg shadow-lg z-10 min-w-[160px] overflow-hidden"
                    >
                        <label class="block cursor-pointer">
                            <input
                                type="file"
                                accept="image/*"
                                class="hidden"
                                @change="onPhotoChange"
                            />
                            <div class="px-4 py-2.5 text-sm text-[#1D1842] dark:text-[#FDA1A2]">
                                Ganti Foto
                            </div>
                        </label>
                        <button
                            v-if="profile.photo_url || imagePreview"
                            class="w-full px-4 py-2.5 text-sm text-[#1D1842] dark:text-[#FDA1A2] text-left border-t border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30"
                            @click="removePhoto"
                        >
                            Hapus Foto
                        </button>
                    </div>
                </div>

                <div
                    class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 text-sm"
                >
                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-[#1D1842] dark:text-[#FDA1A2] w-32"
                            >Nama</span
                        >
                        <span class="text-[#1D1842] dark:text-[#FDA1A2]">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.name"
                            type="text"
                            class="flex-1 px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                        />
                        <span v-else class="text-[#1D1842] dark:text-[#FDA1A2]">{{
                            profile.name
                        }}</span>
                    </div>

                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-[#1D1842] dark:text-[#FDA1A2] w-32"
                            >Email</span
                        >
                        <span class="text-[#1D1842] dark:text-[#FDA1A2]">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.email"
                            type="email"
                            class="flex-1 px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                        />
                        <span v-else class="text-[#1D1842] dark:text-[#FDA1A2]">{{
                            profile.email
                        }}</span>
                    </div>

                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-[#1D1842] dark:text-[#FDA1A2] w-32"
                            >Telepon</span
                        >
                        <span class="text-[#1D1842] dark:text-[#FDA1A2]">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.phone"
                            type="text"
                            class="flex-1 px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                        />
                        <span v-else class="text-[#1D1842] dark:text-[#FDA1A2]">{{
                            profile.phone
                        }}</span>
                    </div>

                    <div class="flex items-start sm:items-center gap-2">
                        <span class="text-[#1D1842] dark:text-[#FDA1A2] w-32"
                            >Password</span
                        >
                        <span class="text-[#1D1842] dark:text-[#FDA1A2]">:</span>
                        <input
                            v-if="isEditing"
                            v-model="form.password"
                            type="password"
                            placeholder="Isi untuk ubah password"
                            class="flex-1 px-3 py-2 border border-[#FDA1A2]/40 dark:border-[#8E0D3C]/40 rounded-lg bg-[#FDA1A2]/10 dark:bg-[#1D1842]/50 text-[#1D1842] dark:text-white focus:outline-none"
                        />
                        <span v-else class="text-[#1D1842] dark:text-[#FDA1A2]"
                            >********</span
                        >
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button
                        v-if="isEditing"
                        class="px-5 py-2 bg-[#FDA1A2]/20 dark:bg-[#8E0D3C]/20 text-[#1D1842] dark:text-[#FDA1A2] rounded-lg"
                        @click="cancelEdit"
                    >
                        Batal
                    </button>
                    <button
                        v-if="isEditing"
                        class="px-5 py-2 bg-[#EF3B33] text-white rounded-lg shadow"
                        @click="saveProfile"
                    >
                        Simpan
                    </button>
                    <button
                        v-else
                        class="px-5 py-2 bg-[#EF3B33] text-white rounded-lg shadow"
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

        window.dispatchEvent(
            new CustomEvent("userUpdated", {
                detail: { user: updatedUser, photoUrl: photoUrl },
            })
        );

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


