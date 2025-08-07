<script setup>
import {
    Title,
    Icon,
    FilterRemoveLink,
    InputField,
    PaginationLink,
    SessionMessages,
} from '@components'
import { router, useForm } from '@inertiajs/vue3'

const { user, listings, status } = defineProps({
    user: Object,
    listings: Object,
    status: String,
})

const params = route().params
const form = useForm({
    search: params.search,
})

const search = () => {
    router.get(route('user.show', {
        user: user.id,
        search: form.search,
        disapproved: params.disapproved,
    }))
}

const showDisapproved = (e) => {
    router.get(
        route('user.show', {
            user: user.id,
            search: params.search,
            disapproved: e.target.checked ? true : undefined,
        })
    )
}

const toggleApprove = (listing) => {
    let msg = listing.approved ? 'Disapprove this listing?' : 'Approve this listing?';
    if (confirm(msg)) {
        router.put(route('admin.approve', listing.id))
    }
}

</script>

<template>

    <Head :title="`| ${user.name} Listings`" />

    <SessionMessages :status="status" />

    <!-- Heading -->
    <div class="mb-4">
        <Title>{{ user.name }} Latest Listings</Title>

        <div class="flex
        items-center
        justify-between
        mb-4">
            <div class="flex
            items-center
            gap-2">
                <FilterRemoveLink href="user.show" v-if="params.search" :label="params.search"
                    :payload="{ ...params, search: null, page: null, user: user.id }" />
            </div>

            <div class="w-1/4">
                <form @submit.prevent="search">
                    <InputField type="search" label="" icon="magnifying-glass" placeholder="Search..."
                        v-model="form.search" />
                </form>
            </div>
        </div>
    </div>

    <!-- Toggle Role Button -->
    <div class="flex
        justify-end
        items-center
        mb-2">
        <div class="flex 
            gap-2
            text-xs
            px-2
            py-1
            rounded-md
            hover:bg-slate-300
            dark:hover:bg-slate-800">
            <input @input="showDisapproved" :checked="params.disapproved" type="checkbox" id="showDisapproved" class="rounded-md
                cursor-pointer
                text-indigo-500
                ring-indigo-500
                border-slate-700" />
            <label for="showDisapproved" class="cursor-pointer">
                Show disapproved listings
            </label>
        </div>
    </div>

    <!-- Table -->
    <table class="bg-white
        dark:bg-slate-800
        w-full
        rounded-lg
        overflow-hidden
        ring-1
        ring-slate-300">
        <thead>
            <tr class="bg-slate-600
                text-slate-300
                uppercase
                text-xs
                text-left">
                <th class="w-10/12 p-5">Title</th>
                <th class="w-2/12 p-5" colspan="2">Approved</th>
            </tr>
        </thead>

        <tbody class="divide-y
        divide-slate-300
        divide-dashed">
            <tr v-for="listing in listings.data" :key="listing.id">
                <td class="w-10/12 p-5">
                    {{ listing.title }}
                </td>
                <td class="w-1/12 p-5">
                    <Icon :literal="listing.approved ? 'circle-check' : 'circle-xmark'" :class="listing.approved
                        ? 'text-green-600 dark:text-green-400'
                        : 'text-red-600 dark:text-red-400'" class="px-5" />
                </td>
                <td class="w-1/12 p-5">
                    <Link :href="route('listing.show', listing.id)">
                    <button @click.prevent="toggleApprove(listing)" class="cursor-pointer
                        w-6
                        h-6
                        me-1
                        rounded-full
                        hover:outline-1
                        text-indigo-600
                        dark:text-indigo-300
                        hover:bg-slate-200
                        active:bg-slate-300
                        dark:hover:bg-slate-700
                        dark:active:bg-slate-800
                        disabled:cursor-default
                        disabled:outline-0
                        disabled:text-slate-300
                        disabled:hover:bg-slate-100
                        disabled:active:bg-slate-100
                        disabled:dark:text-slate-500
                        disabled:dark:hover:bg-slate-600
                        disabled:dark:active:bg-slate-600">
                        <Icon :literal="listing.approved ? 'thumbs-down' : 'thumbs-up'" />
                    </button>
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <PaginationLink :paginator="listings" />
    </div>
</template>