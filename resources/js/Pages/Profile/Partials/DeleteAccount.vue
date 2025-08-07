<script setup>
import {
    Container,
    Title,
    InputField,
    SecondaryBtn,
    DangerBtn,
    ErrorMessages,
    SessionMessages,
} from '@components'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const showConfirmPassword = ref(false)

const form = useForm({
    password: '',
})

const submit = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
    })
}

</script>

<template>
    <Container class="mb-6">
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>
                Once your account is deleted, all of its resources data will be permanently deleted.
                This action cannot be undone.
            </p>
        </div>

        <ErrorMessages :errors="form.errors" />
        <SessionMessages v-if="form.recentlySuccessful" status="Password Successfully Saved!" />

        <div v-if="showConfirmPassword">
            <form @submit.prevent="submit" class="space-y-6">

                <InputField v-model="form.password" type="password" label="Confirm Password" icon="key" class="w-1/2"
                    placeholder="Please enter Current Password" />
                <div class="space-x-5">
                    <DangerBtn :disabled="form.processing" class="w-1/4">Confirm Delete</DangerBtn>
                    <SecondaryBtn @click="showConfirmPassword = false" :disabled="form.processing" class="w-1/8">
                        Cancel
                    </SecondaryBtn>
                </div>
            </form>
        </div>
        <div v-if="!showConfirmPassword" class="flex flex-col items-center">
            <DangerBtn @click="showConfirmPassword = true" class="w-1/2 ">
                <FontAwesomeIcon icon="fas-solid fa-triangle-exclamation" />
                Delete Account
            </DangerBtn>
        </div>
    </Container>
</template>