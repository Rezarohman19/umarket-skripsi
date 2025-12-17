import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/app-login.js',
                'resources/js/app-register.js',
                'resources/js/app-landing.js',
                'resources/js/app-orders.js',
                'resources/js/app-open-shop.js',
                'resources/js/app-cart.js',
                'resources/js/app-checkout.js',
                'resources/js/app-order-confirmation.js',
                'resources/js/app-profile.js',
                'resources/js/app-product-detail.js',
                'resources/js/app-admin-dashboard.js',
                'resources/js/app-admin-products.js',
                'resources/js/app-admin-users.js',
                'resources/js/app-admin-sales.js',
                'resources/js/app-admin-profile.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss(),
    ],
});
