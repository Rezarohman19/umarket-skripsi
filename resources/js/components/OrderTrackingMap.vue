<template>
    <div class="tracking-map-container">
        <!-- Header Info -->
        <div class="tracking-header">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-cyan-500 text-white flex items-center justify-center text-lg shadow-sm">
                        🛵
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold text-[#1D1842] dark:text-[#FDA1A2] leading-tight">
                            Lacak Pengiriman Pesanan
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Order: <span class="font-mono font-semibold text-gray-700 dark:text-gray-300">{{ orderId }}</span>
                            <span v-if="sellerStoreName" class="ml-1 text-gray-400">• {{ sellerStoreName }}</span>
                        </p>
                    </div>
                </div>
                <span :class="statusBadgeClass">
                    {{ statusLabel }}
                </span>
            </div>

            <!-- Step Progress Tracker U-Market -->
            <div class="my-3 pt-2.5 pb-2 px-2 border-t border-b border-gray-100 dark:border-gray-800">
                <div class="relative flex items-center justify-between">
                    <!-- Progress Bar Track Line -->
                    <div class="absolute left-6 right-6 top-3.5 h-1 bg-gray-200 dark:bg-gray-700 -z-0">
                        <div
                            class="h-full bg-green-500 transition-all duration-500 rounded-full"
                            :style="{
                                width: currentStep === 4 ? '100%' : (currentStep === 3 ? '66%' : (currentStep === 2 ? '33%' : '0%'))
                            }"
                        ></div>
                    </div>

                    <!-- Step 1: Dibuat -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div
                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm bg-green-500 text-white ring-2 ring-green-100 dark:ring-green-950"
                        >
                            ✓
                        </div>
                        <span class="text-[10px] mt-1 font-bold text-green-600 dark:text-green-400">
                            Dibuat
                        </span>
                    </div>

                    <!-- Step 2: Disiapkan -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div
                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm"
                            :class="stepCompleted(2) ? 'bg-green-500 text-white ring-2 ring-green-100 dark:ring-green-950' : (stepActive(2) ? 'bg-orange-500 text-white ring-4 ring-orange-100 dark:ring-orange-950/60 animate-pulse' : 'bg-gray-200 dark:bg-gray-700 text-gray-500')"
                        >
                            <span v-if="stepCompleted(2)">✓</span>
                            <span v-else-if="stepActive(2)">🍳</span>
                            <span v-else>2</span>
                        </div>
                        <span
                            class="text-[10px] mt-1 font-semibold"
                            :class="stepCompleted(2) ? 'text-green-600 dark:text-green-400 font-bold' : (stepActive(2) ? 'text-orange-600 dark:text-orange-400 font-bold' : 'text-gray-500')"
                        >
                            Disiapkan
                        </span>
                    </div>

                    <!-- Step 3: Diantar -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div
                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm"
                            :class="stepCompleted(3) ? 'bg-green-500 text-white ring-2 ring-green-100 dark:ring-green-950' : (stepActive(3) ? 'bg-blue-600 text-white ring-4 ring-blue-100 dark:ring-blue-950/60 animate-pulse' : 'bg-gray-200 dark:bg-gray-700 text-gray-500')"
                        >
                            <span v-if="stepCompleted(3)">✓</span>
                            <span v-else-if="stepActive(3)">🛵</span>
                            <span v-else>3</span>
                        </div>
                        <span
                            class="text-[10px] mt-1 font-semibold"
                            :class="stepCompleted(3) ? 'text-green-600 dark:text-green-400 font-bold' : (stepActive(3) ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-500')"
                        >
                            Diantar
                        </span>
                    </div>

                    <!-- Step 4: Sampai -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div
                            class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-sm"
                            :class="stepCompleted(4) ? 'bg-green-500 text-white ring-4 ring-green-100 dark:ring-green-950/60' : 'bg-gray-200 dark:bg-gray-700 text-gray-500'"
                        >
                            <span v-if="stepCompleted(4)">✓</span>
                            <span v-else>🏠</span>
                        </div>
                        <span
                            class="text-[10px] mt-1 font-semibold"
                            :class="stepCompleted(4) ? 'text-green-600 dark:text-green-400 font-bold' : 'text-gray-500'"
                        >
                            Sampai
                        </span>
                    </div>
                </div>
            </div>

            <!-- U-Market ETA & Live Distance Banner -->
            <div
                v-if="tracking && destinationLat && destinationLng"
                class="mt-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 rounded-xl p-3 text-white shadow-md flex items-center justify-between"
            >
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-xl animate-bounce-subtle flex-shrink-0">
                        🛵
                    </div>
                    <div>
                        <p class="text-xs text-blue-100 font-medium">
                            {{ trackingStatusLabel }}
                        </p>
                        <p class="text-sm font-extrabold tracking-wide">
                            {{ transactionStatus === 'delivered' ? 'Pesanan Telah Tiba di Lokasi Anda' : (routeDuration ? `Estimasi Tiba: ~${routeDuration}` : 'Kurir Sedang Menuju Tujuan') }}
                        </p>
                    </div>
                </div>
                <div v-if="routeDistance" class="text-right pl-3 border-l border-white/20 flex-shrink-0">
                    <p class="text-[11px] text-blue-200">Jarak Rute</p>
                    <p class="text-sm font-extrabold whitespace-nowrap">{{ routeDistance }}</p>
                </div>
            </div>
        </div>

        <!-- Map Container with Route Overlay -->
        <div class="relative">
            <div ref="mapContainer" class="map-wrapper"></div>

            <!-- Route legend / Live Indicator overlay on top of map -->
            <div class="absolute top-3 left-3 z-[400] flex flex-col gap-1.5 pointer-events-none">
                <div v-if="isPolling" class="bg-white/95 dark:bg-[#1D1842]/95 backdrop-blur-sm px-2.5 py-1 rounded-full shadow-sm text-[11px] font-semibold text-green-600 dark:text-green-400 flex items-center gap-1.5 pointer-events-auto border border-green-200/50">
                    <span class="pulse-dot"></span>
                    <span>Live GPS Real-time</span>
                </div>
                <div v-if="destinationLat && destinationLng" class="bg-white/95 dark:bg-[#1D1842]/95 backdrop-blur-sm px-2.5 py-1 rounded-full shadow-sm text-[10px] text-gray-700 dark:text-gray-300 flex items-center gap-2 pointer-events-auto border border-blue-200/60 font-medium">
                    <span class="w-3 h-1.5 bg-[#0284C7] rounded-full inline-block shadow-sm"></span>
                    <span>Rute Pengiriman U-Market</span>
                </div>
            </div>

            <!-- Map Floating Action Buttons (Recenter & Google Maps) -->
            <div class="absolute bottom-3 right-3 z-[400] flex items-center gap-2">
                <button
                    v-if="destinationLat && destinationLng"
                    @click="openGoogleMaps"
                    type="button"
                    title="Buka rute navigasi di Google Maps"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-xl shadow-lg transition-all flex items-center gap-1.5 text-xs font-semibold active:scale-95 cursor-pointer"
                >
                    <span>🗺️ Google Maps</span>
                </button>
                <button
                    v-if="tracking || (destinationLat && destinationLng)"
                    @click="fitMapToRoute"
                    title="Pusatkan Peta ke Rute"
                    class="bg-white dark:bg-[#1D1842] text-gray-700 dark:text-gray-200 p-2 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-1 text-xs font-medium cursor-pointer"
                >
                    <svg class="w-4 h-4 text-[#EF3B33]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <span class="hidden sm:inline">Pusatkan</span>
                </button>
            </div>
        </div>

        <!-- Destination Alert / Add Destination if missing -->
        <div v-if="!destinationLat || !destinationLng" class="p-3 sm:p-4 bg-amber-50 dark:bg-amber-950/30 border-t border-b border-amber-200/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="text-xl">📍</span>
                <div>
                    <p class="text-xs font-bold text-amber-800 dark:text-amber-300">
                        Titik Peta Tujuan Belum Diatur
                    </p>
                    <p class="text-[11px] text-amber-700/80 dark:text-amber-400">
                        Atur titik tujuan kamu sekarang agar garis rute biru navigasi kurir muncul.
                    </p>
                </div>
            </div>
            <button
                @click="showMapPicker = true"
                class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-semibold transition-colors shadow-sm whitespace-nowrap cursor-pointer"
            >
                🎯 Pasang Titik Tujuan
            </button>
        </div>

        <!-- Tracking Info & Destination Details -->
        <div class="tracking-info space-y-2.5">
            <!-- Buyer Shipping Address card -->
            <div class="p-3 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-700/50 flex items-start justify-between gap-3">
                <div class="space-y-0.5 min-w-0">
                    <p class="text-xs font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                        <span>🏠</span>
                        <span>Alamat Penerima: {{ shippingName || 'Saya' }}</span>
                        <span v-if="shippingPhone" class="font-normal text-gray-500">({{ shippingPhone }})</span>
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ shippingAddress || 'Alamat tujuan pengiriman belum tercatat' }}
                    </p>
                </div>
                <button
                    @click="showMapPicker = true"
                    class="text-[11px] text-blue-600 dark:text-blue-400 hover:underline flex-shrink-0 font-medium"
                >
                    Ubah Titik
                </button>
            </div>

            <!-- Seller / Store Info & WhatsApp contact button -->
            <div v-if="sellerStoreName || sellerPhone" class="flex items-center justify-between p-2.5 bg-blue-50/50 dark:bg-blue-950/20 rounded-lg text-xs border border-blue-100/60 dark:border-blue-900/30">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="text-base">🏪</span>
                    <div class="truncate">
                        <p class="font-bold text-gray-800 dark:text-gray-200 truncate">{{ sellerStoreName || 'Toko Penjual' }}</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Penjual Resmi U-Market</p>
                    </div>
                </div>
                <a
                    v-if="sellerPhone"
                    :href="`https://wa.me/${formatWaNumber(sellerPhone)}`"
                    target="_blank"
                    class="px-2.5 py-1 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-semibold flex items-center gap-1 shadow-sm transition-all"
                >
                    <span>💬 Hubungi Toko</span>
                </a>
            </div>

            <div v-if="tracking" class="info-row">
                <span class="info-label text-xs">Status Kurir:</span>
                <span class="info-value text-xs font-semibold text-blue-600 dark:text-blue-400">
                    {{ trackingStatusLabel }}
                </span>
            </div>

            <div v-if="tracking && tracking.note" class="info-row">
                <span class="info-label text-xs">Catatan Kurir:</span>
                <span class="info-value text-xs italic text-gray-700 dark:text-gray-300">
                    "{{ tracking.note }}"
                </span>
            </div>

            <div v-if="tracking" class="info-row">
                <span class="info-label text-xs">Pembaruan GPS:</span>
                <span class="info-value text-xs text-gray-500 font-mono">
                    {{ lastUpdated }}
                </span>
            </div>

            <div v-if="!tracking" class="text-center py-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    ⏳ Penjual sedang menyiapkan pesanan. Peta rute navigasi akan aktif begitu kurir mulai berjalan!
                </p>
            </div>
        </div>

        <!-- Map Picker Modal (if setting destination) -->
        <AddressMapPicker
            v-if="showMapPicker"
            :initial-address="shippingAddress"
            :initial-lat="destinationLat"
            :initial-lng="destinationLng"
            @confirm="onDestinationUpdated"
            @close="showMapPicker = false"
        />
    </div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import axios from 'axios';
import AddressMapPicker from './AddressMapPicker.vue';

// Fix Leaflet default marker icons
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

export default {
    name: 'OrderTrackingMap',
    components: {
        AddressMapPicker,
    },
    props: {
        transactionId: {
            type: [Number, String],
            required: true,
        },
        orderId: {
            type: String,
            default: '',
        },
        autoRefresh: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            map: null,
            sellerMarker: null,
            destMarker: null,
            routeBasePolyline: null,
            routeFrontPolyline: null,
            routeFlowPolyline: null,
            tracking: null,
            transactionStatus: null,
            shippingAddress: '',
            shippingName: '',
            shippingPhone: '',
            sellerStoreName: '',
            sellerPhone: '',
            destinationLat: null,
            destinationLng: null,
            routeDistance: null,
            routeDuration: null,
            isPolling: false,
            pollInterval: null,
            showMapPicker: false,
            hasInitialFit: false,
        };
    },
    computed: {
        currentStep() {
            const st = (this.transactionStatus || '').toLowerCase();
            const trackSt = (this.tracking?.tracking_status || '').toLowerCase();

            if (st === 'delivered' || st === 'completed' || st === 'selesai' || trackSt === 'delivered') return 4;
            if (st === 'shipping' || trackSt === 'on_the_way' || trackSt === 'nearby' || trackSt === 'picked_up' || this.tracking) return 3;
            if (st === 'processing' || st === 'paid' || st === 'dikemas') return 2;
            return 1;
        },
        statusLabel() {
            const labels = {
                paid: 'Menunggu Pengiriman',
                processing: 'Sedang Dikemas',
                shipping: 'Dalam Pengiriman',
                delivered: 'Sudah Sampai',
                completed: 'Sudah Sampai',
                selesai: 'Sudah Sampai',
            };
            return labels[this.transactionStatus] || this.transactionStatus || 'Memuat...';
        },
        statusBadgeClass() {
            const base = 'px-3 py-1 rounded-full text-xs font-semibold';
            const colors = {
                paid: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                processing: 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                shipping: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                delivered: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                completed: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                selesai: 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            };
            return `${base} ${colors[this.transactionStatus] || 'bg-gray-100 text-gray-700'}`;
        },
        trackingStatusLabel() {
            if (!this.tracking) return '';
            const labels = {
                picked_up: '📦 Pesanan Telah Diambil',
                on_the_way: '🛵 Sedang Dalam Perjalanan Ke Lokasimu',
                nearby: '📍 Kurir Sudah Dekat!',
                delivered: '✅ Pesanan Telah Sampai di Tujuan',
            };
            return labels[this.tracking.tracking_status] || this.tracking.tracking_status;
        },
        lastUpdated() {
            if (!this.tracking?.updated_at) return '-';
            const date = new Date(this.tracking.updated_at);
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
        },
    },
    mounted() {
        this.$nextTick(() => {
            this.initMap();
            this.fetchTracking();

            if (this.autoRefresh) {
                this.startPolling();
            }
        });
    },
    beforeUnmount() {
        this.stopPolling();
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    },
    methods: {
        stepCompleted(step) {
            // Ketika pesanan sudah sampai (step 4), semua step 1, 2, 3, 4 otomatis terceklis!
            if (this.currentStep === 4) return true;
            // Ketika step saat ini sudah melampaui step tersebut, step tersebut selesai dan terceklis
            return this.currentStep > step;
        },
        stepActive(step) {
            return this.currentStep === step;
        },
        openGoogleMaps() {
            if (!this.destinationLat || !this.destinationLng) return;
            const dest = `${this.destinationLat},${this.destinationLng}`;
            const origin = (this.tracking?.latitude && this.tracking?.longitude)
                ? `${this.tracking.latitude},${this.tracking.longitude}`
                : '';
            const url = origin
                ? `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${dest}&travelmode=driving`
                : `https://www.google.com/maps/search/?api=1&query=${dest}`;
            window.open(url, '_blank');
        },
        formatWaNumber(phone) {
            let clean = (phone || '').replace(/[^0-9]/g, '');
            if (clean.startsWith('0')) {
                clean = '62' + clean.slice(1);
            }
            return clean;
        },
        initMap() {
            // Default center
            this.map = L.map(this.$refs.mapContainer).setView([-5.3971, 105.2668], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(this.map);

            setTimeout(() => {
                if (this.map) this.map.invalidateSize();
            }, 300);
        },

        async fetchTracking() {
            try {
                const response = await axios.get(`/api/tracking/${this.transactionId}`);
                const data = response.data;

                this.transactionStatus = data.transaction_status;
                this.shippingName = data.shipping_name || this.shippingName || '';
                this.shippingPhone = data.shipping_phone || this.shippingPhone || '';
                this.shippingAddress = data.shipping_address || this.shippingAddress || 'Alamat tujuan';
                this.sellerStoreName = data.store_name || this.sellerStoreName || 'Toko Penjual';
                this.sellerPhone = data.store_phone || this.sellerPhone || '';

                if (data.destination_lat && data.destination_lng) {
                    this.destinationLat = parseFloat(data.destination_lat);
                    this.destinationLng = parseFloat(data.destination_lng);
                    this.updateDestinationMarker(this.destinationLat, this.destinationLng);
                }

                if (data.tracking) {
                    this.tracking = data.tracking;
                    const sellerLat = parseFloat(data.tracking.latitude);
                    const sellerLng = parseFloat(data.tracking.longitude);
                    this.updateSellerMarker(sellerLat, sellerLng);

                    // Fetch GoFood style route if both coordinates exist
                    if (this.destinationLat && this.destinationLng) {
                        this.fetchRoute(sellerLat, sellerLng, this.destinationLat, this.destinationLng);
                    }
                } else if (this.destinationLat && this.destinationLng && !this.hasInitialFit) {
                    this.map.setView([this.destinationLat, this.destinationLng], 15);
                    this.hasInitialFit = true;
                }
            } catch (error) {
                console.error('Error fetching tracking:', error);
            }
        },

        updateSellerMarker(lat, lng) {
            const position = [lat, lng];

            // GoFood & ShopeeFood courier motorcycle marker with radar pulse ring
            const courierIcon = L.divIcon({
                html: `
                    <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                        <div style="
                            position: absolute;
                            width: 46px;
                            height: 46px;
                            border-radius: 50%;
                            background: rgba(2, 132, 199, 0.35);
                            animation: pulse-ring 1.8s infinite;
                        "></div>
                        <div style="
                            background: linear-gradient(135deg, #0284C7, #2563EB);
                            color: white;
                            border: 3px solid white;
                            border-radius: 50%;
                            width: 36px;
                            height: 36px;
                            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.55);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 18px;
                            z-index: 2;
                        ">
                            🛵
                        </div>
                    </div>
                `,
                className: 'courier-custom-marker',
                iconSize: [46, 46],
                iconAnchor: [23, 23],
            });

            if (this.sellerMarker) {
                this.sellerMarker.setLatLng(position);
            } else {
                this.sellerMarker = L.marker(position, { icon: courierIcon })
                    .addTo(this.map)
                    .bindPopup(`<b>🛵 Kurir Sedang Mengantar</b><br>${this.sellerStoreName ? 'Dari ' + this.sellerStoreName : 'Menuju ke alamat tujuan kamu'}`);
            }
        },

        updateDestinationMarker(lat, lng) {
            const position = [lat, lng];

            // Buyer destination home pin
            const destIcon = L.divIcon({
                html: `
                    <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
                        <div style="
                            background: #EF3B33;
                            color: white;
                            font-size: 10px;
                            font-weight: 700;
                            padding: 2px 6px;
                            border-radius: 8px;
                            white-space: nowrap;
                            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
                            margin-bottom: 2px;
                        ">
                            🏠 Tujuan Pengiriman
                        </div>
                        <div style="
                            background: #EF3B33;
                            border: 3px solid white;
                            border-radius: 50% 50% 50% 0;
                            transform: rotate(-45deg);
                            width: 32px;
                            height: 32px;
                            box-shadow: 0 4px 12px rgba(239, 59, 51, 0.4);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                            <span style="transform: rotate(45deg); font-size: 14px;">🏠</span>
                        </div>
                    </div>
                `,
                className: 'dest-custom-marker',
                iconSize: [120, 60],
                iconAnchor: [60, 60],
            });

            if (this.destMarker) {
                this.destMarker.setLatLng(position);
            } else {
                this.destMarker = L.marker(position, { icon: destIcon })
                    .addTo(this.map)
                    .bindPopup(`<b>🏠 Lokasi Pengiriman</b><br>${this.shippingAddress || 'Titik Tujuan'}`);
            }
        },

        async fetchRoute(sellerLat, sellerLng, destLat, destLng) {
            try {
                // OSRM routing endpoint for true street navigation
                const url = `https://router.project-osrm.org/route/v1/driving/${sellerLng},${sellerLat};${destLng},${destLat}?overview=full&geometries=geojson`;
                const response = await fetch(url);
                const data = await response.json();

                if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                    const route = data.routes[0];

                    // Distance & ETA formatted
                    if (route.distance > 0) {
                        this.routeDistance = (route.distance / 1000).toFixed(1) + ' km';
                    }
                    if (route.duration > 0) {
                        this.routeDuration = Math.ceil(route.duration / 60) + ' menit';
                    }

                    // Convert [lng, lat] GeoJSON to [lat, lng] for Leaflet
                    const coords = route.geometry.coordinates.map(([lng, lat]) => [lat, lng]);
                    this.renderBlueRoute(coords);
                    return;
                }
            } catch (err) {
                console.warn('OSRM routing fetch failed, falling back to direct polyline:', err);
            }

            // Fallback direct line between seller and destination
            this.renderBlueRoute([
                [sellerLat, sellerLng],
                [destLat, destLng],
            ]);
        },

        renderBlueRoute(latLngs) {
            // Remove old route polylines
            if (this.routeBasePolyline) {
                this.map.removeLayer(this.routeBasePolyline);
                this.routeBasePolyline = null;
            }
            if (this.routeFrontPolyline) {
                this.map.removeLayer(this.routeFrontPolyline);
                this.routeFrontPolyline = null;
            }
            if (this.routeFlowPolyline) {
                this.map.removeLayer(this.routeFlowPolyline);
                this.routeFlowPolyline = null;
            }

            // Rute Garis Biru Navigasi U-Market (solid, bersih & tegas tanpa garis putih)
            this.routeFrontPolyline = L.polyline(latLngs, {
                color: '#0284C7',
                weight: 6,
                opacity: 0.95,
                lineCap: 'round',
                lineJoin: 'round',
            }).addTo(this.map);

            // Fit map bounds to show entire route comfortably
            if (!this.hasInitialFit && latLngs.length > 0) {
                this.fitMapToRoute();
                this.hasInitialFit = true;
            }
        },

        fitMapToRoute() {
            if (!this.map) return;
            const points = [];
            if (this.tracking?.latitude && this.tracking?.longitude) {
                points.push([parseFloat(this.tracking.latitude), parseFloat(this.tracking.longitude)]);
            }
            if (this.destinationLat && this.destinationLng) {
                points.push([this.destinationLat, this.destinationLng]);
            }

            if (points.length >= 2) {
                const bounds = L.latLngBounds(points);
                this.map.fitBounds(bounds, {
                    padding: [50, 50],
                    maxZoom: 16,
                    animate: true,
                });
            } else if (points.length === 1) {
                this.map.setView(points[0], 15, { animate: true });
            }
        },

        async onDestinationUpdated(loc) {
            try {
                await axios.post(`/api/tracking/${this.transactionId}/destination`, {
                    destination_lat: loc.lat,
                    destination_lng: loc.lng,
                    shipping_address: loc.address,
                });
                this.destinationLat = loc.lat;
                this.destinationLng = loc.lng;
                this.shippingAddress = loc.address;
                this.showMapPicker = false;
                this.updateDestinationMarker(loc.lat, loc.lng);

                if (this.tracking?.latitude && this.tracking?.longitude) {
                    this.fetchRoute(
                        parseFloat(this.tracking.latitude),
                        parseFloat(this.tracking.longitude),
                        loc.lat,
                        loc.lng
                    );
                } else {
                    this.map.setView([loc.lat, loc.lng], 16);
                }
            } catch (err) {
                console.error('Failed to update destination:', err);
                alert('Gagal menyimpan titik tujuan.');
            }
        },

        startPolling() {
            this.isPolling = true;
            this.pollInterval = setInterval(() => {
                if (this.transactionStatus === 'delivered') {
                    this.stopPolling();
                    return;
                }
                this.fetchTracking();
            }, 4000); // Polling setiap 4 detik untuk update posisi mulus
        },

        stopPolling() {
            this.isPolling = false;
            if (this.pollInterval) {
                clearInterval(this.pollInterval);
                this.pollInterval = null;
            }
        },
    },
};
</script>

<style scoped>
.tracking-map-container {
    background: white;
    border-radius: 16px;
    border: 1px solid rgba(253, 161, 162, 0.3);
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

:root.dark .tracking-map-container,
.dark .tracking-map-container {
    background: #1D1842;
    border-color: rgba(142, 13, 60, 0.3);
}

.tracking-header {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(253, 161, 162, 0.2);
}

.map-wrapper {
    height: 380px;
    width: 100%;
    z-index: 1;
}

.tracking-info {
    padding: 16px 20px;
    border-top: 1px solid rgba(253, 161, 162, 0.2);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 4px 0;
}

.info-label {
    font-size: 0.8125rem;
    color: #6b7280;
}

.dark .info-label {
    color: #9ca3af;
}

.info-value {
    font-size: 0.8125rem;
    color: #1D1842;
}

.dark .info-value {
    color: #FDA1A2;
}

.pulse-dot {
    width: 7px;
    height: 7px;
    background: #22c55e;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(1.3); }
    100% { opacity: 1; transform: scale(1); }
}

@keyframes pulse-ring {
    0% { transform: scale(0.6); opacity: 0.9; }
    50% { transform: scale(1.15); opacity: 0.3; }
    100% { transform: scale(1.4); opacity: 0; }
}

@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

.animate-bounce-subtle {
    animation: bounce-subtle 2s infinite ease-in-out;
}
</style>
