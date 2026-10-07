<template>
    <div class="fixed inset-0 bg-[#1D1842]/70 dark:bg-black/80 backdrop-blur-sm flex items-center justify-center z-[100] p-3 sm:p-4">
        <div class="bg-white dark:bg-[#1D1842] rounded-2xl shadow-2xl max-w-2xl w-full max-h-[92vh] flex flex-col border border-[#FDA1A2]/30 dark:border-[#8E0D3C]/30 overflow-hidden animate-fade-in">
            <!-- Header -->
            <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-gradient-to-r from-red-50/50 to-transparent dark:from-red-950/20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#EF3B33]/10 dark:bg-[#EF3B33]/20 flex items-center justify-center text-[#EF3B33] text-xl">
                        📍
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-[#1D1842] dark:text-[#FDA1A2]">
                            Tentukan Titik Tujuan di Peta
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Pilih lokasi tepat agar kurir dapat mengantar pesanan langsung ke tujuan
                        </p>
                    </div>
                </div>
                <button
                    @click="$emit('close')"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-4">
                <!-- Search & GPS Toolbar -->
                <div class="space-y-2">
                    <div class="relative">
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input
                                    v-model="searchQuery"
                                    @keydown.enter.prevent="searchAddress"
                                    type="text"
                                    placeholder="Cari nama jalan, kampus, atau tempat tujuan..."
                                    class="w-full pl-9 pr-8 py-2.5 text-sm bg-gray-50 dark:bg-[#252054] border border-gray-200 dark:border-gray-700 rounded-xl text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-[#EF3B33] focus:ring-1 focus:ring-[#EF3B33]"
                                />
                                <button
                                    v-if="searchQuery"
                                    @click="searchQuery = ''; searchResults = []"
                                    class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-gray-400 hover:text-gray-600"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <button
                                @click="searchAddress"
                                :disabled="isSearching"
                                class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm font-semibold rounded-xl transition-colors flex items-center gap-1.5 disabled:opacity-50"
                            >
                                <svg v-if="isSearching" class="animate-spin w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span>{{ isSearching ? 'Mencari...' : 'Cari' }}</span>
                            </button>
                        </div>

                        <!-- Search Suggestions Dropdown -->
                        <div
                            v-if="searchResults.length > 0"
                            class="absolute z-20 top-full left-0 right-0 mt-1 bg-white dark:bg-[#252054] rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 max-h-48 overflow-y-auto"
                        >
                            <button
                                v-for="(item, idx) in searchResults"
                                :key="idx"
                                @click="selectSearchResult(item)"
                                class="w-full text-left px-3.5 py-2.5 text-xs text-gray-700 dark:text-gray-200 hover:bg-red-50 dark:hover:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700 last:border-0 flex items-start gap-2 transition-colors"
                            >
                                <span class="text-[#EF3B33] mt-0.5 flex-shrink-0">📍</span>
                                <span class="line-clamp-2 leading-relaxed">{{ item.display_name }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Quick GPS Locate Button -->
                    <div class="flex items-center justify-between">
                        <button
                            @click="detectCurrentLocation"
                            :disabled="isLocating"
                            type="button"
                            class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#EF3B33] hover:text-[#d32f2f] dark:text-[#FDA1A2] bg-red-50 dark:bg-red-950/40 hover:bg-red-100 dark:hover:bg-red-900/50 px-3 py-1.5 rounded-lg border border-red-200/50 dark:border-red-900/50 transition-colors"
                        >
                            <svg v-if="!isLocating" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg v-else class="animate-spin w-4 h-4 text-[#EF3B33]" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <span>{{ isLocating ? 'Mendeteksi GPS...' : '🎯 Gunakan Lokasi Saya Saat Ini' }}</span>
                        </button>

                        <span class="text-[11px] text-gray-500 dark:text-gray-400">
                            💡 Klik pada peta atau geser pin untuk atur titik
                        </span>
                    </div>
                </div>

                <!-- Leaflet Map Container -->
                <div class="relative rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-inner">
                    <div ref="mapContainer" class="h-64 sm:h-72 w-full z-0"></div>

                    <!-- Geocoding Loading Overlay -->
                    <div
                        v-if="isGeocoding"
                        class="absolute top-2 left-2 right-2 bg-white/95 dark:bg-[#1D1842]/95 backdrop-blur-sm rounded-lg px-3 py-1.5 shadow-md border border-gray-200 dark:border-gray-700 text-xs text-gray-700 dark:text-gray-300 flex items-center gap-2 z-10"
                    >
                        <svg class="animate-spin w-3.5 h-3.5 text-[#EF3B33]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span>Mendapatkan nama alamat dari titik peta...</span>
                    </div>

                    <!-- Coordinates badge -->
                    <div
                        v-if="currentLat && currentLng"
                        class="absolute bottom-2 right-2 bg-black/75 backdrop-blur-sm text-white text-[10px] px-2.5 py-1 rounded-md z-10 font-mono shadow"
                    >
                        📍 {{ currentLat.toFixed(5) }}, {{ currentLng.toFixed(5) }}
                    </div>
                </div>

                <!-- Selected Address Details Form -->
                <div class="space-y-3 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            Alamat / Patokan Tujuan:
                        </label>
                        <textarea
                            v-model="addressText"
                            rows="2"
                            placeholder="Contoh: Jl. Teuku Umar No. 15, samping minimarket, pagar hitam..."
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-[#252054] border border-gray-200 dark:border-gray-700 rounded-xl text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-[#EF3B33] focus:ring-1 focus:ring-[#EF3B33]"
                        ></textarea>
                    </div>

                    <div
                        v-if="!currentLat || !currentLng"
                        class="text-xs text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/30 p-2.5 rounded-lg border border-amber-200/50 flex items-center gap-2"
                    >
                        <span>⚠️</span>
                        <span>Silakan tentukan titik tujuan pada peta di atas agar kurir dapat melacak rute dengan navigasi biru.</span>
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="p-4 sm:p-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-black/20 flex gap-3">
                <button
                    @click="$emit('close')"
                    type="button"
                    class="flex-1 py-2.5 px-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-semibold transition-colors"
                >
                    Batal
                </button>
                <button
                    @click="confirmLocation"
                    :disabled="!currentLat || !currentLng || !addressText"
                    type="button"
                    class="flex-1 py-2.5 px-4 bg-[#EF3B33] hover:bg-[#d32f2f] text-white rounded-xl text-sm font-semibold transition-all shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                    <span>Gunakan Titik Ini</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Fix Leaflet marker icons
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

export default {
    name: 'AddressMapPicker',
    props: {
        initialAddress: {
            type: String,
            default: '',
        },
        initialLat: {
            type: [Number, String],
            default: null,
        },
        initialLng: {
            type: [Number, String],
            default: null,
        },
    },
    emits: ['close', 'confirm'],
    data() {
        return {
            map: null,
            marker: null,
            searchQuery: '',
            searchResults: [],
            isSearching: false,
            isLocating: false,
            isGeocoding: false,
            currentLat: this.initialLat ? parseFloat(this.initialLat) : null,
            currentLng: this.initialLng ? parseFloat(this.initialLng) : null,
            addressText: this.initialAddress || '',
            reverseGeocodeTimeout: null,
        };
    },
    mounted() {
        this.$nextTick(() => {
            this.initMap();
        });
    },
    beforeUnmount() {
        if (this.reverseGeocodeTimeout) {
            clearTimeout(this.reverseGeocodeTimeout);
        }
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    },
    methods: {
        initMap() {
            // Default center: Bandar Lampung atau koordinat yang sudah ada
            const defaultLat = this.currentLat || -5.3971;
            const defaultLng = this.currentLng || 105.2668;
            const initialZoom = this.currentLat ? 16 : 14;

            this.map = L.map(this.$refs.mapContainer).setView([defaultLat, defaultLng], initialZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(this.map);

            // Custom destination pin
            const destIcon = L.divIcon({
                html: `<div style="
                    background: #EF3B33;
                    border: 3px solid white;
                    border-radius: 50% 50% 50% 0;
                    transform: rotate(-45deg);
                    width: 32px;
                    height: 32px;
                    box-shadow: 0 4px 14px rgba(239, 59, 51, 0.4);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                ">
                    <span style="transform: rotate(45deg); font-size: 14px;">🏠</span>
                </div>`,
                className: 'dest-picker-marker',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
            });

            // If coordinates exist, create marker immediately
            if (this.currentLat && this.currentLng) {
                this.placeMarker([this.currentLat, this.currentLng], destIcon);
            }

            // Click on map to place or move marker
            this.map.on('click', (e) => {
                this.currentLat = e.latlng.lat;
                this.currentLng = e.latlng.lng;
                this.placeMarker([e.latlng.lat, e.latlng.lng], destIcon);
                this.debouncedReverseGeocode(e.latlng.lat, e.latlng.lng);
            });

            // Invalidate size after modal rendering
            setTimeout(() => {
                if (this.map) this.map.invalidateSize();
            }, 250);
        },

        placeMarker(latLng, customIcon) {
            if (this.marker) {
                this.marker.setLatLng(latLng);
            } else {
                const icon = customIcon || L.divIcon({
                    html: `<div style="
                        background: #EF3B33;
                        border: 3px solid white;
                        border-radius: 50% 50% 50% 0;
                        transform: rotate(-45deg);
                        width: 32px;
                        height: 32px;
                        box-shadow: 0 4px 14px rgba(239, 59, 51, 0.4);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                        <span style="transform: rotate(45deg); font-size: 14px;">🏠</span>
                    </div>`,
                    className: 'dest-picker-marker',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                });

                this.marker = L.marker(latLng, {
                    draggable: true,
                    icon: icon,
                }).addTo(this.map);

                this.marker.on('dragend', (event) => {
                    const position = event.target.getLatLng();
                    this.currentLat = position.lat;
                    this.currentLng = position.lng;
                    this.debouncedReverseGeocode(position.lat, position.lng);
                });
            }
        },

        async searchAddress() {
            if (!this.searchQuery.trim()) return;
            this.isSearching = true;
            this.searchResults = [];

            try {
                const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(
                    this.searchQuery
                )}&countrycodes=id&limit=5`;
                const response = await fetch(url, {
                    headers: { 'Accept-Language': 'id,en' }
                });
                const data = await response.json();
                this.searchResults = data;
                if (data.length === 0) {
                    alert('Lokasi tidak ditemukan. Coba gunakan kata kunci jalan atau nama tempat lainnya.');
                }
            } catch (err) {
                console.error('Search error:', err);
            } finally {
                this.isSearching = false;
            }
        },

        selectSearchResult(item) {
            const lat = parseFloat(item.lat);
            const lng = parseFloat(item.lon);
            this.currentLat = lat;
            this.currentLng = lng;
            this.addressText = item.display_name;
            this.searchResults = [];
            this.searchQuery = item.display_name;

            this.placeMarker([lat, lng]);
            this.map.setView([lat, lng], 16, { animate: true });
        },

        detectCurrentLocation() {
            if (!navigator.geolocation) {
                alert('Browser Anda tidak mendukung geolokasi GPS.');
                return;
            }

            this.isLocating = true;
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    this.currentLat = lat;
                    this.currentLng = lng;

                    this.placeMarker([lat, lng]);
                    this.map.setView([lat, lng], 17, { animate: true });
                    this.debouncedReverseGeocode(lat, lng);
                    this.isLocating = false;
                },
                (err) => {
                    console.error('GPS error:', err);
                    alert('Gagal mengakses GPS. Pastikan izin lokasi diaktifkan pada browser/perangkat Anda.');
                    this.isLocating = false;
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        },

        debouncedReverseGeocode(lat, lng) {
            if (this.reverseGeocodeTimeout) {
                clearTimeout(this.reverseGeocodeTimeout);
            }
            this.reverseGeocodeTimeout = setTimeout(() => {
                this.reverseGeocode(lat, lng);
            }, 400);
        },

        async reverseGeocode(lat, lng) {
            this.isGeocoding = true;
            try {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
                const response = await fetch(url, {
                    headers: { 'Accept-Language': 'id,en' }
                });
                const data = await response.json();
                if (data && data.display_name) {
                    this.addressText = data.display_name;
                }
            } catch (err) {
                console.error('Reverse geocode error:', err);
            } finally {
                this.isGeocoding = false;
            }
        },

        confirmLocation() {
            if (!this.currentLat || !this.currentLng) {
                alert('Silakan tentukan titik tujuan pada peta.');
                return;
            }
            this.$emit('confirm', {
                address: this.addressText,
                lat: this.currentLat,
                lng: this.currentLng,
                destination_lat: this.currentLat,
                destination_lng: this.currentLng,
            });
        },
    },
};
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.96) translateY(8px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}
</style>
