<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { useTranslation } from 'i18next-vue';
const { t } = useTranslation();
import { useToast, TYPE } from 'vue-toastification';
const toast = useToast();
window.Echo.channel(`orders.1`).listen('OrderShipmentStatusUpdated', (e) => {
    toast(`Order ${e.order.id} has been shipped!`);
});

const projects = usePage<{ projects: Array<{ uuid: string; name: string }> }>().props.projects;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl leading-tight text-gray-800" v-html="t('dashboard.title')"></h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <p>{{ t('projects.projectCount', { count: 4, test: 'foo' }) }}</p>
                <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                    <li
                        v-for="project in projects"
                        :key="project.id"
                        class="overflow-hidden rounded-xl border border-gray-200"
                    >
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                            <Link href="#" class="text-sm font-medium leading-6 text-gray-900"
                                >{{ project.name }} - {{ t('test.foo') }}
                            </Link>
                        </div>
                    </li>
                    <li class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                            <Link href="#" class="text-sm font-medium leading-6 text-gray-900"
                                >Create new Project
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
