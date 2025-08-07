<script setup>
import {
    PaginationLink,
    Icon,
    RoleSelector,
    SessionMessages,
    InputField,
    FilterRemoveLink,
} from '@components'
import { router, useForm } from '@inertiajs/vue3'

const params = route().params

defineProps({
    users: Object,
    status: String,
})

const form = useForm({
    search: params.search,
})

const search = () => {
    router.get(route('admin.index'), {
        search: form.search,
        user_role: params.user_role,
    })
}

const toggleRole = (e) => {
    router.get(
        route('admin.index', {
            search: params.search,
            user_role: e.target.checked ? 'suspended' : null
        })
    )
}

</script>

<template>

    <Head title="| Admin" />

    <SessionMessages :status="status" />

    <!-- Heading -->
    <div class="flex
        items-center
        justify-between
        mb-4">
        <div class="flex
            items-center
            gap-2">
            <FilterRemoveLink href="admin.index" v-if="params.search" :label="params.search"
                :payload="{ ...params, search: null, page: null }" />
        </div>

        <div class="w-1/4">
            <form @submit.prevent="search">
                <InputField type="search" label="" icon="magnifying-glass" placeholder="Search..."
                    v-model="form.search" />
            </form>
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
            <input @input="toggleRole" :checked="params.user_role" type="checkbox" id="toggleRole" class="rounded-md
                cursor-pointer
                text-indigo-500
                ring-indigo-500
                border-slate-700" />
            <label for="toggleRole" class="cursor-pointer">
                Show suspended users
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
                <th class="w-6/12 p-5">Name</th>
                <th class="w-4/12 p-5">Role</th>
                <th class="w-2/12 p-5" colspan="2">Listings</th>
            </tr>
        </thead>

        <tbody class="divide-y
            divide-slate-300
            divide-dashed">
            <tr v-for="user in users.data" :key="user.id">
                <td class="w-6/12 py-5 px-5">
                    <p class="font-bold mb-1">{{ user.name }}</p>
                    <p class="font-light text-xs">{{ user.email }}</p>
                </td>
                <td class="w-4/12 py-5 px-5">
                    <RoleSelector :user="user" />
                </td>
                <td class="w-2/12 py-5 px-5">
                    <div class="flex items-center gap-3">
                        <div class="flex
                            items-center 
                            gap-2 
                            text-xs 
                            p-2 
                            outline 
                            rounded-md
                            text-green-600
                            dark:text-green-400">
                            <Icon literal="circle-check" />
                            <span>{{user.listings.filter(i => i.approved).length}}</span>
                        </div>
                        <div class="flex
                        items-center 
                            gap-2 
                            text-xs 
                            p-2 
                            outline 
                            rounded-md
                            text-amber-600
                            dark:text-amber-400">
                            <Icon literal="circle-exclamation" />
                            <span>{{user.listings.filter(i => !i.approved).length}}</span>
                        </div>
                    </div>
                </td>
                <td class="w-2/12 py-5 px-5">
                    <Link :href="route('user.show', user.id)">
                    <button class="cursor-pointer
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
                        <Icon literal="up-right-from-square" />
                    </button>
                    </Link>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6">
        <PaginationLink :paginator="users" />
    </div>
</template>