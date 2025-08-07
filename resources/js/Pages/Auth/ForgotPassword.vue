<script setup>
import {
    Container,
    ErrorMessages,
    InputField,
    PrimaryBtn,
    SessionMessages,
} from '@components'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email: "",
})

const submit = () => {
    form.post(route('password.email'))
}

defineProps({
    status: String,
})

</script>

<template>

    <Head title=" | Forgot Password" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p>
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link
                that will allow you to choose a new one.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <SessionMessages :status="status" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField label="Email" icon="at" placeholder="Please enter email" v-model="form.email" />
            <PrimaryBtn :disabled="form.processing" class="w-full">
                Send Password Reset Link
            </PrimaryBtn>
        </form>
    </Container>
</template>