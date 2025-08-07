<script setup>

import {
    Container,
    ErrorMessages,
    InputField,
    PrimaryBtn,
    Title,
} from '@components'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    token: String,
    email: String,
})

const form = useForm({
    token: props.token,
    email: props.email,
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation')
        }
    })
}

</script>

<template>

    <Head title="| Reset Password" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Enter your new password</Title>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField label="Email" icon="at" placeholder="Please enter email" v-model="form.email" />
            <InputField label="Password" icon="key" type="password" placeholder="Please enter password"
                v-model="form.password" />
            <InputField label="Confirm Password" icon="key" type="password" placeholder="Please confirm password"
                v-model="form.password_confirmation" />

            <PrimaryBtn :disabled="form.processing" class="w-full">
                Reset Password
            </PrimaryBtn>
        </form>
    </Container>
</template>