<script setup>
import { truncate } from '../str';
import { Link, router } from '@inertiajs/vue3';

const params = route().params

defineProps({
    listing: Object,
})

const selectUser = (id) => {
    router.get(route('home'), {
        user_id: id,
        search: params.search,
        tag: params.tag,
    })
}

const selectTag = (tag) => {
    router.get(route('home'), {
        user_id: params.user_id,
        search: params.search,
        tag: tag,
    })
}
</script>

<template>
    <div class="bg-white
        rounded-lg
        shadow-lg
        overflow-hidden
        border
        border-slate-300
        dark:border-slate-600
        dark:bg-slate-800
        h-full
        flex
        flex-col
        justify-between">
        <div>
            <!-- image -->
            <Link :href="route('listing.show', listing.id)">
            <img :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listing/default.png'" class="w-full
                h-48
                bg-slate-300
                object-cover
                object-center" src="" alt="">
            </Link>

            <!-- title & user -->
            <div class="p-4">
                <h3 class="font-bold
                    text-xl
                    mb-2">
                    {{ truncate(listing.title, 40) }}
                </h3>

                <p>Listed on {{ new Date(listing.created_at).toLocaleDateString() }} by
                    <button class="text-link" @click="selectUser(listing.user.id)">
                        {{ listing.user.name }}
                    </button>
                </p>
            </div>
        </div>
        <div v-if="listing.tags" class="flex
            items-center
            gap-3
            px-4
            pb-4">

            <!-- tags -->
            <div v-for="tag in listing.tags.split(',')" :key="tag">
                <button class="text-white
                    text-sm
                    px-3
                    py-1
                    min-w-10
                    rounded-full
                    cursor-pointer
                    bg-slate-500
                    hover:bg-slate-600
                    active:bg-slate-800
                    dark:bg-slate-600
                    dark:hover:bg-slate-700
                    dark:active:bg-slate-900" @click="selectTag(tag)">
                    {{ tag }}
                </button>
            </div>
        </div>
    </div>
</template>