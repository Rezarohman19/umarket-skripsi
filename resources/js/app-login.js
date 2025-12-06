import './bootstrap';
import { createApp } from 'vue';
import Login from './views/Login.vue';

// Mount Vue app untuk halaman login
const appElement = document.getElementById('app');
if (appElement) {
    createApp(Login).mount('#app');
}

