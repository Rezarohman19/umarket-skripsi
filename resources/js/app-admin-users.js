import './bootstrap';
import { createApp } from 'vue';
import AdminUsers from './views/AdminUsers.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminUsers).mount('#app');
}


