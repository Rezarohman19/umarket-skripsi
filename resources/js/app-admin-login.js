import './bootstrap';
import { createApp } from 'vue';
import AdminLogin from './views/AdminLogin.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminLogin).mount('#app');
}

