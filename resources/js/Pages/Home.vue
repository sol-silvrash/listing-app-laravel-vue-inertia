<script setup>
import {
    Card,
    PaginationLink,
    SearchField,
} from '@components'

const props = defineProps({
    listings: Object,
    searchTerm: String,
})
</script>

<template>

    <Head title="| Latest Listings" />

    <SearchField :listings="listings" :searchTerm="searchTerm" />

    <div v-if="Object.keys(listings.data).length">
        <div class="grid
            grid-cols-3
            gap-4">
            <div v-for="listing in listings.data" :key="listing.id">
                <Card :listing="listing" />
            </div>
        </div>

        <div class="mt-3">
            <PaginationLink :paginator="listings" />
        </div>
    </div>

    <div v-else>
        There are no listings
    </div>
</template>