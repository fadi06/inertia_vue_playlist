<script setup>
import PaginationLinks from '../../Components/PaginationLinks.vue';
import InputField from '../../Components/InputField.vue';
import SessionMessage from '../../Components/SessionMessage.vue';
import { router, useForm } from '@inertiajs/vue3';

const params = route().params;

const form = useForm({
    search: params.search,
})

const props = defineProps({
    user: Object,
    userListings: Object,
    status: String
})

const search = () => {
    form.get(route('user.show', { 
        user: props.user.id,
        search: form.search
    }))
}

const showDisapproved = (e) => {
    if (e.target.checked) {
        router.get(route('user.show', {
            user: props.user.id,
            search: params.search,
            disapproved: true
        }))
    } else {
        router.get(route('user.show', {
            user: props.user.id,
            search: params.search,
            disapproved: null
        }))
    }
}

const toggleApproved = (listing) => {
    let msg = listing.approved ? 'Disapprove this listing' : 'Approve this listing';

    if(confirm(msg)) {
        router.put(route('listing.approve', listing.id))
    }
}

</script>

<template>
    <Head :title="`- ${user.name} listings`" />
    <SessionMessage :status="status" />
    <div class="flex items-end justify-between mb-6">
        <div class="flex items-end gap-2">
            <form @submit.prevent="search" class="flex items-center gap-2">
                <InputField label="" type="search" placeholder="Search..." icon="magnifying-glass" v-model="form.search" />
            </form>

            <Link
                :href="route('user.show', {
                    user: user.id, ...params, search: null, page: null 
                })"
                v-if="params.search"
                class="px-2 py-[6px] rounded-lg bg-indigo-500 text-white flex items-center gap-2">
                {{ params.search }}
                <i class="fa-solid fa-times"></i>
            </Link>
        </div>

        <div
            class="mb-2 flex items-center gap-1 text-sm text-slate-300 dark:hover:bg-slate-800 px-2 py-1 rounded-md">
            <input
                @input ="showDisapproved"
                :checked="params.disapproved"
                type="checkbox"
                id="toggleRole"
                class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer" />

            <label
                for="toggleRole"
                class="block text-sm form-medium text-slate-700  dark:text-slate-300 cursor-pointer">
                Show disapproved listings
            </label>

        </div>
    </div>

    <table class="bg-white dark:bg-slate-800 w0full rounded-lg overflow-hidden rign-1 ring-slate-300">
        <thead>
            <tr class="bg-slate-600 text-slate-300 uppercase text-ss text-left">
                <th class="w-4/6 p-3">Title</th>
                <th class="w-2/6 p-3 text-center">Approved</th>
                <th class="w-1/6 p-3 text-right">View</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="listing in userListings.data" :key="listing.id">
                <td class="py-5 px-3">
                    {{ listing.title }}
                </td>
                <td class="py-5 px-3 text-2xl text-center">
                    <button type="button" @click.prevent="toggleApproved(listing)">
                        <i :class="`fa-solid fa-${listing.approved ? 'circle-check' : 'circle-xmark'} text-${listing.approved ? 'green-400' : 'red-400'}`"></i>
                    </button>
                </td>
                <td class="w-1/6 py-5 px-3 text-right">
                    <Link :href="route('listing.show', listing.id)" class="fa-solid fa-external-link px-3 text-indigo-400"></Link>
                </td>
            </tr>
        </tbody>
    </table>
    <div>
        <PaginationLinks :paginator="userListings" />
    </div>
</template>