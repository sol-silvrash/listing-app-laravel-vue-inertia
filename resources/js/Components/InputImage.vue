<script setup>
import { ref } from 'vue'
import { Icon } from '@components'

const emit = defineEmits([
    'image'
])

const props = defineProps({
    listingImage: String,
})
const currentImage = props.listingImage ? `/storage/${props.listingImage}` : null

const preview = ref(currentImage)
const oversizedImage = ref(false)
const showUndoBtn = ref(false)
const fileInput = ref(null)

const imageSelected = (e) => {
    preview.value = URL.createObjectURL(e.target.files[0])
    oversizedImage.value = e.target.files[0].size > 3145728
    showUndoBtn.value = true
    emit('image', e.target.files[0])
}

const revertImageChange = () => {
    showUndoBtn.value = false
    preview.value = currentImage
    oversizedImage.value = false

    if (fileInput.value) {
        fileInput.value.value = ''
    }

    emit('image', null)
}
</script>

<template>
    <div>
        <span class="block
            text-sm
            font-medium
            text-slate-700
            dark:text-slate-300" :class="{
                '!text-red-600': oversizedImage,
                'dark:!text-red-400': oversizedImage
            }">
            {{ oversizedImage ? 'The selected image exceeds 3MB' : 'Image (Max size 3MB)' }}
        </span>

        <label for="image" class="block
            relative
            rounded-md
            mt-1
            bg-slate-300
            dark:bg-slate-700
            h-[178px]
            overflow-hidden
            cursor-pointer
            border-slate-300
            dark:border-slate-500
            border" :class="{
                '!border-red-900': oversizedImage,
                'dark:!border-red-500': oversizedImage,
            }">
            <img :src="preview ?? '/storage/images/listing/default.png'" class="object-cover
                object-center
                h-full
                w-full" alt="image" />

            <button v-if="showUndoBtn" @click.prevent="revertImageChange" type="button" class="absolute
                top-2
                right-2
                bg-white/50
                hover:bg-white/35
                active:bg-slate-200/35
                w-8
                h-8
                rounded-full
                grid
                place-items-center
                cursor-pointer
                text-slate-700">
                <Icon literal="rotate-left" />
            </button>
        </label>

        <input ref="fileInput" @input="imageSelected" type="file" name="image" id="image" hidden>
    </div>
</template>