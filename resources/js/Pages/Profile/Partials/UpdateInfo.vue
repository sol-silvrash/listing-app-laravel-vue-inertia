<script setup>
import {
    Container,
    Title,
    InputField,
    PrimaryBtn,
    ErrorMessages,
    SessionMessages,
} from '@components'
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
    status: String,
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
})

const resendEmail = (e) => {
    router.post(
        route('verification.send'),
        {},
        {
            onStart: () => e.target.disabled = true,
            onFinish: () => e.target.disabled = false,
        },
    )
}
</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Information</Title>
            <p>
                Update your account's profile information and email address.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />
        <SessionMessages v-if="form.recentlySuccessful" status="Info successfully saved!" />

        <form @submit.prevent="form.patch(route('profile.info'))" class="space-y-6">
            <InputField v-model="form.name" label="Name" icon="id-badge" class="w-1/2"
                placeholder="Please enter Name" />
            <InputField v-model="form.email" label="Email" icon="at" class="w-1/2" placeholder="Please enter Email" />

            <div v-if="user.email_verified_at === null">
                <SessionMessages :status="status" />
                <div class="flex items-center gap-2 relative">
                    <p>Your Email address is unverified.</p>
                    <button @click="resendEmail" class="text-indigo-500
                    hover:text-indigo-600
                    font-medium
                    underline
                    dark:text-indigo-400
                    dark:hover:text-indigo-500
                    disabled:text-slate-300
                    dark:disabled:text-slate-600
                    cursor-pointer
                    disabled:cursor-default">
                        Click here to resend the verification email.
                    </button>
                </div>
            </div>

            <PrimaryBtn :disabled="form.processing" class="w-1/4">Save</PrimaryBtn>
        </form>
    </Container>
</template>