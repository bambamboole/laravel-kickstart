<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import { useTranslation } from 'i18next-vue';
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { t } = useTranslation();
const props = usePage<{
    project: { members: Array<{ email: string; name: string }> };
    roles: Array<{ uuid: string; name: string; permissions: Array<string> }>;
}>().props;
const inviteMemberForm = useForm({
    email: '',
    role: '',
});
const invitingMember = ref(false);
const openInviteMemberModal = () => {
    invitingMember.value = true;
};
const closeInviteMemberModal = () => {
    invitingMember.value = false;
    inviteMemberForm.reset();
};
const inviteMember = () => {
    inviteMemberForm.post('/foo/wqdqdqwdqd', {
        preserveScroll: true,
        onSuccess: () => closeInviteMemberModal(),
        onFinish: () => {
            inviteMemberForm.reset();
        },
    });
};
</script>

<template>
    <Head :title="t('project.members.index.title')" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ t('project.members.index.header') }}</h2>
        </template>

        <div class="py-12">{{ t('project.members.index.description') }}</div>
        <button type="button" @click="openInviteMemberModal" class="text-sm font-medium leading-6 text-gray-900">
            {{ t('project.members.index.inviteModal.button') }}
        </button>
        <Modal :show="invitingMember" @close="closeInviteMemberModal" max-width="lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ t('project.members.index.inviteModal.title') }}</h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ t('project.members.index.inviteModal.description') }}
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="email"
                        :value="t('project.members.index.inviteModal.form.email.label')"
                        class="sr-only"
                    />

                    <TextInput
                        id="email"
                        v-model="inviteMemberForm.email"
                        type="text"
                        class="mt-1 block w-3/4"
                        :placeholder="t('project.members.index.inviteModal.form.email.placeholder')"
                    />

                    <InputError :message="inviteMemberForm.errors.email" class="mt-2" />
                </div>

                <div class="mt-6">
                    <InputLabel
                        for="role"
                        :value="t('project.members.index.inviteModal.form.role.label')"
                        class="sr-only"
                    />

                    <fieldset aria-label="Role">
                        <div class="space-y-5">
                            <div v-for="role in props.roles" :key="role.uuid" class="relative flex items-start">
                                <div class="flex h-6 items-center">
                                    <input
                                        :id="role.uuid"
                                        :aria-describedby="`${role.uuid}-description`"
                                        name="role"
                                        type="radio"
                                        :value="role.uuid"
                                        v-model="inviteMemberForm.role"
                                        class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                    />
                                </div>
                                <div class="ml-3 text-sm leading-6">
                                    <label :for="role.uuid" class="font-medium text-gray-900">{{ role.name }}</label>
                                    <p :id="`${role.uuid}-description`" class="text-gray-500">
                                        {{ role.permissions.join(',') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <InputError :message="inviteMemberForm.errors.role" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeInviteMemberModal">
                        {{ t('project.members.index.inviteModal.cancel') }}
                    </SecondaryButton>
                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': inviteMemberForm.processing }"
                        :disabled="inviteMemberForm.processing"
                        @click="inviteMember"
                        >Create
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
        <ul role="list" class="divide-y divide-gray-100">
            <li v-for="member in props.project.members" :key="member.email" class="flex gap-x-4 py-5">
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
