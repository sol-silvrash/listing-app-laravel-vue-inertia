<script setup>
defineProps({
    href: {
        type: String,
        default: 'home',
    },
    payload: Object,
    label: String,
})
</script>

<template>
    <Link :href="route(href, payload)" class="px-2
                py-1
                rounded-md
                danger-bg
                text-slate-100
                text-sm
                shadow-lg
                font-bold
                flex
                items-center
                gap-3">
    {{ label }}
    <FontAwesomeIcon icon="fa-solid fa-xmark" class="text-xs"></FontAwesomeIcon>
    </Link>
</template>