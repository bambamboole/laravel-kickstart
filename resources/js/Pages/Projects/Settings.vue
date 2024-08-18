<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import DeleteProjectForm from '@/Pages/Projects/Partials/DeleteProjectForm.vue';
import { diffForHumans, hasAnyProjectPermission, hasProjectPermission } from '@/utils';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid';
import { useTranslation } from 'i18next-vue';
import { computed, ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import { Dialog, DialogClose, DialogContent, DialogTrigger } from '@/Components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from '@/Components/ui/dropdown-menu';

const { t } = useTranslation();
const props = computed(
    () =>
        usePage<{
            project: { tokens: Array<{ id: string; int: string; abilities: Array<string> }> };
        }>().props,
);
const createApiTokenForm = useForm({
    name: '',
    abilities: [],
});
const creatingApiToken = ref(false);

const createApiToken = () => {
    createApiTokenForm.post(route('project.api-tokens.create', props.value.project), {
        preserveScroll: true,
        onSuccess: () => {
            creatingApiToken.value = false;
            createApiTokenForm.reset();
        },
    });
};

const deleteApiToken = (id: string) => {
    const form = useForm({});
    form.delete(route('project.api-tokens.delete', { project: props.value.project.uuid, tokenId: id }), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head :title="t('project.settings.title')" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ t('project.settings.header') }}</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <div class="flex justify-between pb-6">

                            <CardTitle>
                                {{ t('project.token.list') }}
                            </CardTitle>
                            <Dialog v-if="hasProjectPermission('project.api-tokens.create')"
                                    v-model:open="creatingApiToken">
                                <DialogTrigger as-child>
                                    <Button type="button">
                                        {{ t('project.settings.createApiTokenModal.button') }}
                                    </Button>
                                </DialogTrigger>
                                <DialogContent>
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ t('project.settings.createApiTokenModal.title') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600">
                                            {{ t('project.settings.createApiTokenModal.description') }}
                                        </p>

                                        <div class="mt-6">
                                            <InputLabel
                                                for="name"
                                                :value="t('project.settings.createApiTokenModal.form.name.label')"
                                                class="sr-only"
                                            />

                                            <TextInput
                                                id="name"
                                                v-model="createApiTokenForm.name"
                                                type="text"
                                                class="mt-1 block w-3/4"
                                                :placeholder="t('project.settings.createApiTokenModal.form.name.placeholder')"
                                            />

                                            <InputError :message="createApiTokenForm.errors.name" class="mt-2" />
                                        </div>

                                        <div class="mt-6">
                                            <InputLabel
                                                for="role"
                                                class="pb-6"
                                                :value="t('project.settings.createApiTokenModal.form.abilities.label')"
                                            />

                                            <fieldset aria-label="Role">
                                                <div class="space-y-5">
                                                    <div
                                                        v-for="ability in props.abilities"
                                                        :key="ability"
                                                        class="relative flex items-start"
                                                    >
                                                        <div class="flex h-6 items-center">
                                                            <input
                                                                :id="ability"
                                                                :aria-describedby="`${ability}-description`"
                                                                name="ability"
                                                                type="checkbox"
                                                                :value="ability"
                                                                v-model="createApiTokenForm.abilities"
                                                                class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                            />
                                                        </div>
                                                        <div class="ml-3 text-sm leading-6">
                                                            <label :for="ability" class="font-medium text-gray-900">
                                                                {{
                                                                    t(`project.token.ability.${ability}.description`) +
                                                                    ` (${ability})`
                                                                }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <InputError :message="createApiTokenForm.errors.abilities" class="mt-2" />
                                        </div>

                                        <div class="mt-6 flex justify-end">
                                            <DialogClose as-child>
                                                <Button variant="secondary">
                                                    {{ t('project.settings.createApiTokenModal.cancel') }}
                                                </Button>
                                            </DialogClose>
                                            <Button
                                                class="ms-3"
                                                :class="{ 'opacity-25': createApiTokenForm.processing }"
                                                :disabled="createApiTokenForm.processing"
                                                @click="createApiToken"
                                            >Create
                                            </Button>
                                        </div>
                                    </div>
                                </DialogContent>
                            </Dialog>
                        </div>
                        <CardContent>
                            <ul role="list" class="divide-y divide-gray-100">
                                <li
                                    v-for="token in props.project.tokens"
                                    :key="token.id"
                                    class="flex justify-between gap-x-6 py-5"
                                >
                                    <div class="flex min-w-0 gap-x-4">
                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                {{ token.name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex shrink-0 items-center gap-x-6">
                                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                                            <p class="text-sm leading-6 text-gray-900">
                                                [ {{ token.abilities.join(', ') }} ]
                                            </p>
                                            <p class="mt-1 text-xs leading-5 text-gray-500">
                                                <time v-if="token.last_used_at" :datetime="token.last_used_at">
                                                    {{
                                                        t('project.token.last_used_at', {
                                                            time: diffForHumans(token.last_used_at),
                                                        })
                                                    }}
                                                </time>
                                                <span v-else>{{ t('project.token.never_used') }}</span>
                                            </p>
                                        </div>
                                        <DropdownMenu v-if="hasAnyProjectPermission(['project.api-tokens.delete'])">
                                            <DropdownMenuTrigger>
                                                <span class="sr-only">Open options</span>
                                                <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent>
                                                <DropdownMenuItem>
                                                    <Button variant="link" @click="deleteApiToken(token.id)">
                                                        {{ t('project.token.delete') }}
                                                    </Button>
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </div>
                                </li>
                            </ul>
                        </CardContent>
                    </CardHeader>
                </Card>

                <DeleteProjectForm v-if="hasProjectPermission('project.delete')" />
            </div>
        </div>
    </ProjectLayout>
</template>
