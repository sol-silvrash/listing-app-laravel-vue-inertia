<script setup>
import { computed, ref } from 'vue'
import {
    Icon,
    NavLink
} from '@components'
import { themeSwitch } from '../theme'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)

const show = ref(false)
</script>

<template>
    <div v-show="show" @click="show = false" class="fixed
        inset-0
        z-40"></div>

    <header class="bg-slate-800 text-white">
        <nav class="p-6
                    mx-auto 
                    max-w-screen-lg
                    flex
                    items-center
                    justify-between">
            <NavLink routeName="home" componentName="Home">Home</NavLink>
            <div class="flex items-center space-x-6">
                <div v-if="user" class="relative
                    flex
                    items-center
                    gap-4">

                    <div @click="show = !show" :class="{ 'bg-slate-700': show }" class="flex
                                items-center
                                gap-2
                                px-3
                                py-2
                                rounded-lg
                                hover:bg-slate-700
                                cursor-pointer">
                        <p>{{ user.name }}</p>
                        <FontAwesomeIcon icon="fa-solid fa-angle-down" />
                    </div>

                    <Link v-if="user.role === 'admin'" :href="route('admin.index')">
                    <button class="cursor-pointer
                                    w-6
                                    h-6
                                    me-1
                                    rounded-full
                                    hover:outline-1
                                    hover:bg-slate-700
                                    active:bg-slate-800">
                        <Icon literal="lock" />
                    </button>
                    </Link>

                    <div v-show="show" @click="show = false" class="absolute
                                z-50
                                top-12
                                right-0
                                bg-slate-800
                                text-white
                                rounded-lg
                                border-slate-300
                                dark:border-slate-600
                                border
                                overflow-hidden
                                w-50">
                        <Link :href="route('dashboard')" class="block
                            w-full
                            px-6
                            py-3
                            hover:bg-slate-700
                            text-left">
                        <div class="flex items-center space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-gauge" />
                            <span>
                                Dashboard
                            </span>
                        </div>
                        </Link>

                        <Link :href="route('listing.create')" class="block
                            w-full
                            px-6
                            py-3
                            hover:bg-slate-700
                            text-left">
                        <div class="flex items-center space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-folder-plus" />
                            <span>
                                New Listing
                            </span>
                        </div>
                        </Link>

                        <Link :href="route('profile.edit')" class="block
                            w-full
                            px-6
                            py-3
                            hover:bg-slate-700
                            text-left">
                        <div class="flex items-center space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-user-edit" />
                            <span>
                                Profile
                            </span>
                        </div>
                        </Link>

                        <Link as="button" :href="route('auth.logout')" method="delete" class="block
                            w-full
                            px-6
                            py-3
                            hover:bg-slate-700
                            text-left
                            cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <FontAwesomeIcon icon="fa-solid fa-sign-out" />
                            <span>
                                Logout
                            </span>
                        </div>
                        </Link>
                    </div>
                </div>
                <div v-else class="space-x-2">
                    <NavLink routeName="auth.login" componentName="Auth/Login">Login</NavLink>
                    <NavLink routeName="auth.register" componentName="Auth/Register">Register</NavLink>
                </div>
                <button @click="themeSwitch" class="hover:bg-slate-700
                    w-6
                    h-6
                    place-items-center
                    rounded-full
                    hover:outline-1
                    hover:outline-white
                    hover:cursor-pointer">
                    <span class="dark:hidden inline-block">
                        <FontAwesomeIcon icon="fa-solid fa-moon" />
                    </span>
                    <span class="hidden dark:inline-block">
                        <FontAwesomeIcon icon="fa-solid fa-sun" />
                    </span>
                </button>
            </div>
        </nav>
    </header>

    <main class="p-6 mx-auto max-w-screen-lg">
        <slot />
    </main>
</template>