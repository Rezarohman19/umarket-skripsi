import './bootstrap';
import { createApp } from 'vue';
import AdminSales from './views/AdminSales.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminSales).mount('#app');
}


