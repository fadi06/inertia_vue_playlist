<script setup>
import Container from '../../Components/Container.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    listing: Object,
    canModify: Boolean
})

const deleteListing = () => {
    if (confirm('Are you sure, you want to delete this listing?')) {
        router.delete(route('listing.destroy', props.listing.id));
    }
}

const toggleApproved = () => {
    let msg = props.listing.approved ? 'Disapprove this listing' : 'Approve this listing';

    if(confirm(msg)) {
        router.put(route('listing.approve', props.listing.id))
    }
}
</script>

<template>
    <Head title="- Show Listing" />

    <div v-if="$page.props.auth.user.role == 'admin'" class="bg-slate-800 text-white mb-6 p-6 rounded-md font-medium flex items-center justify-between">
        <p>
            This listing is {{ listing.approved ? 'Approved' : 'Disapproved' }}.
        </p>

        <button @click.prevent="toggleApproved" class="bg-slate-600 px-3 py-1 rounded-md">
            {{ listing.approved ? 'Disapprove it' : 'Approve it' }}
        </button>
    </div>

    <Container class="flex gap-4">
        <div class="w-1/4 rounded-md overflow-hidden">
            <img
                :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listings/default.png'"
                alt="listing image"
                class="w-full h-full object-cover object-center"
                />
        </div>
        <div class="w-3/4">
            <div class="mb-6">
                <div class="flex items-end justify-between mb-2">
                    <p class="text-slate-400 w-full border-b">Listing detail</p>
                    <div v-if="canModify" class="pl-4 flex gap-4">
                        <Link :href="route('listing.edit', listing.id)" class="bg-green-500 rounded-md text-white px-6 py-2 hover:outline outline-green-500 outline-offset-2">
                            Edit
                        </Link>

                        <button
                            @click="deleteListing"
                            type="button"
                            class="bg-red-500 rounded-md text-white px-6 py-2 hover:outline outline-red-500 outline-offset-2">
                            Delete
                        </button>
                    </div>
                </div>
                <h3 class="font-bold text-2xl mb-4">
                    {{ listing.title }}
                </h3>
                <p>{{ listing.desc }}</p>
            </div>

            <div class="mb-6">
                <div class="flex items-end justify-between mb-2">
                    <p class="text-slate-400 w-full border-b">Contact info</p>
                </div>

                <div>
                    <div v-if="listing.email" class="flex items-center mb-2">
                        <i class="fa-solid fa-at"></i>
                        <p class="ml-2 mr-2">Email: </p>
                        <a :href="`mailto:${listing.email}`" class="text-link">{{ listing.email }}</a>
                    </div>

                    <div v-if="listing.link" class="flex items-center mb-2">
                        <i class="fa-solid fa-external-link"></i>
                        <p class="ml-2 mr-2">Link: </p>
                        <a :href="`mailto:${listing.link}`" class="text-link">{{ listing.link }}</a>
                    </div>

                    <div v-if="listing.user" class="flex items-center mb-2">
                        <i class="fa-solid fa-user"></i>
                        <p class="ml-2 mr-2">Listed by: </p>
                        <a :href="route('home', {user_id: listing.user.id})" class="text-link">{{ listing.user.name }}</a>
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <div class="flex items-end justify-between mb-2">
                    <p class="text-slate-400 w-full border-b">Tags</p>
                </div>
                <div class="flex items-center gap-3">
                    <div v-for="tag in listing.tags.split(',')" :key="tag">
                        <Link :href="route('home', {tag: tag})" class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 dark:hover:bg-slate-900">
                            {{ tag }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </Container>
</template>