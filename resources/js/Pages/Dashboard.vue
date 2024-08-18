<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { useToast } from 'vue-toastification';
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Content from '@/Components/ui/content/Content.vue';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog';

const toast = useToast();
window.Echo.channel(`orders.1`).listen('OrderShipmentStatusUpdated', (e: any) => {
    toast(`Order ${e.order.id} has been shipped!`);
});
const projectForm = useForm({
    name: '',
});
const creatingNewProject = ref(false);

const createProject = () => {
    projectForm.post(route('project.create'), {
        preserveScroll: true,
        onSuccess: () => {
            creatingNewProject.value = false;
            projectForm.reset();
        },
        onFinish: () => {
            projectForm.reset();
        },
    });
};

const projects = usePage<{ projects: Array<{ uuid: string; name: string }> }>().props.projects;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl leading-tight text-gray-800" v-html="$t('dashboard.title')"></h2>
        </template>

        <Content>
            <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                <li
                    v-for="project in projects"
                    :key="project.id"
                    class="overflow-hidden rounded-xl border border-gray-200"
                >
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                        <Link
                            :href="route('project.overview', { project: project.uuid })"
                            class="text-sm font-medium leading-6 text-gray-900"
                            >{{ project.name }}
                        </Link>
                    </div>
                </li>
                <li class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                        <Dialog v-model:open="creatingNewProject">
                            <DialogTrigger as-child>
                                <button class="text-sm font-medium leading-6 text-gray-900">
                                    {{ $t('dashboard.project.new') }}
                                </button>
                            </DialogTrigger>
                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>
                                        {{ $t('dashboard.createProjectModal.title') }}
                                    </DialogTitle>
                                    <DialogDescription>
                                        {{ $t('dashboard.createProjectModal.description') }}
                                    </DialogDescription>
                                </DialogHeader>
                                <div class="mt-6">
                                    <InputLabel
                                        for="name"
                                        :value="$t('dashboard.createProjectModal.form.name.label')"
                                        class="sr-only"
                                    />

                                    <TextInput
                                        id="name"
                                        v-model="projectForm.name"
                                        type="text"
                                        class="mt-1 block w-3/4"
                                        :placeholder="$t('dashboard.createProjectModal.form.name.placeholder')"
                                    />

                                    <InputError :message="projectForm.errors.name" class="mt-2" />
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <DialogClose as-child>
                                        <Button variant="secondary">
                                            {{ $t('dashboard.createProjectModal.cancel') }}
                                        </Button>
                                    </DialogClose>
                                    <Button
                                        class="ms-3"
                                        :class="{ 'opacity-25': projectForm.processing }"
                                        :disabled="projectForm.processing"
                                        @click="createProject"
                                        >Create
                                    </Button>
                                </div>
                            </DialogContent>
                        </Dialog>
                    </div>
                </li>
            </ul>
        </Content>
    </AuthenticatedLayout>
</template>
