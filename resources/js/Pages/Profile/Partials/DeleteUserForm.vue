<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref, computed } from 'vue';

const page = usePage();
const t = computed(() => page.props.translations);

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ t?.delete_account || 'Delete Account' }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ t?.delete_account_description || 'Once your account is deleted, all of its resources and data will be permanently deleted.' }}
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">
            {{ t?.delete_account_button || 'Delete Account' }}
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ t?.are_you_sure_delete || 'Are you sure you want to delete your account?' }}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    {{ t?.delete_warning || 'Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.' }}
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        :value="t?.password || 'Password'"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        :placeholder="t?.password || 'Password'"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        {{ t?.cancel || 'Cancel' }}
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        {{ t?.delete_account_button || 'Delete Account' }}
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
