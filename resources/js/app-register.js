import './bootstrap';
import { createApp } from 'vue';
import Register from './views/Register.vue';

// Mount Vue app untuk halaman register
const appElement = document.getElementById('app');
if (appElement) {
    createApp(Register).mount('#app');
}

