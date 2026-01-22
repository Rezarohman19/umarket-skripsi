import './bootstrap';
import { createApp } from 'vue';
import StorePage from './views/StorePage.vue';

// Mount Vue app untuk halaman toko
const appElement = document.getElementById('app');
if (appElement) {
    createApp(StorePage).mount('#app');
}
