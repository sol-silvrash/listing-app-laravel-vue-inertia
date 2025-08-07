<script setup>
import { InputField, FilterRemoveLink } from '@components'
import { router, useForm } from '@inertiajs/vue3';

const params = route().params

const props = defineProps({
    listings: Object,
    searchTerm: String,
})

const username = params.user_id ? props.listings.data.find(i => i.user_id === Number(params.user_id)).user.name : null

const form = useForm({
    search: props.searchTerm,
})

const search = () => {
    router.get(route('home'), {
        search: form.search,
        user_id: params.user_id,
        tag: params.tag,
    })
}
</script>

<template>
    <div class="flex
        items-center
        justify-between
        mb-4">
        <div class="flex
            items-center
            gap-2">
            <FilterRemoveLink v-if="params.tag" :label="params.tag" :payload="{ ...params, tag: null, page: null }" />
            <FilterRemoveLink v-if="params.search" :label="params.search"
                :payload="{ ...params, search: null, page: null }" />
            <FilterRemoveLink v-if="params.user_id" :label="username"
                :payload="{ ...params, user_id: null, page: null }" />
        </div>

        <div class="w-1/4">
            <form @submit.prevent="search">
                <InputField type="search" label="" icon="magnifying-glass" placeholder="Search..."
                    v-model="form.search" />
            </form>
        </div>
    </div>
</template>