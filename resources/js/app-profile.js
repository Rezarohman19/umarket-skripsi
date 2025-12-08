import './bootstrap';
import { createApp } from 'vue';
import Profile from './views/Profile.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(Profile).mount('#app');
}

