import './bootstrap';
import { createApp } from 'vue';
import ProductDetail from './views/ProductDetail.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(ProductDetail).mount('#app');
}

