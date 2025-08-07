<script setup>
defineProps({
    literal: String,
})
</script>

<template>
    <FontAwesomeIcon :icon="'fa-solid fa-' + literal" />
</template>