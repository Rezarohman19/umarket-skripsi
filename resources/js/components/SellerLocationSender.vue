<template>
    <div class="sender-container">
        <!-- Header -->
        <div class="sender-header">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base sm:text-lg font-bold text-[#1D1842] dark:text-[#FDA1A2] flex items-center gap-2">
                        <span>🛵</span>
                        <span>Navigasi & Pengiriman Kurir</span>
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Order ID: <span class="font-mono font-medium">{{ orderId }}</span>
                    </p>
                </div>
                <div v-if="destinationLat && destinationLng" class="text-right">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200/50">
                        <span>📍 Titik Ada</span>
                    </span>
                </div>
            </div>

            <!-- Buyer & Destination Summary Card -->
            <div class="mt-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/20 rounded-xl p-3 sm:p-3.5 border border-blue-100 dark:border-blue-900/40">
                <div class="flex items-start justify-between gap-3">
                    <div class="space-y-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-[#1D1842] dark:text-white truncate">
                                🏠 {{ buyerName || 'Pembeli' }}
                            </span>
                            <a
                                v-if="buyerPhone"
                                :href="`https://wa.me/${formatWaNumber(buyerPhone)}`"
                                target="_blank"
                                class="inline-flex items-center gap-1 text-[11px] font-semibold text-green-700 dark:text-green-400 bg-green-100 dark:bg-green-900/40 px-2 py-0.5 rounded-full hover:bg-green-200 transition-colors"
                            >
                                <span>💬 WA</span>
                            </a>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-300 line-clamp-2 leading-relaxed">
                            {{ destinationAddress || 'Alamat tujuan belum tercatat' }}
                        </p>
                    </div>

                    <!-- Open in Google Maps button -->
                    <button
                        v-if="destinationLat && destinationLng"
                        @click="openGoogleMaps"
                        type="button"
                        class="flex-shrink-0 px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-sm transition-all flex items-center gap-1"
                        title="Buka petunjuk arah di aplikasi Google Maps"
                    >
                        <span>🗺️ Google Maps</span>
                    </button>
                </div>

                <!-- Distance & ETA summary banner -->
                <div v-if="routeDistance" class="mt-2.5 pt-2 border-t border-blue-200/50 dark:border-blue-800/40 flex items-center justify-between text-xs text-blue-900 dark:text-blue-200">
                    <span class="font-medium flex items-center gap-1">
                        <span>📏 Jarak ke Pembeli:</span>
                        <strong class="font-extrabold">{{ routeDistance }}</strong>
                    </span>
                    <span v-if="routeDuration" class="font-medium flex items-center gap-1">
                        <span>⏱️ Estimasi Waktu:</span>
                        <strong class="font-extrabold">~{{ routeDuration }}</strong>
                    </span>
                </div>
            </div>
        </div>

        <!-- Map Container with Route Overlay -->
        <div class="relative">
            <div ref="mapContainer" class="map-preview"></div>

            <!-- Route legend overlay -->
            <div class="absolute top-2 left-2 z-[400] flex flex-col gap-1 pointer-events-none">
                <div v-if="destinationLat && destinationLng" class="bg-white/90 dark:bg-[#1D1842]/90 backdrop-blur-sm px-2.5 py-1 rounded-full shadow text-[10px] text-gray-700 dark:text-gray-300 flex items-center gap-2 pointer-events-auto border border-blue-200/50">
                    <span class="w-2.5 h-1 bg-[#0284C7] rounded-full inline-block"></span>
                    <span>Rute Pengiriman U-Market</span>
                </div>
            </div>

            <!-- Fit route button -->
            <button
                v-if="destinationLat && destinationLng"
                @click="fitMapToRoute"
                class="absolute bottom-2 right-2 z-[400] bg-white dark:bg-[#1D1842] text-gray-700 dark:text-gray-200 px-2.5 py-1.5 rounded-lg shadow text-xs font-medium border border-gray-200 dark:border-gray-700 hover:bg-gray-50 flex items-center gap-1"
            >
                <span>🔍 Pusatkan Rute</span>
            </button>
        </div>

        <!-- Status & Controls -->
        <div class="sender-controls space-y-3">
            <!-- Belum mulai kirim -->
            <div v-if="!isTracking && deliveryStatus !== 'delivered'" class="space-y-3">
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    Klik tombol di bawah untuk mengaktifkan GPS HP dan memandu rute perjalanan ke alamat pembeli secara real-time.
                </p>
                <div class="flex flex-col sm:flex-row gap-2">
                    <button
                        @click="startDelivery"
                        :disabled="isLoading"
                        class="flex-1 py-3 px-4 bg-[#EF3B33] hover:bg-[#d32f2f] text-white rounded-xl font-bold transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 shadow-md hover:shadow-lg text-sm"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ isLoading ? 'Mengaktifkan GPS...' : '🚀 Mulai Pengiriman' }}
                    </button>
                </div>
            </div>

            <!-- Sedang mengirim / memantau -->
            <div v-else-if="isTracking && deliveryStatus !== 'delivered'" class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="pulse-dot-green"></span>
                        <span class="text-xs font-bold text-green-600 dark:text-green-400">
                            {{ isBroadcasting ? '📡 GPS HP Aktif & Mengirim Lokasi' : '📡 Memantau Rute Pengiriman' }}
                        </span>
                    </div>
                </div>

                <!-- Status selector -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                        Status Pengiriman:
                    </label>
                    <select
                        v-model="currentStatus"
                        @change="updateStatus"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-[#252054] border border-gray-200 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 focus:outline-none focus:border-[#EF3B33]"
                    >
                        <option value="picked_up">📦 Pesanan Diambil / Dikemas</option>
                        <option value="on_the_way">🛵 Dalam Perjalanan Menuju Pembeli</option>
                        <option value="nearby">📍 Sudah Dekat Lokasi Tujuan</option>
                    </select>
                </div>

                <!-- Note input -->
                <div>
                    <input
                        v-model="note"
                        type="text"
                        placeholder="Catatan ke pembeli (misal: kurir di depan gang / gerbang)"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-[#252054] border border-gray-200 dark:border-gray-700 rounded-xl text-xs text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-[#EF3B33]"
                    />
                </div>

                <!-- Action buttons -->
                <div class="pt-1">
                    <button
                        @click="completeDelivery"
                        :disabled="isLoading"
                        class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition-all duration-200 disabled:opacity-50 flex items-center justify-center gap-2 shadow-md hover:shadow-lg text-sm"
                    >
                        ✅ {{ isLoading ? 'Menyelesaikan...' : 'Pesanan Sudah Sampai' }}
                    </button>
                </div>
            </div>

            <!-- Selesai -->
            <div v-else class="text-center py-4 bg-green-50 dark:bg-green-950/20 rounded-xl border border-green-200/50">
                <p class="text-green-600 dark:text-green-400 font-bold text-base">
                    ✅ Pengiriman Selesai!
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Pesanan telah berhasil diantar ke tempat tujuan pembeli.
                </p>
            </div>
        </div>

        <!-- Error message -->
        <div v-if="errorMessage" class="error-bar">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import axios from 'axios';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

export default {
    name: 'SellerLocationSender',
    props: {
        transactionId: {
            type: [Number, String],
            required: true,
        },
        orderId: {
            type: String,
            default: '',
        },
    },
    emits: ['delivery-completed'],
    data() {
        return {
            map: null,
            myMarker: null,
            destMarker: null,
            routeBasePolyline: null,
            routeFrontPolyline: null,
            routeFlowPolyline: null,
            isTracking: false,
            isBroadcasting: false,
            isLoading: false,
            deliveryStatus: null,
            currentStatus: 'on_the_way',
            note: '',
            errorMessage: '',
            watchId: null,
            sendInterval: null,
            pollInterval: null,
            simulationInterval: null,
            isSimulating: false,
            simulationStep: 0,
            simulatedCoords: [],
            currentLat: null,
            currentLng: null,
            destinationLat: null,
            destinationLng: null,
            destinationAddress: '',
            buyerName: '',
            buyerPhone: '',
            routeDistance: null,
            routeDuration: null,
            hasInitialFit: false,
        };
    },
    mounted() {
        this.$nextTick(() => {
            this.initMap();
            this.checkExistingTracking();
        });
    },
    beforeUnmount() {
        this.stopTracking();
        this.stopSimulation();
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    },
    methods: {
        initMap() {
            this.map = L.map(this.$refs.mapContainer).setView([-5.3971, 105.2668], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(this.map);

            setTimeout(() => {
                if (this.map) this.map.invalidateSize();
            }, 300);
        },

        async checkExistingTracking() {
            try {
                const response = await axios.get(`/api/tracking/${this.transactionId}`);
                const data = response.data;

                this.destinationAddress = data.shipping_address || '';
                this.buyerName = data.shipping_name || '';
                this.buyerPhone = data.shipping_phone || '';

                if (data.destination_lat && data.destination_lng) {
                    this.destinationLat = parseFloat(data.destination_lat);
                    this.destinationLng = parseFloat(data.destination_lng);
                    this.updateDestMarker(this.destinationLat, this.destinationLng);
                }

                if (data.tracking) {
                    const t = data.tracking;
                    if (t.tracking_status === 'delivered') {
                        this.deliveryStatus = 'delivered';
                    } else {
                        this.isTracking = true;
                        this.isBroadcasting = false;
                        this.currentStatus = t.tracking_status;
                        if (t.note) this.note = t.note;
                        this.currentLat = parseFloat(t.latitude);
                        this.currentLng = parseFloat(t.longitude);
                        this.updateMyPosition(this.currentLat, this.currentLng);

                        if (this.destinationLat && this.destinationLng) {
                            this.fetchRoute(this.currentLat, this.currentLng, this.destinationLat, this.destinationLng);
                        }

                        this.startPollingUpdates();
                    }
                } else if (this.destinationLat && this.destinationLng && !this.hasInitialFit) {
                    this.map.setView([this.destinationLat, this.destinationLng], 15);
                    this.hasInitialFit = true;
                }

                if (data.transaction_status === 'delivered') {
                    this.deliveryStatus = 'delivered';
                }
            } catch (error) {
                console.warn('Check existing tracking error:', error);
            }
        },

        updateMyPosition(lat, lng) {
            const position = [lat, lng];

            // ShopeeFood courier icon
            const myIcon = L.divIcon({
                html: `
                    <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                        <div style="
                            position: absolute;
                            width: 44px;
                            height: 44px;
                            border-radius: 50%;
                            background: rgba(37, 99, 235, 0.3);
                            animation: pulse-ring 1.8s infinite;
                        "></div>
                        <div style="
                            background: #2563EB;
                            color: white;
                            border: 3px solid white;
                            border-radius: 50%;
                            width: 34px;
                            height: 34px;
                            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.5);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 16px;
                            z-index: 2;
                        ">
                            🛵
                        </div>
                    </div>
                `,
                className: 'my-courier-marker',
                iconSize: [44, 44],
                iconAnchor: [22, 22],
            });

            if (this.myMarker) {
                this.myMarker.setLatLng(position);
            } else {
                this.myMarker = L.marker(position, { icon: myIcon })
                    .addTo(this.map)
                    .bindPopup('<b>🛵 Posisi Anda (Kurir)</b>');
            }
        },

        updateDestMarker(lat, lng) {
            const position = [lat, lng];

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
                            Tujuan
                        </div>
                        <div style="
                            background: #EF3B33;
                            border: 3px solid white;
                            border-radius: 50% 50% 50% 0;
                            transform: rotate(-45deg);
                            width: 30px;
                            height: 30px;
                            box-shadow: 0 4px 12px rgba(239, 59, 51, 0.4);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                            <span style="transform: rotate(45deg); font-size: 14px;">🏠</span>
                        </div>
                    </div>
                `,
                className: 'dest-courier-marker',
                iconSize: [60, 56],
                iconAnchor: [30, 56],
            });

            if (this.destMarker) {
                this.destMarker.setLatLng(position);
            } else {
                this.destMarker = L.marker(position, { icon: destIcon })
                    .addTo(this.map)
                    .bindPopup(`<b>🏠 Tujuan Pembeli</b><br>${this.destinationAddress || 'Alamat Penerima'}`);
            }
        },

        async fetchRoute(sellerLat, sellerLng, destLat, destLng) {
            try {
                const url = `https://router.project-osrm.org/route/v1/driving/${sellerLng},${sellerLat};${destLng},${destLat}?overview=full&geometries=geojson`;
                const response = await fetch(url);
                const data = await response.json();

                if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                    const route = data.routes[0];
                    if (route.distance > 0) {
                        this.routeDistance = (route.distance / 1000).toFixed(1) + ' km';
                    }
                    if (route.duration > 0) {
                        this.routeDuration = Math.ceil(route.duration / 60) + ' menit';
                    }

                    const coords = route.geometry.coordinates.map(([lng, lat]) => [lat, lng]);
                    this.simulatedCoords = coords;
                    this.renderBlueRoute(coords);
                    return;
                }
            } catch (err) {
                console.warn('OSRM routing fetch failed:', err);
            }

            const fallbackCoords = [
                [sellerLat, sellerLng],
                [destLat, destLng],
            ];
            this.simulatedCoords = fallbackCoords;
            this.renderBlueRoute(fallbackCoords);
        },

        renderBlueRoute(latLngs) {
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

            if (!this.hasInitialFit) {
                this.fitMapToRoute();
                this.hasInitialFit = true;
            }
        },

        fitMapToRoute() {
            if (!this.map) return;
            const points = [];
            if (this.currentLat && this.currentLng) {
                points.push([this.currentLat, this.currentLng]);
            }
            if (this.destinationLat && this.destinationLng) {
                points.push([this.destinationLat, this.destinationLng]);
            }

            if (points.length >= 2) {
                this.map.fitBounds(L.latLngBounds(points), {
                    padding: [50, 50],
                    maxZoom: 16,
                    animate: true,
                });
            } else if (points.length === 1) {
                this.map.setView(points[0], 16, { animate: true });
            }
        },

        openGoogleMaps() {
            if (!this.destinationLat || !this.destinationLng) return;
            const dest = `${this.destinationLat},${this.destinationLng}`;
            const origin = (this.currentLat && this.currentLng)
                ? `${this.currentLat},${this.currentLng}`
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

        async startDelivery() {
            this.isLoading = true;
            this.errorMessage = '';

            if (!navigator.geolocation) {
                this.errorMessage = 'Browser tidak mendukung GPS. Gunakan browser di HP seperti Chrome atau Safari.';
                this.isLoading = false;
                return;
            }

            try {
                const position = await this.getCurrentPosition();
                this.currentLat = position.coords.latitude;
                this.currentLng = position.coords.longitude;

                const response = await axios.post(`/api/tracking/${this.transactionId}/start`, {
                    latitude: this.currentLat,
                    longitude: this.currentLng,
                });

                if (response.data.destination_lat && response.data.destination_lng) {
                    this.destinationLat = parseFloat(response.data.destination_lat);
                    this.destinationLng = parseFloat(response.data.destination_lng);
                    this.updateDestMarker(this.destinationLat, this.destinationLng);
                }

                this.isTracking = true;
                this.isBroadcasting = true;
                this.updateMyPosition(this.currentLat, this.currentLng);

                if (this.destinationLat && this.destinationLng) {
                    this.fetchRoute(this.currentLat, this.currentLng, this.destinationLat, this.destinationLng);
                }

                this.startWatchingPosition();
            } catch (error) {
                if (error.code === 1) {
                    this.errorMessage = 'Izin GPS ditolak. Silakan aktifkan izin lokasi di browser Anda.';
                } else if (error.response) {
                    this.errorMessage = error.response.data.message || 'Gagal memulai pengiriman.';
                } else {
                    this.errorMessage = 'Gagal mendeteksi lokasi GPS.';
                }
            } finally {
                this.isLoading = false;
            }
        },

        getCurrentPosition() {
            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0,
                });
            });
        },

        startWatchingPosition() {
            this.watchId = navigator.geolocation.watchPosition(
                (position) => {
                    this.currentLat = position.coords.latitude;
                    this.currentLng = position.coords.longitude;
                    this.updateMyPosition(this.currentLat, this.currentLng);
                },
                (error) => console.error('GPS watch error:', error),
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 5000 }
            );

            this.sendInterval = setInterval(() => {
                if (this.currentLat && this.currentLng && !this.isSimulating) {
                    this.sendLocationToServer();
                }
            }, 8000); // Kirim koordinat setiap 8 detik
        },

        stopTracking() {
            if (this.watchId !== null) {
                navigator.geolocation.clearWatch(this.watchId);
                this.watchId = null;
            }
            if (this.sendInterval) {
                clearInterval(this.sendInterval);
                this.sendInterval = null;
            }
            this.stopPollingUpdates();
            this.isTracking = false;
        },

        startPollingUpdates() {
            if (this.pollInterval) clearInterval(this.pollInterval);
            this.pollInterval = setInterval(async () => {
                if (this.deliveryStatus === 'delivered' || this.isBroadcasting || this.isSimulating) return;
                try {
                    const response = await axios.get(`/api/tracking/${this.transactionId}`);
                    if (response.data?.tracking) {
                        const t = response.data.tracking;
                        this.currentStatus = t.tracking_status;
                        if (t.note) this.note = t.note;
                        this.currentLat = parseFloat(t.latitude);
                        this.currentLng = parseFloat(t.longitude);
                        this.updateMyPosition(this.currentLat, this.currentLng);
                    }
                    if (response.data?.transaction_status === 'delivered') {
                        this.deliveryStatus = 'delivered';
                    }
                } catch (e) {
                    console.error('Polling tracking failed:', e);
                }
            }, 4000);
        },

        stopPollingUpdates() {
            if (this.pollInterval) {
                clearInterval(this.pollInterval);
                this.pollInterval = null;
            }
        },

        async sendLocationToServer() {
            try {
                await axios.post(`/api/tracking/${this.transactionId}/update`, {
                    latitude: this.currentLat,
                    longitude: this.currentLng,
                    tracking_status: this.currentStatus,
                    note: this.note || null,
                });
            } catch (error) {
                console.error('Failed to send location:', error);
            }
        },

        async updateStatus() {
            if (this.currentLat && this.currentLng) {
                await this.sendLocationToServer();
            }
        },

        async completeDelivery() {
            this.isLoading = true;
            this.errorMessage = '';

            try {
                await axios.post(`/api/tracking/${this.transactionId}/complete`, {
                    latitude: this.currentLat || 0,
                    longitude: this.currentLng || 0,
                });

                this.stopTracking();
                this.stopSimulation();
                this.deliveryStatus = 'delivered';
                this.$emit('delivery-completed');
            } catch (error) {
                this.errorMessage = error.response?.data?.message || 'Gagal menyelesaikan pengiriman.';
            } finally {
                this.isLoading = false;
            }
        },

        /* ---------- DEMO SIMULATION (Moves courier step-by-step along blue line) ---------- */
        startSimulation() {
            if (!this.destinationLat || !this.destinationLng) {
                alert('Tujuan pengiriman belum memiliki koordinat GPS.');
                return;
            }

            this.isTracking = true;
            this.isSimulating = true;
            this.simulationStep = 0;

            // If we don't have simulated route coords yet, generate some
            if (!this.simulatedCoords || this.simulatedCoords.length < 2) {
                const startLat = this.currentLat || (this.destinationLat + 0.015);
                const startLng = this.currentLng || (this.destinationLng - 0.015);
                this.fetchRoute(startLat, startLng, this.destinationLat, this.destinationLng);
            }

            if (this.simulationInterval) clearInterval(this.simulationInterval);

            // Notify server that delivery has started if not yet
            axios.post(`/api/tracking/${this.transactionId}/start`, {
                latitude: this.currentLat || (this.destinationLat + 0.012),
                longitude: this.currentLng || (this.destinationLng - 0.012),
            }).catch(() => {});

            this.simulationInterval = setInterval(() => {
                if (!this.simulatedCoords || this.simulatedCoords.length === 0) return;

                if (this.simulationStep < this.simulatedCoords.length) {
                    const coord = this.simulatedCoords[this.simulationStep];
                    this.currentLat = coord[0];
                    this.currentLng = coord[1];
                    this.updateMyPosition(coord[0], coord[1]);

                    // Send to server periodically
                    if (this.simulationStep % 2 === 0 || this.simulationStep === this.simulatedCoords.length - 1) {
                        this.sendLocationToServer();
                    }

                    // Progressively increment step
                    const stepJump = Math.max(1, Math.floor(this.simulatedCoords.length / 20));
                    this.simulationStep += stepJump;

                    if (this.simulationStep >= this.simulatedCoords.length - 1) {
                        this.simulationStep = this.simulatedCoords.length - 1;
                        this.currentStatus = 'nearby';
                    }
                } else {
                    this.stopSimulation();
                }
            }, 1800);
        },

        stopSimulation() {
            this.isSimulating = false;
            if (this.simulationInterval) {
                clearInterval(this.simulationInterval);
                this.simulationInterval = null;
            }
        },
    },
};
</script>

<style scoped>
.sender-container {
    background: white;
    border-radius: 16px;
    border: 1px solid rgba(253, 161, 162, 0.3);
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}

.dark .sender-container {
    background: #1D1842;
    border-color: rgba(142, 13, 60, 0.3);
}

.sender-header {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(253, 161, 162, 0.2);
}

.map-preview {
    height: 280px;
    width: 100%;
    z-index: 1;
}

.sender-controls {
    padding: 16px 20px;
}

.error-bar {
    padding: 10px 20px;
    background: #fef2f2;
    color: #dc2626;
    font-size: 0.8125rem;
    border-top: 1px solid #fecaca;
}

.dark .error-bar {
    background: rgba(220, 38, 38, 0.1);
    border-color: rgba(220, 38, 38, 0.3);
}

.pulse-dot-green {
    width: 8px;
    height: 8px;
    background: #22c55e;
    border-radius: 50%;
    animation: pulse-green 1.5s infinite;
}

@keyframes pulse-green {
    0% { opacity: 1; box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5); }
    70% { opacity: 0.7; box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
    100% { opacity: 1; box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}

@keyframes pulse-ring {
    0% { transform: scale(0.6); opacity: 0.9; }
    50% { transform: scale(1.15); opacity: 0.3; }
    100% { transform: scale(1.4); opacity: 0; }
}
</style>
