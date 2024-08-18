<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/Components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription, DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/Components/ui/dialog';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: ''
});

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            confirmingUserDeletion.value = false;
            form.reset();
        },
        onError: () => passwordInput.value?.focus(),
        onFinish: () => {
            form.reset();
        }
    });
};
</script>

<template>
    <Card>
        <CardHeader>
            <CardTitle>
                {{ $t('profile.delete_account.title') }}
            </CardTitle>
            <CardDescription class="max-w-xl">
                {{ $t('profile.delete_account.description') }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive">{{ $t('profile.delete_account.button') }}</Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>
                            {{ $t('profile.delete_account.confirm_title') }}
                        </DialogTitle>
                        <DialogDescription>
                            {{ $t('profile.delete_account.confirm_description') }}
                        </DialogDescription>
                    </DialogHeader>
                    <div class="mt-6">
                        <InputLabel for="password" value="Password" class="sr-only" />

                        <TextInput
                            id="password"
                            ref="passwordInput"
                            v-model="form.password"
                            type="password"
                            class="mt-1 block w-3/4"
                            placeholder="Password"
                            @keyup.enter="deleteUser"
                        />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>

                    <DialogFooter>
                        <DialogClose as-child>
                            <Button variant="secondary">{{ $t('cancel') }}</Button>
                        </DialogClose>

                        <Button
                            variant="destructive"
                            class="ms-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="deleteUser"
                        >
                            {{ $t('profile.delete_account.button') }}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </CardContent>
    </Card>
</template>
