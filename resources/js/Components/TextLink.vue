<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    routeName: String,
    label: String,
})
</script>

<template>
    <Link
        class="text-indigo-500 hover:text-indigo-600 font-medium underline dark:text-indigo-400 dark:hover:text-indigo-500" :href="route(routeName)">{{ label }}</Link>
</template>