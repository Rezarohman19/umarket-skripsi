import './bootstrap';
import { createApp } from 'vue';
import Orders from './views/Orders.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(Orders).mount('#app');
}

