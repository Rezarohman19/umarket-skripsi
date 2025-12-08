<template>
    <div id="app" class="w-full">
        <div class="max-w-4xl mx-auto p-6">
            <h1
                class="text-3xl font-bold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]"
            >
                Welcome to Vue.js + Laravel
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Vue.js sudah berhasil diintegrasikan dengan Laravel! Kamu bisa
                mulai membuat komponen Vue di folder
                <code class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded"
                    >resources/js/components</code
                >
            </p>

            <!-- Contoh penggunaan komponen -->
            <ExampleComponent />
        </div>
    </div>
</template>

<script>
import ExampleComponent from "./components/ExampleComponent.vue";

export default {
    name: "App",
    components: {
        ExampleComponent,
    },
    mounted() {
        console.log("Vue app mounted successfully!");
    },
};
</script>

<style scoped>
/* App styles here */
</style>
