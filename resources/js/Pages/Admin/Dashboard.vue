<script setup>
import PaginationLinks from '../../Components/PaginationLinks.vue';
import RoleSelect from '../../Components/RoleSelect.vue';
import SessionMessage from '../../Components/SessionMessage.vue';
import InputField from '../../Components/InputField.vue';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const params = route().params;
const props = defineProps({
    users: Object,
    status: String,
    search: String
})

const form = useForm({
    search: params.search,
    user_role: params.user_role
})

const search = () => {
    form.get(route('admin.index'), { search: form.search })
}

const switchSuspend = (e) => {
    if (e.target.checked) {
        router.get(route('admin.index', {
            search: props.search,
            user_role: 'suspended'
        }))
    } else {
        router.get(route('admin.index', {
            search: props.search,
            user_role: null
        }))
    }
}
</script>

<template>
    <Head title="- Admin" />

    <SessionMessage :status="status" />

    <div class="flex items-end justify-between mb-6">
        <div class="flex items-end gap-2">
            <form @submit.prevent="search" class="flex items-center gap-2">
                <InputField label="" type="search" placeholder="Search..." icon="magnifying-glass" v-model="form.search" />
            </form>

            <Link
                :href="route('admin.index', { ...params, search: null, page: null })"
                v-if="params.search"
                class="px-2 py-[6px] rounded-lg bg-indigo-500 text-white flex items-center gap-2">
                {{ params.search }}
                <i class="fa-solid fa-times"></i>
            </Link>
        </div>

        <div
            class="mb-2 flex items-center gap-1 text-sm text-slate-300 dark:hover:bg-slate-800 px-2 py-1 rounded-md">
            <input
                @input ="switchSuspend"
                :checked="params.user_role"
                type="checkbox"
                id="toggleRole"
                class="rounded-md border-1 outline-0 text-indigo-500 ring-indigo-500 border-slate-700 cursor-pointer" />

            <label
                for="toggleRole"
                class="block text-sm form-medium text-slate-700  dark:text-slate-300 cursor-pointer">
                Show suspended users
            </label>

        </div>
    </div>

    <table class="bg-white dark:bg-slate-800 w0full rounded-lg overflow-hidden rign-1 ring-slate-300">
        <thead>
            <tr class="bg-slate-600 text-slate-300 uppercase text-ss text-left">
                <th class="w-3/6 p-3">Name</th>
                <th class="w-3/6 p-3">Role</th>
                <th class="w-3/6 p-3">Listing</th>
                <th class="w-3/6 p-3 text-right">View</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-300 divide-dashed">
            <tr v-for="user in users.data" :key="user.id">
                <td class="w-3/6 py-5 px-3">
                    <p class="font-bold mb-1">{{ user.name }}</p>
                    <p class="font-light text-xs">{{ user.email }}</p>
                </td>
                <td class="w-2/6 py-5 px-3">
                    <RoleSelect :user="user" />
                </td>
                <td class="w-1/6 py-5 px-3">
                    <div class="flex items-center gap-6">
                        <div class="flex items-center gap-1">
                            {{ user.listings.filter(l => l.approved).length }}
                            <i class="fa-solid fa-circle-check text-green-400"></i>
                        </div>
                        <div class="flex items-center gap-1">
                            {{ user.listings.filter(l => !l.approved).length }}
                            <i class="fa-solid fa-circle-xmark text-red-400"></i>
                        </div>
                    </div>
                </td>
                <td class="w-1/6 py-5 px-3 text-right">
                    Listing view
                </td>
            </tr>
        </tbody>
    </table>
    <div>
        <PaginationLinks :paginator="users" />
    </div>
</template>