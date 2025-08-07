<script setup></script>

<template>
    <button class="px-6
            py-2
            rounded-lg
            outline-1
            outline-slate-300
            hover:bg-slate-100
            active:bg-slate-200
            dark:outline-slate-500
            dark:text-slate-300
            dark:hover:bg-slate-700
            dark:active:bg-slate-600
            hover:cursor-pointer
            disabled:text-slate-300
            disabled:hover:bg-white
            dark:disabled:bg-slate-600
            hover:dark:disabled:bg-slate-600
            dark:disabled:text-slate-700
            dark:disabled:outline-slate-500
            disabled:cursor-default">
        <slot />
    </button>
</template>