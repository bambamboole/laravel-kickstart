<script setup lang="ts">
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import { useTranslation } from 'i18next-vue';
const page = usePage();
const { t } = useTranslation();
const confirmingProjectDeletion = ref(false);
const projectNameInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    name: '',
});

const confirmProjectDeletion = () => {
    confirmingProjectDeletion.value = true;

    nextTick(() => projectNameInput.value?.focus());
};

const deleteProject = () => {
    form.delete(route('project.delete', { project: page.props.project.uuid }), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => projectNameInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingProjectDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">{{ t('project.delete.title') }}</h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ t('project.delete.description') }}
            </p>
        </header>

        <DangerButton @click="confirmProjectDeletion" type="button">{{ t('project.delete.button') }}</DangerButton>

        <Modal :show="confirmingProjectDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ t('project.delete.confirmation.title') }}</h2>

                <p
                    class="mt-1 text-sm text-gray-600"
                    v-html="t('project.delete.confirmation.description', { name: page.props.project.name })"
                ></p>

                <div class="mt-6">
                    <InputLabel for="name" value="Password" class="sr-only" />

                    <TextInput
                        id="name"
                        ref="projectNameInput"
                        v-model="form.name"
                        type="name"
                        class="mt-1 block w-3/4"
                        :placeholder="t('project.delete.confirmation.placeholder')"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal" type="button">
                        {{ t('project.delete.confirmation.cancel') }}
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteProject"
                        type="button"
                    >
                        {{ t('project.delete.confirmation.button') }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
