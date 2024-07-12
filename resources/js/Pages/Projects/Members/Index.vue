<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';

const project = usePage<{ project: { members: Array<{ email: string; name: string }> } }>().props.project;
</script>

<template>
    <Head title="Project Overview" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Members</h2>
        </template>

        <div class="py-12">members list</div>

        <ul role="list" class="divide-y divide-gray-100">
            <li v-for="person in project.members" :key="person.email" class="flex gap-x-4 py-5">
                <div class="min-w-0">
                    <p class="text-sm font-semibold leading-6 text-gray-900">
                        {{ person.name }} ({{ person.pivot.role.name }})
                    </p>
                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ person.email }}</p>
                </div>
            </li>
        </ul>
    </ProjectLayout>
</template>
