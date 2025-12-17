import './bootstrap';
import { createApp } from 'vue';
import AdminDashboard from './views/AdminDashboard.vue';

// Mount Vue app untuk halaman admin dashboard
const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminDashboard).mount('#app');
}

