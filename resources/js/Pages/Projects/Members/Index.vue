<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import { useTranslation } from 'i18next-vue';

const { t } = useTranslation();
const project = usePage<{ project: { members: Array<{ email: string; name: string }> } }>().props.project;
</script>

<template>
    <Head :title="t('project.members.index.title')" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ t('project.members.index.header') }}</h2>
        </template>

        <div class="py-12">{{ t('project.members.index.description') }}</div>

        <ul role="list" class="divide-y divide-gray-100">
            <li v-for="member in project.members" :key="member.email" class="flex gap-x-4 py-5">
                <div class="min-w-0">
                    <p class="text-sm font-semibold leading-6 text-gray-900">
                        {{ member.name }} ({{ member.role.name }})
                    </p>
                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ member.email }}</p>
                </div>
            </li>
        </ul>
    </ProjectLayout>
</template>
