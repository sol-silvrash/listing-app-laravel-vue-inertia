<script setup>
import {
    Container,
    Title,
    InputField,
    PrimaryBtn,
    ErrorMessages,
    SessionMessages,
} from '@components'
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.put(route('profile.password'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
    })
}

</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Update Password</Title>
            <p>
                Update your account's profile information and email address.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />
        <SessionMessages v-if="form.recentlySuccessful" status="Password Successfully Saved!" />

        <form @submit.prevent="submit" class="space-y-6">

            <InputField v-model="form.current_password" type="password" label="Current Password" icon="key"
                class="w-1/2" placeholder="Please enter Current Password" />

            <InputField v-model="form.password" type="password" label="New Password" icon="key" class="w-1/2"
                placeholder="Please enter New Password" />

            <InputField v-model="form.password_confirmation" type="password" label="Confirm New Password" icon="key"
                class="w-1/2" placeholder="Please Confirm New Password" />

            <PrimaryBtn :disabled="form.processing" class="w-1/4">Save</PrimaryBtn>
        </form>
    </Container>
</template>