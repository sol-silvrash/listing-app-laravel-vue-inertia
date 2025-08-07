<script setup>
defineProps({
    paginator: Object,
})

const makeLabel = (label) => {
    if (label.includes("Previous")) {
        return "<<"
    } else if (label.includes("Next")) {
        return ">>"
    } else {
        return label
    }
}
</script>

<template>
    <div class="flex
        justify-between
        items-start">
        <div class="flex
            items-center
            rounded-md
            overflow-hidden
            shadow-lg">
            <div v-for="(link, idx) in paginator.links" :key="idx">
                <component :is="link.url ? 'Link' : 'span'" :href="link.url" class="border-x
                    w-12
                    h-10
                    grid
                    place-items-center
                    bg-white
                    border-slate-50
                    dark:bg-slate-900
                    dark:border-slate-800" :class="{
                        'hover:bg-slate-300 dark:hover:bg-slate-500': link.url,
                        'text-slate-300 dark:text-slate-600': !link.url,
                        'font-bold text-indigo-500 dark:text-indigo-400': link.active,
                    }">
                    <FontAwesomeIcon icon="fa-solid fa-angle-double-left" v-if="link.label.includes('Previous')" />
                    <FontAwesomeIcon icon="fa-solid fa-angle-double-right" v-else-if="link.label.includes('Next')" />
                    <span v-else>{{ link.label }}</span>
                </component>
            </div>
        </div>

        <p class="text-slate-600
            dark:text-slate-400
            text-sm">
            Showing {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }} results
        </p>
    </div>
</template>