import './bootstrap';
import { createApp } from 'vue';
import LandingPage from './views/LandingPage.vue';

// Mount Vue app untuk halaman landing
const appElement = document.getElementById('app');
if (appElement) {
    createApp(LandingPage).mount('#app');
}

