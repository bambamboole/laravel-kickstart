<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
import { Dialog, DialogTrigger, DialogHeader, DialogContent, DialogFooter, DialogClose } from '@/Components/ui/dialog';

const page = usePage();
const projectNameInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    name: '',
});

const deleteProject = () => {
    form.delete(route('project.delete', { project: page.props.project.uuid }), {
        preserveScroll: true,
        onError: () => projectNameInput.value?.focus(),
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>{{ $t('project.delete.title') }}</CardTitle>
            <CardDescription>{{ $t('project.delete.description') }}</CardDescription>
        </CardHeader>

        <CardContent>
            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive" type="button">
                        {{ $t('project.delete.button') }}
                    </Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>{{ $t('project.delete.confirmation.title') }}</DialogTitle>
                        <DialogDescription
                            v-html="$t('project.delete.confirmation.description', { name: page.props.project.name })"
                        />
                    </DialogHeader>
                    <InputLabel for="name" value="Password" class="sr-only" />

                    <TextInput
                        id="name"
                        ref="projectNameInput"
                        v-model="form.name"
                        type="name"
                        class="mt-1 block w-3/4"
                        :placeholder="$t('project.delete.confirmation.placeholder')"
                    />

                    <InputError :message="form.errors.name" class="mt-2" />
                    <DialogFooter>
                        <DialogClose as-child>
                            <Button variant="secondary" type="button">
                                {{ $t('project.delete.confirmation.cancel') }}
                            </Button>
                        </DialogClose>

                        <Button
                            variant="destructive"
                            class="ms-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="deleteProject"
                            type="button"
                        >
                            {{ $t('project.delete.confirmation.button') }}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </CardContent>
    </Card>
</template>
