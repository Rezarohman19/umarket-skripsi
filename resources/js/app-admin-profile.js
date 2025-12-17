import './bootstrap';
import { createApp } from 'vue';
import AdminProfile from './views/AdminProfile.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(AdminProfile).mount('#app');
}


