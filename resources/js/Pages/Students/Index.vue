<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, router, Link } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({ students: Object });
const page = usePage();
const t = computed(() => page.props.translations);

// Control del Modal
const isModalOpen = ref(false);
const isEditing = ref(false);
const form = useForm({ id: null, name: '', email: '' });

// Escuchar mensajes flash (Éxito/Error)
watch(() => page.props.flash, (flash) => {
    if (flash.success || flash.message) {
        Swal.fire({
            icon: 'success',
            title: flash.success || flash.message,
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
        });
        isModalOpen.value = false;
        form.reset();
    }
}, { deep: true });

const openModal = (student = null) => {
    isEditing.value = !!student;
    form.clearErrors();
    form.reset();
    if (student) {
        form.id = student.id;
        form.name = student.name;
        form.email = student.email;
    }
    isModalOpen.value = true;
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('students.update', form.id));
    } else {
        form.post(route('students.store'));
    }
};

const deleteStudent = (id) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('students.destroy', id));
        }
    });
};
</script>

<template>
    <Head title="Alumnos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ t?.students || 'Gestión de Alumnos' }}
                </h2>
                <button @click="openModal()" class="btn btn-primary btn-sm shadow-lg">
                    + {{ t?.add_student || 'Nuevo Alumno' }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <div class="overflow-x-auto">
                        <table class="table w-full text-gray-700 dark:text-gray-300">
                            <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white">
                                <th>ID</th>
                                <th>{{ t?.name || 'Nombre' }}</th>
                                <th>{{ t?.email || 'Email' }}</th>
                                <th class="text-right">{{ t?.actions || 'Acciones' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="student in students.data" :key="student.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="font-bold">{{ student.id }}</td>
                                <td>{{ student.name }}</td>
                                <td>{{ student.email }}</td>
                                <td class="flex justify-end gap-2">
                                    <button @click="openModal(student)" class="btn btn-warning btn-xs text-white">
                                        ✏️ {{ t?.edit || 'Editar' }}
                                    </button>
                                    <button @click="deleteStudent(student.id)" class="btn btn-error btn-xs text-white">
                                        🗑️ {{ t?.delete || 'Borrar' }}
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-center gap-2">
                        <Link v-for="link in students.links"
                              :key="link.label"
                              :href="link.url ?? '#'"
                              v-html="link.label"
                              class="join-item btn btn-sm"
                              :class="{ 'btn-active btn-primary': link.active, 'btn-disabled': !link.url }" />
                    </div>

                </div>
            </div>
        </div>

        <div v-if="isModalOpen" class="modal modal-open bg-black/50 backdrop-blur-sm">
            <div class="modal-box bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-2xl">
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-white">
                    {{ isEditing ? (t?.edit || 'Editar') : (t?.add_student || 'Crear Nuevo') }} Alumno
                </h3>

                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <div>
                        <label class="label"><span class="label-text text-gray-700 dark:text-gray-300">Nombre</span></label>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Ej: Juan Pérez"
                            class="input input-bordered w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-primary"
                        />
                        <span v-if="form.errors.name" class="text-error text-xs">{{ form.errors.name }}</span>
                    </div>

                    <div>
                        <label class="label"><span class="label-text text-gray-700 dark:text-gray-300">Email</span></label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="juan@ejemplo.com"
                            class="input input-bordered w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600 focus:border-primary"
                        />
                        <span v-if="form.errors.email" class="text-error text-xs">{{ form.errors.email }}</span>
                    </div>

                    <div class="modal-action">
                        <button type="button" @click="isModalOpen = false" class="btn btn-ghost text-gray-600 dark:text-gray-400">
                            {{ t?.cancel || 'Cancelar' }}
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">
                            {{ t?.save || 'Guardar' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
