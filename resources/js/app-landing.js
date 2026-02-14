import './bootstrap';
import { createApp } from 'vue';
import LandingPage from './views/LandingPage.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(LandingPage).mount('#app');
}

