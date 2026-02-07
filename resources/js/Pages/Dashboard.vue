<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

// Obtenemos las traducciones globales
const t = usePage().props.translations;
</script>

<template>
    <Head :title="t?.dashboard || 'Dashboard'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ t?.dashboard || 'Panel de Control' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <div class="card bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl transition-all border-l-4 border-blue-500">
                        <div class="card-body">
                            <h2 class="card-title text-2xl flex items-center gap-2">
                                👨‍🎓 {{ t?.students || 'Alumnos' }}
                            </h2>
                            <p class="opacity-70 mt-2">
                                Gestión completa del alumnado: Altas, bajas, listados y edición de perfiles.
                            </p>
                            <div class="card-actions justify-end mt-6">
                                <Link :href="route('students.index')" class="btn btn-primary">
                                    Gestionar
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl transition-all border-l-4 border-purple-500">
                        <div class="card-body">
                            <h2 class="card-title text-2xl flex items-center gap-2">
                                🚀 {{ t?.projects || 'Proyectos' }}
                            </h2>
                            <p class="opacity-70 mt-2">
                                Visualiza y asigna proyectos académicos disponibles en el sistema.
                            </p>
                            <div class="card-actions justify-end mt-6">
                                <Link :href="route('projects.index')" class="btn btn-secondary">
                                    Ver Proyectos
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl transition-all border-l-4 border-green-500">
                        <div class="card-body">
                            <h2 class="card-title text-2xl flex items-center gap-2">
                                ⚙️ Mi Cuenta
                            </h2>
                            <p class="opacity-70 mt-2">
                                Configura tus datos personales, contraseña y preferencias de la cuenta.
                            </p>
                            <div class="card-actions justify-end mt-6">
                                <Link :href="route('profile.edit')" class="btn btn-accent text-white">
                                    Configurar
                                </Link>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
