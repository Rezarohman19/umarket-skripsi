import './bootstrap';
import { createApp } from 'vue';
import Login from './views/Login.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(Login).mount('#app');
}

