<script setup>
import { useForm } from '@inertiajs/vue3';

const { user } = defineProps({
    user: Object,
})

const form = useForm({
    role: user.role,
})

const submit = () => {
    if (confirm(`Change this user's role to ${form.role}?`)) {
        form.put(route('admin.role', user.id))
    } else {
        form.role = user.role
    }
}

</script>

<template>
    <div class="flex
        items-center
        gap-2">
        <form @change="submit" class="flex
            items-center
            gap-2">
            <label for="roles" class="sr-only">Roles</label>
            <select v-model="form.role" name="roles" class="text-xs
                py-2
                rounded-lg
                outline-0
                outline-slate-400
                text-slate-800
                dark:text-slate-100
                bg-slate-200
                dark:bg-slate-800">
                <option value="admin">
                    Admin
                </option>
                <option value="general">
                    General
                </option>
                <option value="suspended">
                    Suspended
                </option>
            </select>
        </form>
    </div>
</template>