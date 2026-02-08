<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ projects: Array }); // Recibimos el array de proyectos
const t = computed(() => usePage().props.translations);
</script>

<template>
    <Head title="Proyectos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ t?.projects || 'Proyectos' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div v-if="projects.length === 0" class="text-center py-10">
                    <p class="text-gray-500 text-lg">No hay proyectos disponibles.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="project in projects" :key="project.id" class="card bg-white dark:bg-gray-800 shadow-xl border-t-4 border-secondary">
                        <div class="card-body">
                            <h2 class="card-title text-gray-900 dark:text-white">
                                📂 {{ project.title || project.name }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300">
                                {{ project.description }}
                            </p>
                            <div class="card-actions justify-end mt-4">
                                <button class="btn btn-sm btn-ghost">Ver detalles</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
