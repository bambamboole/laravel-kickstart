<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
</script>

<template>
    <Head title="Project Overview" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Overview</h2>
        </template>

        <div class="py-12">Hello world!</div>
    </ProjectLayout>
</template>
