<script setup>
import { router } from '@inertiajs/vue3'
import {
    Container,
    Icon,
} from '@components'

const { listing, user, canModify } = defineProps({
    listing: Object,
    user: Object,
    canModify: Boolean,
})

const deleteListing = () => {
    if (confirm("Are you sure?")) {
        router.delete(route('listing.destroy', listing.id))
    }
}

const toggleApprove = () => {
    let msg = listing.approved ? 'Disapprove this listing?' : 'Approve this listing?';
    if (confirm(msg)) {
        router.put(route('admin.approve', listing.id))
    }
}
</script>

<template>

    <Head title="| Listing Detail" />

    <!-- Admin -->
    <div v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'" class="mb-6
        p-6
        rounded-md
        font-medium
        flex
        items-center
        justify-between
        shadow-lg
        bg-white
        dark:bg-slate-800
        dark:text-white">
        <p>
            This listing is
            <span class="ms-2" :class="listing.approved
                ? 'text-green-600 dark:text-green-300'
                : 'text-red-600 dark:text-red-300'">
                <Icon :literal="listing.approved ? 'circle-check' : 'circle-xmark'" />
                {{ listing.approved ? "Approved" : "Disapproved" }}
            </span>
        </p>
        <button @click.prevent="toggleApprove" class="px-3
        py-1
        rounded-md
        cursor-pointer
        text-white" :class="listing.approved ? 'danger-bg' : 'success-bg'">
            <Icon :literal="listing.approved ? 'thumbs-down' : 'thumbs-up'" class="me-2" />
            {{ listing.approved ? 'Disapprove' : 'Approve' }}
        </button>
    </div>

    <Container class="flex gap-10">
        <div class="w-1/4
            rounded-md
            overflow-hidden">
            <img :src="listing.image ? `/storage/${listing.image}` : '/storage/images/listing/default.png'" class="w-full
                h-full
                object-cover
                object-center" />
        </div>
        <div class="w-3/4">
            <!-- Listing Info -->
            <div class="mb-10">
                <div class="flex
                    items-end
                    justify-between
                    mb-2">
                    <p class="text-slate-800
                        dark:text-slate-300
                        w-full
                        border-b
                        pb-2
                        font-bold">
                        Listing Detail
                    </p>

                    <!-- Edit and Delete Buttons -->
                    <div v-if="canModify" class="pl-4
                        flex
                        items-center
                        gap-2">
                        <Link :href="route('listing.edit', listing.id)" class="rounded-md
                            text-white
                            text-sm
                            font-bold
                            px-5
                            py-1
                            w-30
                            success-bg">
                        <Icon literal="pen-to-square" class="me-2" />
                        Edit
                        </Link>
                        <button type="button" @click="deleteListing" class="rounded-md
                            text-white
                            text-sm
                            font-bold
                            px-5
                            py-1
                            w-30
                            cursor-pointer
                            danger-bg">
                            <Icon literal="trash" class="me-2" />
                            Delete
                        </button>
                    </div>
                </div>

                <h3 class="font-bold
                    text-2xl
                    mb-4">
                    {{ listing.title }}
                </h3>
                <p>{{ listing.desc }}</p>
            </div>
            <!-- Listing Info -->
            <div class="mb-10 text-sm">
                <p class="text-slate-800
                        dark:text-slate-300
                        w-full
                        border-b
                        pb-2
                        font-bold
                        mb-2">
                    Contact Info
                </p>

                <!-- Email -->
                <div v-if="listing.email" class="flex
                    items-center
                    mb-2
                    gap-2">
                    <Icon literal="at" />
                    <p>Email: </p>
                    <a :href="`mailto:${listing.email}`" class="text-link">{{ listing.email }}</a>
                </div>

                <!-- Link -->
                <div v-if="listing.link" class="flex
                    items-center
                    mb-2
                    gap-2">
                    <Icon literal="up-right-from-square" />
                    <p>External Link: </p>
                    <a :href="listing.link" target="_blank" class="text-link">{{ listing.link }}</a>
                </div>

                <!-- User -->
                <div class="flex
                        items-center
                        mb-10
                        gap-2">
                    <Icon literal="user" />
                    <p>Listed By: </p>
                    <Link :href="route('home', { user_id: user.id })" class="text-link">{{ user.name }}</Link>
                </div>

                <!-- Tags -->
                <div v-if="listing.tags" class="mb-10">
                    <p class="text-slate-800
                        dark:text-slate-300
                        w-full
                        border-b
                        pb-2
                        font-bold
                        mb-4">
                        Tags
                    </p>

                    <div class="flex
                        items-center
                        gap-3">
                        <div v-for="tag in listing.tags.split(',')" :key="tag">
                            <Link :href="route('home', { tag })" class="text-white
                                text-sm
                                px-3
                                py-1
                                min-w-10
                                rounded-full
                                bg-slate-500
                                hover:bg-slate-600
                                active:bg-slate-800
                                dark:bg-slate-600
                                dark:hover:bg-slate-700
                                dark:active:bg-slate-900">
                            {{ tag }}
                            </Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </Container>
</template>