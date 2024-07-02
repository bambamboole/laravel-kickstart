<script setup lang="ts">
import { onUnmounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { useToast, TYPE } from 'vue-toastification';
const toast = useToast();

const page = usePage();

let finish = router.on('finish', () => {
    for (const [key, value] of Object.entries(page.props.flash)) {
        if (value === null) {
            continue;
        }
        toast(value, {
            type: key as TYPE,
        });
    }
});

onUnmounted(() => finish());
</script>

<template></template>
