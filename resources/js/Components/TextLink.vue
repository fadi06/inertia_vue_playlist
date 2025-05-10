<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    routeName: String,
    label: String,
})
</script>

<template>
    <Link
        class="text-indego-500 hover:text-indego-600 font-medium underline dark:text-indego-400 dark:hover:text-indego-500" :href="route(routeName)">{{ label }}</Link>
</template>