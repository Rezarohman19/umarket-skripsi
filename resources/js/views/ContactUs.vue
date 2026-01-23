<template>
    <div class="min-h-screen bg-[#FDA1A2]/10 flex">
        <!-- SIDEBAR -->
        <aside
            :class="[
                'bg-[#8E0D3C] border-r border-[#EF3B33]/30 shadow-sm transition-all duration-300 fixed left-0 top-0 bottom-0 flex flex-col z-10',
                sidebarCollapsed ? 'w-16' : 'w-64',
            ]"
        >
            <!-- Logo & Toggle Button -->
            <div :class="[
                'p-4 border-b border-[#EF3B33]/30',
                sidebarCollapsed ? 'flex flex-col items-center gap-2' : 'flex items-center justify-between'
            ]">
                <div :class="[
                    'flex items-center justify-center',
                    sidebarCollapsed ? 'w-full' : 'flex-1'
                ]">
                    <img
                        src="/images/logo-u-marketplace.png"
                        alt="U Marketplace"
                        :class="[
                            'object-contain',
                            sidebarCollapsed ? 'h-10 w-10' : 'h-20 w-auto'
                        ]"
                    />
                </div>
                <button 
                    @click="toggleSidebar" 
                    :class="[
                        'p-2 rounded-lg hover:bg-[#EF3B33]/20 transition',
                        sidebarCollapsed ? 'w-full flex justify-center' : ''
                    ]"
                >
                    <svg
                        :class="[
                            'text-white transition-transform duration-300',
                            sidebarCollapsed ? 'w-5 h-5 rotate-180' : 'w-5 h-5'
                        ]"
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
                </button>
            </div>

            <nav :class="[
                'space-y-3',
                sidebarCollapsed ? 'px-2' : 'px-4'
            ]">
                <a
                    href="/"
                    @click="collapseSidebarOnNavigation"
                    :class="[
                        'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                        sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                    ]"
                >
                    <svg
                        :class="[
                            'text-white flex-shrink-0',
                            sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                        ]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Beranda</span>
                </a>

                <a
                    href="/orders"
                    @click="collapseSidebarOnNavigation"
                    :class="[
                        'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                        sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                    ]"
                >
                    <svg
                        :class="[
                            'text-white flex-shrink-0',
                            sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                        ]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Pesanan Saya</span>
                </a>

                <a
                    href="/open-shop"
                    @click="collapseSidebarOnNavigation"
                    :class="[
                        'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                        sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                    ]"
                >
                    <svg
                        :class="[
                            'text-white flex-shrink-0',
                            sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                        ]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Buka Toko</span>
                </a>
            </nav>

            <nav
                :class="[
                    'space-y-3 border-t border-[#EF3B33]/30 pt-4 mt-4',
                    sidebarCollapsed ? 'px-2' : 'px-4'
                ]"
            >
                <a
                    href="/terms-and-conditions"
                    @click="collapseSidebarOnNavigation"
                    :class="[
                        'flex items-center rounded-lg text-white/80 hover:bg-[#EF3B33]/20 transition',
                        sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                    ]"
                >
                    <svg
                        :class="[
                            'text-white flex-shrink-0',
                            sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                        ]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Syarat & Ketentuan</span>
                </a>

                <a
                    href="#"
                    :class="[
                        'flex items-center rounded-lg bg-[#FDA1A2]/30 text-white font-medium transition',
                        sidebarCollapsed ? 'px-2 py-3 justify-center' : 'px-4 py-3'
                    ]"
                >
                    <svg
                        :class="[
                            'text-white flex-shrink-0',
                            sidebarCollapsed ? 'w-5 h-5' : 'w-5 h-5 mr-3'
                        ]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                    </svg>
                    <span v-if="!sidebarCollapsed">Hubungi Kami</span>
                </a>
            </nav>

            <div :class="[
                'mt-auto',
                sidebarCollapsed ? 'p-2' : 'p-4'
            ]">
                <button
                    @click="logout"
                    :class="[
                        'w-full bg-[#EF3B33]/30 text-white font-medium py-3 rounded-lg transition hover:bg-[#EF3B33]/40 cursor-pointer',
                        sidebarCollapsed ? 'px-2 flex justify-center' : 'px-4'
                    ]"
                >
                    <span v-if="!sidebarCollapsed">Keluar</span>
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
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        />
                    </svg>
                </button>
            </div>
        </aside>

        <!-- CONTENT -->
        <main
            class="flex-1 px-6 py-10 transition-all duration-300"
            :class="sidebarCollapsed ? 'ml-16' : 'ml-64'"
        >
            <div class="max-w-5xl mx-auto bg-white rounded-xl p-8 shadow-lg">
                <h1
                    class="text-3xl font-bold text-center bg-clip-text text-transparent bg-gradient-to-r from-[#8E0D3C] to-[#EF3B33]"
                >
                    Hubungi Kami
                </h1>

                <p class="text-center text-gray-600 mt-2">
                    Kami siap membantu Anda kapan saja.
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                    <!-- INFO -->
                    <div class="border rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4 text-[#1D1842]">
                            Informasi Kontak
                        </h2>
                        <div class="space-y-4 text-sm">
                            <div>
                                <strong>Email</strong><br />
                                <a
                                    href="mailto:marketunila@gmail.com"
                                    class="text-[#8E0D3C]"
                                >
                                    marketunila@gmail.com
                                </a>
                            </div>

                            <div>
                                <strong>Telepon</strong><br />
                                <a
                                    href="tel:+6288286749573"
                                    class="text-[#8E0D3C]"
                                >
                                    +62 882 8674 9573
                                </a>
                            </div>

                            <div>
                                <strong>Alamat</strong><br />
                                Gg. By Pass Raya 1, Sepang Jaya, Kota Bandar
                                Lampung
                            </div>

                            <div>
                                <strong>Jam Operasional</strong>
                                <br />
                                Senin–Jumat: 09.00–16.00 WIB <br />
                                Sabtu: 10.00–14.00 WIB <br />
                                Minggu: Tutup
                            </div>
                        </div>
                    </div>

                    <!-- FORM -->
                    <div class="border rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-4">Kirim Pesan</h2>

                        <form @submit.prevent="submitForm" class="space-y-4">
                            <input
                                v-model="form.name"
                                placeholder="Nama"
                                class="input"
                            />
                            <input
                                v-model="form.email"
                                placeholder="Email"
                                class="input"
                            />
                            <input
                                v-model="form.phone"
                                placeholder="Telepon"
                                class="input"
                            />
                            <input
                                v-model="form.subject"
                                placeholder="Subjek"
                                class="input"
                            />
                            <textarea
                                v-model="form.message"
                                placeholder="Pesan"
                                class="input h-32"
                            ></textarea>

                            <button
                                class="w-full bg-gradient-to-r from-[#8E0D3C] to-[#EF3B33] py-2 rounded text-white"
                            >
                                Kirim
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- Confirm Modal untuk Logout -->
        <ConfirmModal
            :visible="confirmModal.visible"
            :title="confirmModal.title"
            :message="confirmModal.message"
            @confirm="handleConfirmLogout"
            @cancel="closeConfirmModal"
        />
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import ConfirmModal from "../components/ConfirmModal.vue";

const sidebarCollapsed = ref(false);
const confirmModal = ref({ visible: false, title: "", message: "" });

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const collapseSidebarOnNavigation = () => {
    // Auto-collapse sidebar di mobile ketika menu diklik
    // Cek jika lebar layar <= 768px (mobile)
    if (window.innerWidth <= 768 && !sidebarCollapsed.value) {
        sidebarCollapsed.value = true;
    }
};

const form = ref({
    name: "",
    email: "",
    phone: "",
    subject: "",
    message: "",
});

const submitForm = async () => {
    await axios.post("/contact-us", form.value);
    alert("Pesan terkirim");
};

const logout = () => {
    // Tampilkan confirm modal
    confirmModal.value = {
        visible: true,
        title: "Konfirmasi Keluar",
        message: "Apakah Anda yakin ingin keluar?"
    };
};

const closeConfirmModal = () => {
    confirmModal.value.visible = false;
};

const handleConfirmLogout = async () => {
    closeConfirmModal();
    
    try {
        await axios.post("/logout");
        window.location.href = "/";
    } catch (error) {
        console.error("Error logging out:", error);
        // Tetap redirect meskipun ada error
        window.location.href = "/";
    }
};
</script>

<style scoped>
.menu-item {
    display: block;
    padding: 12px;
    border-radius: 8px;
}
.input {
    width: 100%;
    border: 1px solid #ddd;
    padding: 8px;
    border-radius: 6px;
}
</style>
