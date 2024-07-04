<script setup lang="ts">
defineProps<{
    mode: string;
}>();
</script>

<template>
    <button
        :class="{ 'bg-red-600': mode === 'danger', 'bg-blue-600': mode === '' }"
        class="inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
    >
        <slot />
    </button>
</template>
