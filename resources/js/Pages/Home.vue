<script setup>
import Container from '../Components/Container.vue';
import Card from '../Components/Card.vue';

defineProps({
    listings: Object
})
</script>

<template>
    <Head title="Latest listings" />
    <Contriner>
        <div v-if="Object.keys(listings.data).length">
            <div class="grid grid-cols-3 gap-4">
                <div v-for="listing in listings.data" :key="listing.id">
                    <Card :listing="listing" />
                </div>
            </div>

        </div>
    </Contriner>
</template>