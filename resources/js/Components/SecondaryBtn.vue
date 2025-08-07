<script setup></script>

<template>
    <button class="px-6
            py-2
            rounded-lg
            outline-1
            text-white
            outline-slate-300
            bg-slate-800
            hover:bg-slate-700
            active:bg-slate-900
            disabled:bg-slate-300
            disabled:text-slate-100
            dark:outline-slate-900
            dark:text-slate-900
            dark:bg-slate-200
            dark:hover:bg-slate-300
            dark:active:bg-slate-400
            dark:disabled:bg-slate-600
            dark:disabled:text-slate-700
            dark:disabled:outline-slate-500
            dark:disabled:hover:bg-slate-600
            hover:cursor-pointer
            disabled:cursor-default">
        <slot />
    </button>
</template>