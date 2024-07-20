<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import DeleteProjectForm from '@/Pages/Projects/Partials/DeleteProjectForm.vue';
import { diffForHumans, hasProjectPermission } from '@/utils';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid';
import { useTranslation } from 'i18next-vue';
import { computed } from 'vue';

const { t } = useTranslation();

const props = computed(
    () =>
        usePage<{
            project: { tokens: Array<{ id: string; int: string; abilities: Array<string> }> };
        }>().props,
);
</script>

<template>
    <Head title="Project Settings" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Settings</h2>
        </template>

        <div class="py-6">{{ t('project.token.list') }}</div>

        <ul role="list" class="divide-y divide-gray-100">
            <li v-for="token in props.project.tokens" :key="token.id" class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <!--                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="member.imageUrl" alt="" />-->
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            {{ token.name }}
                        </p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-x-6">
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">[{{ token.abilities.join(',') }}]</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            <time v-if="token.last_used_at" :datetime="token.last_used_at">
                                {{ t('project.token.last_used_at', { time: diffForHumans(token.last_used_at) }) }}
                            </time>
                            <span v-else>{{ t('project.token.never_used') }}</span>
                        </p>
                    </div>
                    <Menu as="div" class="relative flex-none">
                        <MenuButton class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900">
                            <span class="sr-only">Open options</span>
                            <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                        </MenuButton>
                        <transition
                            enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95"
                        >
                            <MenuItems
                                class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                            >
                                <MenuItem v-if="hasProjectPermission('project.token.delete')" v-slot="{ active }">
                                    <button
                                        type="button"
                                        :class="[
                                            active ? 'bg-gray-50' : '',
                                            'block px-3 py-1 text-sm leading-6 text-gray-900',
                                        ]"
                                    >
                                        {{ t('project.token.delete') }}
                                    </button>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </li>
        </ul>

        <DeleteProjectForm v-if="hasProjectPermission('project.delete')" />
    </ProjectLayout>
</template>
