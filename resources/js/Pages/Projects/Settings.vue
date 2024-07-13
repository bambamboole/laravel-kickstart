<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import DeleteProjectForm from '@/Pages/Projects/Partials/DeleteProjectForm.vue';
import { hasProjectPermission } from '@/utils';
</script>

<template>
    <Head title="Project Settings" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Settings</h2>
        </template>

        <DeleteProjectForm v-if="hasProjectPermission('project.delete')" />
    </ProjectLayout>
</template>
