<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, router, Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({ students: Object });
const { translations } = usePage().props;
const flash = usePage().props.flash;

// Variables reactivas para el modal
const isModalOpen = ref(false);
const isEditing = ref(false);
const form = useForm({ id: null, name: '', email: '' });

// Escuchar mensajes flash del backend
watch(() => usePage().props.flash, (newFlash) => {
    if (newFlash.success) {
        Swal.fire({
            icon: 'success',
            title: translations[newFlash.success] || 'OK',
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
        });
    }
}, { deep: true });

const openModal = (student = null) => {
    isEditing.value = !!student;
    form.reset();
    form.clearErrors();
    if (student) {
        form.id = student.id;
        form.name = student.name;
        form.email = student.email;
    }
    isModalOpen.value = true;
};

const submit = () => {
    const options = {
        onSuccess: () => { isModalOpen.value = false; form.reset(); }
    };
    if (isEditing.value) {
        form.put(route('students.update', form.id), options);
    } else {
        form.post(route('students.store'), options);
    }
};

const deleteItem = (id) => {
    Swal.fire({
        title: translations.confirm_delete_title,
        text: translations.confirm_delete_text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: translations.delete,
        cancelButtonText: translations.cancel
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('students.destroy', id));
        }
    });
};
</script>

<template>
    <Head :title="translations.students" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ translations.students }}
                </h2>
                <button @click="openModal()" class="btn btn-primary btn-sm">
                    + {{ translations.add_student }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                            <tr class="bg-base-200">
                                <th>ID</th>
                                <th>{{ translations.name }}</th>
                                <th>{{ translations.email }}</th>
                                <th class="text-right">{{ translations.actions }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="student in students.data" :key="student.id" class="hover">
                                <td>{{ student.id }}</td>
                                <td>{{ student.name }}</td>
                                <td>{{ student.email }}</td>
                                <td class="flex justify-end gap-2">
                                    <button @click="openModal(student)" class="btn btn-square btn-ghost btn-sm">
                                        ✏️
                                    </button>
                                    <button @click="deleteItem(student.id)" class="btn btn-square btn-ghost btn-sm text-error">
                                        🗑️
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-center gap-2">
                        <Link v-for="link in students.links"
                              :key="link.label"
                              :href="link.url ?? '#'"
                              v-html="link.label"
                              class="join-item btn btn-sm"
                              :class="{ 'btn-active': link.active, 'btn-disabled': !link.url }" />
                    </div>
                </div>
            </div>
        </div>

        <dialog class="modal" :class="{ 'modal-open': isModalOpen }">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">
                    {{ isEditing ? translations.edit : translations.add_student }}
                </h3>
                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <div>
                        <label class="label">{{ translations.name }}</label>
                        <input v-model="form.name" type="text" class="input input-bordered w-full" />
                        <span v-if="form.errors.name" class="text-error text-xs">{{ form.errors.name }}</span>
                    </div>
                    <div>
                        <label class="label">{{ translations.email }}</label>
                        <input v-model="form.email" type="email" class="input input-bordered w-full" />
                        <span v-if="form.errors.email" class="text-error text-xs">{{ form.errors.email }}</span>
                    </div>
                    <div class="modal-action">
                        <button type="button" @click="isModalOpen = false" class="btn">
                            {{ translations.cancel }}
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">
                            {{ translations.save }}
                        </button>
                    </div>
                </form>
            </div>
        </dialog>
    </AuthenticatedLayout>
</template>
