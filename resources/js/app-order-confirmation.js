import './bootstrap';
import { createApp } from 'vue';
import OrderConfirmation from './views/OrderConfirmation.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(OrderConfirmation).mount('#app');
}

