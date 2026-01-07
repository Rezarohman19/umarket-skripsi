<template>
    <div :class="containerClass">
        <img
            src="/images/logo-u.png"
            :alt="alt"
            class="w-full h-full object-contain"
        />
    </div>
</template>

<script setup>
const props = defineProps({
    containerClass: { type: String, default: "w-10 h-10" },
    alt: { type: String, default: "U Market" },
});
</script>

<style scoped>
/* no styles by default; sizing controlled via containerClass prop */
</style>
