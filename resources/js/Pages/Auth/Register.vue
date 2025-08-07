<script setup>
import {
    Container,
    ErrorMessages,
    InputField,
    PrimaryBtn,
    TextLink,
    Title,
} from '@components'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
})

const submit = () => {
    form.post(route('auth.register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation')
        }
    })
}

</script>

<template>

    <Head title="| Register" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <Title>Register a new account</Title>
            <p>
                Already have an account?
                <TextLink routeName="auth.login" label="Login" />
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="submit" class="space-y-6">
            <InputField label="Username" icon="id-badge" placeholder="Please enter username" v-model="form.name" />
            <InputField label="Email" icon="at" placeholder="Please enter email" v-model="form.email" />
            <InputField label="Password" icon="key" type="password" placeholder="Please enter password"
                v-model="form.password" />
            <InputField label="Confirm Password" icon="key" type="password" placeholder="Please confirm password"
                v-model="form.password_confirmation" />

            <p class="text-slate-500
                text-sm
                dark:text-slate-400">
                By creating an account, you agree to the our Terms of Service and Privacy Policy.
            </p>

            <PrimaryBtn :disabled="form.processing" class="w-full">
                Register
            </PrimaryBtn>
        </form>
    </Container>
</template>