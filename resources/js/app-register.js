import './bootstrap';
import { createApp } from 'vue';
import Register from './views/Register.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(Register).mount('#app');
}

