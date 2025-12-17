import './bootstrap';
import { createApp } from 'vue';
import AdminProducts from './views/AdminProducts.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminProducts).mount('#app');
}


