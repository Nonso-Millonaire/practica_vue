<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, useForm, router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({ projects: Array });
const page = usePage();
const t = computed(() => page.props.translations);

// --- Lógica del Modal ---
const isModalOpen = ref(false);
const isEditing = ref(false);
const form = useForm({ id: null, title: '', description: '' });

const openModal = (project = null) => {
    isEditing.value = !!project;
    form.reset();
    form.clearErrors();
    if (project) {
        form.id = project.id;
        form.title = project.title;
        form.description = project.description;
    }
    isModalOpen.value = true;
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('projects.update', form.id), {
            onSuccess: () => isModalOpen.value = false
        });
    } else {
        form.post(route('projects.store'), {
            onSuccess: () => isModalOpen.value = false
        });
    }
};

const deleteProject = (id) => {
    Swal.fire({
        title: t.value?.are_you_sure || '¿Estás seguro?',
        text: t.value?.cant_revert || "No podrás revertir esto",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, borrar'
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('projects.destroy', id));
        }
    });
};

// --- Escuchar Mensajes Flash y Traducirlos ---
watch(() => page.props.flash, (flash) => {
    if (flash.message) {
        // Aquí ocurre la magia: Si el mensaje es una clave (ej: 'project_created'), lo traducimos
        const translatedMessage = t.value?.[flash.message] || flash.message;

        Swal.fire({
            icon: 'success',
            title: translatedMessage,
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
        });
    }
}, { deep: true });
</script>

<template>
    <Head title="Proyectos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ t?.projects || 'Proyectos' }}
                </h2>
                <button @click="openModal()" class="btn btn-primary btn-sm shadow-md">
                    + {{ t?.add_project || 'Crear Proyecto' }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div v-if="projects.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <p class="text-gray-500">No hay proyectos aún. ¡Crea el primero!</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="project in projects" :key="project.id" class="card bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl transition-all border-t-4 border-secondary group">
                        <div class="card-body">
                            <h2 class="card-title text-gray-900 dark:text-white flex justify-between">
                                {{ project.title }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 line-clamp-3">
                                {{ project.description }}
                            </p>
                            <div class="card-actions justify-end mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <button @click="openModal(project)" class="btn btn-ghost btn-sm btn-circle text-warning tooltip" data-tip="Editar">
                                    Editar
                                </button>
                                <button @click="deleteProject(project.id)" class="btn btn-ghost btn-sm btn-circle text-error tooltip" data-tip="Borrar">
                                    Borrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div v-if="isModalOpen" class="modal modal-open bg-black/60 backdrop-blur-sm">
            <div class="modal-box bg-white dark:bg-gray-800">
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-white">
                    {{ isEditing ? 'Editar Proyecto' : 'Nuevo Proyecto' }}
                </h3>

                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <div>
                        <label class="label"><span class="label-text text-gray-700 dark:text-gray-300">Título</span></label>
                        <input v-model="form.title" type="text" class="input input-bordered w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
                        <span v-if="form.errors.title" class="text-error text-xs">{{ form.errors.title }}</span>
                    </div>

                    <div>
                        <label class="label"><span class="label-text text-gray-700 dark:text-gray-300">Descripción</span></label>
                        <textarea v-model="form.description" class="textarea textarea-bordered w-full h-24 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                        <span v-if="form.errors.description" class="text-error text-xs">{{ form.errors.description }}</span>
                    </div>

                    <div class="modal-action">
                        <button type="button" @click="isModalOpen = false" class="btn btn-ghost">Cancelar</button>
                        <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
