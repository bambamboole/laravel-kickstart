<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import ProjectLayout from '@/Layouts/ProjectLayout.vue';
import { computed, ref } from 'vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { diffForHumans, hasAnyProjectPermission, hasProjectPermission } from '@/utils';
import { EllipsisVerticalIcon } from '@heroicons/vue/20/solid';
import { formatDistanceToNow } from 'date-fns';
import { Button } from '@/Components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription, DialogFooter, DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/Components/ui/dialog';
import Content from '@/Components/ui/content/Content.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/Components/ui/card';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger
} from '@/Components/ui/dropdown-menu';

const props = computed(
    () =>
        usePage<{
            project: { members: Array<{ email: string; name: string }> };
            roles: Array<{ uuid: string; name: string; permissions: Array<string> }>;
        }>().props
);
const inviteMemberForm = useForm({
    email: '',
    role_uuid: ''
});

const invitingMember = ref(false);

const inviteMember = () => {
    inviteMemberForm.post(route('project.invitations.create', props.value.project.uuid), {
        preserveScroll: true,
        onSuccess: () => {
            invitingMember.value = false;
            inviteMemberForm.reset();
        }
    });
};

const deleteInvitation = (uuid: string) => {
    const form = useForm({});
    form.delete(route('project.invitations.delete', { project: props.value.project.uuid, uuid: uuid }), {
        preserveScroll: true
    });
};

const removeMember = (uuid: string) => {
    const form = useForm({});
    form.delete(route('project.members.delete', { project: props.value.project.uuid, uuid: uuid }), {
        preserveScroll: true
    });
};
</script>

<template>
    <Head :title="$t('project.members.title')" />

    <ProjectLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">{{ $t('project.members.header') }}</h2>
        </template>
        <Content>
            <Card>
                <CardHeader>
                    <div class="flex justify-between pb-6">
                        <CardTitle>{{ $t('project.members.index.member_list') }}</CardTitle>
                        <Dialog v-if="hasProjectPermission('project.members.invite')" v-model:open="invitingMember">
                            <DialogTrigger as-child>
                                <Button type="button">
                                    {{ $t('project.members.index.inviteModal.button') }}
                                </Button>
                            </DialogTrigger>
                            <DialogContent>
                                <DialogHeader>
                                    <DialogTitle>{{ $t('project.members.inviteModal.title') }}</DialogTitle>
                                    <DialogDescription>
                                        {{ $t('project.members.inviteModal.description') }}
                                    </DialogDescription>
                                </DialogHeader>

                                <div class="mt-6">
                                    <InputLabel
                                        for="email"
                                        :value="$t('project.members.index.inviteModal.form.email.label')"
                                        class="sr-only"
                                    />

                                    <TextInput
                                        id="email"
                                        v-model="inviteMemberForm.email"
                                        type="text"
                                        class="mt-1 block w-3/4"
                                        :placeholder="
                                                $t('project.members.index.inviteModal.form.email.placeholder')
                                            "
                                    />

                                    <InputError :message="inviteMemberForm.errors.email" class="mt-2" />
                                </div>

                                <div class="mt-6">
                                    <InputLabel
                                        for="role"
                                        class="pb-6"
                                        :value="$t('project.members.index.inviteModal.form.role.label')"
                                    />

                                    <fieldset aria-label="Role">
                                        <div class="space-y-5">
                                            <div
                                                v-for="role in props.roles"
                                                :key="role.uuid"
                                                class="relative flex items-start"
                                            >
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
                                                    <label :for="role.uuid" class="font-medium text-gray-900">{{
                                                            role.name
                                                        }}</label>
                                                    <p :id="`${role.uuid}-description`" class="text-gray-500">
                                                        {{ role.permissions.join(', ') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <InputError :message="inviteMemberForm.errors.role_uuid" class="mt-2" />
                                </div>

                                <DialogFooter>
                                    <DialogClose as-child>
                                        <Button variant="secondary">
                                            {{ $t('project.members.index.inviteModal.cancel') }}
                                        </Button>
                                    </DialogClose>
                                    <Button
                                        class="ms-3"
                                        :class="{ 'opacity-25': inviteMemberForm.processing }"
                                        :disabled="inviteMemberForm.processing"
                                        @click="inviteMember"
                                    >Create
                                    </Button>
                                </DialogFooter>
                            </DialogContent>
                        </Dialog>
                    </div>
                </CardHeader>
                <CardContent>
                    <ul role="list" class="divide-y divide-gray-100">
                        <li
                            v-for="member in props.project.members"
                            :key="member.email"
                            class="flex justify-between gap-x-6 py-5"
                        >
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">
                                        {{ member.name }}
                                    </p>
                                    <p class="mt-1 flex text-xs leading-5 text-gray-500">
                                        <a :href="`mailto:${member.email}`" class="truncate hover:underline">{{
                                                member.email
                                            }}</a>
                                    </p>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-x-6">
                                <div class="hidden sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">{{ member.role.name }}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">
                                        <time :datetime="member.last_login_at">
                                            {{
                                                $t('project.member.last_login', {
                                                    time: diffForHumans(member.last_login_at)
                                                })
                                            }}
                                        </time>
                                    </p>
                                </div>
                                <DropdownMenu v-if="hasAnyProjectPermission(['project.members.delete'])">
                                    <DropdownMenuTrigger>
                                        <span class="sr-only">Open options</span>
                                        <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent>
                                        <DropdownMenuItem>
                                            <Button variant="link" @click="removeMember(member.uuid)">
                                                {{ $t('project.member.remove') }}
                                            </Button>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </li>
                    </ul>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle>{{ $t('project.members.invitations') }}</CardTitle>
                </CardHeader>
                <CardContent>
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
                                                $t('project.invitation.created', {
                                                    time: formatDistanceToNow(invitation.created_at)
                                                })
                                            }}
                                        </time>
                                    </p>
                                </div>
                                <DropdownMenu v-if="hasAnyProjectPermission(['project.invitations.delete'])">
                                    <DropdownMenuTrigger>
                                        <span class="sr-only">Open options</span>
                                        <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent>
                                        <DropdownMenuItem>
                                            <Button variant="link" @click="deleteInvitation(invitation.uuid)">
                                                {{ $t('project.invitation.delete') }}
                                            </Button>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </li>
                    </ul>
                </CardContent>
            </Card>
        </Content>
    </ProjectLayout>
</template>
