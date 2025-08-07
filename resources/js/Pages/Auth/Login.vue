<script setup>
import {
    Container,
    ErrorMessages,
    InputCheck,
    InputField,
    PrimaryBtn,
    TextLink,
    Title,
    SessionMessages,
} from '@components'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email: "",
    password: "",
    remember: null,
})

defineProps({
    status: String,
})

const submit = () => {
    form.post(route('auth.login'), {
        onFinish: () => {
            form.reset('password')
        }
    })
}

</script>

<template>

    <Head title=" | Login" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Login to your account</Title>
            <p>
                Need an account?
                <TextLink routeName="auth.register" label="Register" />
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />
        <SessionMessages :status="status" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField label="Email" icon="at" placeholder="Please enter email" v-model="form.email" />
            <InputField label="Password" icon="key" type="password" placeholder="Please enter password"
                v-model="form.password" />

            <div class="flex
                items-center
                justify-between">

                <InputCheck name="remember" v-model="form.remember">Remember Me</InputCheck>
                <TextLink routeName="password.request" label="Forgot Password?" />
            </div>

            <PrimaryBtn :disabled="form.processing" class="w-full">
                Login
            </PrimaryBtn>
        </form>
    </Container>
</template>