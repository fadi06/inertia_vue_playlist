<script setup>
defineProps({
    listing: Object
})
</script>

<template>
    <div class="bg-white rounded-lg shoadow-lg overflow-hidden dark:bg-slate-800 h-full flex flex-col justify-between">
        <div>
            <Link  href="">
                <img :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listings/default.png'" class="w-full h-48 bg-slate-300 object-cover object-center" />
            </Link>

            <div class="p-4">
                <h3 class="font-bold text-xl mb-2">
                    {{ listing.title.substring(0, 40) }}...
                </h3>
    
                <p>
                    Listed on {{ new Date(listing.created_at).toLocaleDateString() }} By 
                    <button class="text-link">
                        {{ listing.user.name}}
                    </button>
                </p>
            </div>
    
            <div v-if="listing.tags" class="flex items-center gap-3 px-4 mb-4">
                <div  v-for="tag in listing.tags.split(',')" :key="tag">
                    <button class="bg-slate-500 text-white px-2 py-px rounded-full hover:bg-slate-700 dark:hover:bg-slate-900">
                        {{ tag }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>