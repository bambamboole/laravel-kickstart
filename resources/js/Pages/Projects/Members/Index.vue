<script setup lang="ts">
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import { useTranslation } from 'i18next-vue';
import { ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { diffForHumans, hasProjectPermission } from '@/utils';
import { Inertia } from '@inertiajs/inertia';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid';
import { formatDistanceToNow } from 'date-fns';

const { t } = useTranslation();
const props = usePage<{
    project: { members: Array<{ email: string; name: string }> };
    roles: Array<{ uuid: string; name: string; permissions: Array<string> }>;
}>().props;
const inviteMemberForm = useForm({
    email: '',
    role_uuid: '',
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
    inviteMemberForm.post(route('project.invitations.create', props.project.uuid), {
        preserveScroll: true,
        onSuccess: () => {
            closeInviteMemberModal();
            Inertia.visit(route('project.members.index', props.project.uuid), { only: ['project'] });
        },
    });
};

const deleteInvitation = (uuid: string) => {
    console.log(uuid);
    if (confirm('Are you sure you want to delete this invitation?')) {
        const form = useForm({});
        form.delete(route('project.invitations.delete', { projectUuid: props.project.uuid, invitationUuid: uuid }), {
            preserveScroll: true,
            onSuccess: () => {
                Inertia.visit(route('project.members.index', props.project.uuid), { only: ['project'] });
            },
        });
    }
};
</script>

<template>
    <Head :title="t('project.members.index.title')" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ t('project.members.index.header') }}</h2>
        </template>

        <div class="py-12">{{ t('project.members.index.description') }}</div>
        <button
            v-if="hasProjectPermission('project.members.invite')"
            type="button"
            @click="openInviteMemberModal"
            class="text-sm font-medium leading-6 text-gray-900"
        >
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
                        class="pb-6"
                        :value="t('project.members.index.inviteModal.form.role.label')"
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
                                        v-model="inviteMemberForm.role_uuid"
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
                    <InputError :message="inviteMemberForm.errors.role_uuid" class="mt-2" />
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
        <div class="py-6">{{ t('project.members.index.member_list') }}</div>

        <ul role="list" class="divide-y divide-gray-100">
            <li v-for="member in props.project.members" :key="member.email" class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4">
                    <!--                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="member.imageUrl" alt="" />-->
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            {{ member.name }}
                        </p>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            <a :href="`mailto:${member.email}`" class="truncate hover:underline">{{ member.email }}</a>
                        </p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-x-6">
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{ member.role.name }}</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            <time :datetime="member.last_login_at">
                                {{ t('project.member.last_login', { time: diffForHumans(member.last_login_at) }) }}
                            </time>
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
                                <MenuItem v-slot="{ active }">
                                    <a
                                        href="#"
                                        :class="[
                                            active ? 'bg-gray-50' : '',
                                            'block px-3 py-1 text-sm leading-6 text-gray-900',
                                        ]"
                                        >{{ t('project.member.change_role') }}</a
                                    >
                                </MenuItem>
                                <MenuItem v-if="hasProjectPermission('project.members.remove')" v-slot="{ active }">
                                    <a
                                        href="#"
                                        :class="[
                                            active ? 'bg-gray-50' : '',
                                            'block px-3 py-1 text-sm leading-6 text-gray-900',
                                        ]"
                                        >{{ t('project.member.remove') }}</a
                                    >
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </li>
        </ul>

        <div class="py-6">{{ t('project.members.index.invitation_list') }}</div>
        <ul role="list" class="divide-y divide-gray-100">
            <li
                v-for="invitation in props.project.invitations"
                :key="invitation.email"
                class="flex justify-between gap-x-6 py-5"
            >
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            {{ invitation.email }}
                        </p>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-x-6">
                    <div class="hidden sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{ invitation.role.name }}</p>
                        <p v-if="invitation.created_at" class="mt-1 text-xs leading-5 text-gray-500">
                            <time :datetime="invitation.created_at">
                                {{
                                    t('project.invitation.created', {
                                        time: formatDistanceToNow(invitation.created_at),
                                    })
                                }}
                            </time>
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
                                <MenuItem v-if="hasProjectPermission('project.invitations.delete')" v-slot="{ active }">
                                    <button
                                        @click="deleteInvitation(invitation.uuid)"
                                        :class="[
                                            active ? 'bg-gray-50' : '',
                                            'block px-3 py-1 text-sm leading-6 text-gray-900',
                                        ]"
                                    >
                                        {{ t('project.invitation.delete') }}
                                    </button>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </li>
        </ul>
    </ProjectLayout>
</template>
