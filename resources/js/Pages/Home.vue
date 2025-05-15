<script setup>
import Card from '../Components/Card.vue';
import PaginationLinks from '../Components/PaginationLinks.vue';
import InputField from '../Components/InputField.vue';
import SessionMessage from '../Components/SessionMessage.vue';
import { Link, router, useForm } from '@inertiajs/vue3';

const params = route().params;

const props = defineProps({
    listings: Object,
    searchTerm: String,
    status: String
})
console.log(params)
const form = useForm({
    search: props.searchTerm
})

const username = params.user_id ? props.listings.data.find(i => i.user_id === Number(params.user_id)).user.name : null;

const search = () => {
    router.get(route('home'), { search: form.search, user_id: params.user_id, tag: params.tag })
}
</script>

<template>
    <Head title="Latest listings" />

    <div class="flex items-center justify-between mb-4">
        <SessionMessage :status="status" />
        <div class="flex item-center gap-2">
            <Link
                :href="route('home', { ...params, tag: null, page: null })"
                v-if="params.tag"
                class="px-2 py-1 rounded-lg bg-indigo-500 text-white flex items-center gap-2">
                {{ params.tag }}
                <i class="fa-solid fa-times"></i>
            </Link>
            <Link
                :href="route('home', { ...params, search: null, page: null })"
                v-if="params.search"
                class="px-2 py-1 rounded-lg bg-indigo-500 text-white flex items-center gap-2">
                {{ params.search }}
                <i class="fa-solid fa-times"></i>
            </Link>
            <Link
                :href="route('home', { ...params, user_id: null, page: null })"
                v-if="params.user_id"
                class="px-2 py-1 rounded-lg bg-indigo-500 text-white flex items-center gap-2">
                {{ username }}
                <i class="fa-solid fa-times"></i>
            </Link>
        </div>

        <form @submit.prevent="search">
            <InputField label="" placeholder="Search..." v-model="form.search" icon="magnifying-glass" type="search" name="search" />
        </form>
    </div>

    <div v-if="Object.keys(listings.data).length">
        <div class="grid grid-cols-3 gap-4">
            <div v-for="listing in listings.data" :key="listing.id">
                <Card :listing="listing" />
            </div>
        </div>
    </div>

    <div v-else>
        No record founds.
    </div>

    <PaginationLinks :Paginator="listings" />
</template>