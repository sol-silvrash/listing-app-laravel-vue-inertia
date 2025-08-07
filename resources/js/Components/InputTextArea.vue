<script setup>
const model = defineModel()
defineProps({
    label: String,
    icon: String,
    placeholder: {
        type: String,
        default: "",
    }
})
</script>

<template>
    <div class="space-y-1">
        <label :for="label" class="block 
                text-sm
                font-medium
                text-slate-700
                dark:text-slate-300">
            {{ label }}
        </label>

        <div class="relative mt-1 rounded-md">
            <div class="pointer-events-none
                    absolute
                    top-3
                    left-0
                    flex
                    items-center
                    pl-3">
                <span class="grid
                        place-content-center
                        text-sm
                        text-slate-400">
                    <FontAwesomeIcon :icon="`fa-solid fa-${icon}`" />
                </span>
            </div>
            <textarea rows="8" :name="label" :id="label" :placeholder="placeholder" v-model="model" class="block 
                        w-full 
                        rounded-md 
                        pr-3 
                        pl-9 
                        py-2
                        border
                        text-sm 
                        dark:text-slate-400 
                        border-slate-300
                        outline-0
                        focus:ring-1
                        focus:ring-inset
                        dark:bg-slate-700
                        dark:border-slate-500
                        focus:ring-indigo-400
                        focus:border-indigo-400
                        placeholder:text-slate-400">
                <slot/>
            </textarea>
        </div>
    </div>
</template>