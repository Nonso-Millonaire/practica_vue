<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="min-h-screen flex bg-base-100">
        <Head title="Registrarse" />

        <div class="hidden lg:flex w-1/2 bg-gradient-to-tr from-secondary to-primary relative overflow-hidden items-center justify-center p-12 text-white">
            <div class="absolute top-1/2 left-1/2 w-[500px] h-[500px] bg-white/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>

            <div class="relative z-10 max-w-lg text-center">
                <h2 class="text-5xl font-bold mb-6">Únete a nosotros</h2>
                <p class="text-lg opacity-90 leading-relaxed">
                    Crea tu cuenta hoy y comienza a gestionar tus proyectos educativos de manera eficiente y profesional.
                </p>
                <div class="mt-8 text-left space-y-4 inline-block">
                    <div class="flex items-center gap-3">
                        <div class="badge badge-success badge-xs"></div> <span>Acceso ilimitado al dashboard</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="badge badge-success badge-xs"></div> <span>Gestión de alumnos en tiempo real</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="badge badge-success badge-xs"></div> <span>Soporte multi-idioma</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-base-100">
            <div class="w-full max-w-md space-y-8">

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-base-content">Crear cuenta</h2>
                    <p class="text-base-content/60 mt-2">Rellena el formulario para empezar.</p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">

                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Nombre Completo</span></label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            required
                            autofocus
                            class="input input-bordered w-full focus:input-secondary"
                            :class="{ 'input-error': form.errors.name }"
                            placeholder="Tu nombre"
                        />
                        <span v-if="form.errors.name" class="text-error text-xs mt-1">{{ form.errors.name }}</span>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Correo Electrónico</span></label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            class="input input-bordered w-full focus:input-secondary"
                            :class="{ 'input-error': form.errors.email }"
                            placeholder="nombre@empresa.com"
                        />
                        <span v-if="form.errors.email" class="text-error text-xs mt-1">{{ form.errors.email }}</span>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Contraseña</span></label>
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            class="input input-bordered w-full focus:input-secondary"
                            :class="{ 'input-error': form.errors.password }"
                            placeholder="Mínimo 8 caracteres"
                        />
                        <span v-if="form.errors.password" class="text-error text-xs mt-1">{{ form.errors.password }}</span>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text font-semibold">Confirmar Contraseña</span></label>
                        <input
                            id="password_confirmation"
                            type="password"
                            v-model="form.password_confirmation"
                            required
                            class="input input-bordered w-full focus:input-secondary"
                            :class="{ 'input-error': form.errors.password_confirmation }"
                            placeholder="Repite la contraseña"
                        />
                        <span v-if="form.errors.password_confirmation" class="text-error text-xs mt-1">{{ form.errors.password_confirmation }}</span>
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="btn btn-secondary w-full shadow-lg shadow-secondary/30"
                            :class="{ 'loading': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Registrando...' : 'Crear Cuenta' }}
                        </button>
                    </div>
                </form>

                <div class="text-center text-sm text-base-content/70 mt-8">
                    ¿Ya tienes una cuenta?
                    <Link :href="route('login')" class="link link-secondary font-bold no-underline hover:underline">
                        Inicia sesión aquí
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
