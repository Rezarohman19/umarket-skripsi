import './bootstrap';
import { createApp } from 'vue';
import Cart from './views/Cart.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(Cart).mount('#app');
}

