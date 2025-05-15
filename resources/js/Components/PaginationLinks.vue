<script setup>
defineProps({
    paginator: Object
})

const makeLabel = (label) => {
    if (label.includes('Previous')) {
        return "<<";
    } else if (label.includes('Next')) {
        return ">>";
    } else {
        return label;
    }
}
</script>

<template>
    <div class="flex justify-between items-start mt-8">
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            Showing {{  paginator.from }} to {{ paginator.to }} of {{ paginator.total }} results
        </p>

        <div class="flex items-venter rounded-md overflow-hidden shadow-lg">
            <div v-for="(links, i) in paginator.links" :key="i">
                <component
                    :is="links.url ? 'Link' : 'span'"
                    :href="links.url"
                    v-html="makeLabel(links.label)"
                    class="border-x border-slate-50 w-12 h-12 grid place-items-center bg-white dark:bg-slate-900 dark:border-slate-800"
                    :class="{
                        'hover:bg-slate-300 dark:hover:bg-slate-500' : links.url,
                        'text-slate-300' : !links.url,
                        'font-bold bg-indigo-500 text-white dark:bg-indigo-500' : links.active
                    }"
                />
            </div>
        </div>
    </div>
</template>