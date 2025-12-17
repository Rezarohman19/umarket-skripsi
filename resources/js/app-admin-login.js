import './bootstrap';
import { createApp } from 'vue';
import AdminLogin from './views/AdminLogin.vue';

// Mount Vue app untuk halaman admin login
const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminLogin).mount('#app');
}

