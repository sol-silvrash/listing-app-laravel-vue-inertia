<template>
    <button class="px-6
            py-2
            rounded-lg
            outline-1
            bg-red-700
            hover:bg-red-800
            active:bg-red-900
            text-white
            disabled:text-red-200
            disabled:bg-red-400
            disabled:outline-red-50
            dark:disabled:text-rose-200
            dark:disabled:bg-rose-300
            dark:disabled:outline-rose-50
            hover:cursor-pointer
            disabled:cursor-default">
        <slot />
    </button>
</template>