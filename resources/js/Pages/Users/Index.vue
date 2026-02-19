<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { computed, watch } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({ users: Object });
const page = usePage();
const t = computed(() => page.props.translations);

// Escuchar mensajes de éxito o error (como intentar cambiarse el rol a uno mismo)
watch(() => page.props.flash, (flash) => {
    if (flash.message || flash.error) {
        const isError = !!flash.error;
        const msgKey = flash.error || flash.message;
        const translatedMessage = t.value?.[msgKey] || msgKey;

        Swal.fire({
            icon: isError ? 'error' : 'success',
            title: translatedMessage,
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
        });
    }
}, { deep: true });

// Función para cambiar el rol directamente desde el select
const changeRole = (user, event) => {
    const newRole = event.target.value;

    // Validar en frontend si es él mismo
    if (user.id === page.props.auth.user.id) {
        Swal.fire({
            icon: 'error',
            title: t.value?.cannot_change_own_role || 'No puedes cambiar tu propio rol',
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000
        });
        event.target.value = 'admin'; // Devolvemos el select visualmente a admin
        return;
    }

    router.put(route('users.updateRole', user.id), { role: newRole }, {
        preserveScroll: true
    });
};
</script>

<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ t?.users || 'Gestión de Usuarios' }}
            </h2>
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
                                <th>{{ t?.role || 'Rol' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="font-bold">{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <select
                                        :value="user.role"
                                        @change="changeRole(user, $event)"
                                        class="select select-bordered w-32 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-primary"
                                    >
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-center gap-2" v-if="users.links && users.links.length > 3">
                        <Link v-for="link in users.links"
                              :key="link.label"
                              :href="link.url ?? '#'"
                              v-html="link.label"
                              class="join-item btn btn-sm"
                              :class="{ 'btn-active btn-primary': link.active, 'btn-disabled': !link.url }" />
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
