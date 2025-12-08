import './bootstrap';
import { createApp } from 'vue';
import OpenShop from './views/OpenShop.vue';

const appElement = document.getElementById('app');
if (appElement) {
    createApp(OpenShop).mount('#app');
}

