import './bootstrap';
import { createApp } from 'vue';
import ProductDetail from './views/ProductDetail.vue';

// Mount Vue app untuk halaman product detail
const appElement = document.getElementById('app');
if (appElement) {
    createApp(ProductDetail).mount('#app');
}

