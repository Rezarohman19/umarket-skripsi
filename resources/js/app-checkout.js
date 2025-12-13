import './bootstrap';
import { createApp } from 'vue';
import Checkout from './views/Checkout.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(Checkout).mount('#app');
}

