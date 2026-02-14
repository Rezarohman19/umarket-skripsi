import './bootstrap';
import { createApp } from 'vue';
import AdminDashboard from './views/AdminDashboard.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminDashboard).mount('#app');
}

