<template>
    <div class="example-component p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-2">{{ title }}</h2>
        <p class="text-gray-600 dark:text-gray-300">{{ message }}</p>
        <button 
            @click="increment" 
            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
        >
            Click me! ({{ count }})
        </button>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: 'ExampleComponent',
    setup() {
        const title = ref('Example Component');
        const message = ref('Ini adalah contoh komponen Vue.js yang bisa kamu gunakan sebagai template.');
        const count = ref(0);

        const increment = () => {
            count.value++;
        };

        return {
            title,
            message,
            count,
            increment
        };
    }
}
</script>

<style scoped>
.example-component {
    transition: all 0.3s ease;
}
</style>

