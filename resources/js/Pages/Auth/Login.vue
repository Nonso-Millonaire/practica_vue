<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex bg-base-100">
        <Head title="Iniciar Sesión" />

        <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-primary to-secondary relative overflow-hidden items-center justify-center p-12 text-white">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

            <div class="relative z-10 max-w-lg text-center">
                <h2 class="text-5xl font-bold mb-6">Bienvenido de nuevo</h2>
                <p class="text-lg opacity-90 leading-relaxed">
                    Accede a tu panel de control para gestionar alumnos, revisar proyectos y mantener la administración escolar al día.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-base-100">
            <div class="w-full max-w-md space-y-8">

                <div class="lg:hidden text-center mb-8">
                    <h2 class="text-3xl font-bold text-base-content">Bienvenido</h2>
                    <p class="text-base-content/60">Inicia sesión en tu cuenta</p>
                </div>

                <div class="hidden lg:block mb-8">
                    <h2 class="text-3xl font-bold text-base-content">Iniciar Sesión</h2>
                    <p class="text-base-content/60 mt-2">Por favor, introduce tus datos.</p>
                </div>

                <div v-if="status" class="alert alert-success text-sm shadow-md mb-4">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Correo Electrónico</span>
                        </label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            required
                            autofocus
                            class="input input-bordered w-full focus:input-primary transition-all"
                            :class="{ 'input-error': form.errors.email }"
                            placeholder="nombre@ejemplo.com"
                        />
                        <span v-if="form.errors.email" class="text-error text-xs mt-1">{{ form.errors.email }}</span>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Contraseña</span>
                        </label>
                        <input
                            id="password"
                            type="password"
                            v-model="form.password"
                            required
                            class="input input-bordered w-full focus:input-primary transition-all"
                            :class="{ 'input-error': form.errors.password }"
                            placeholder="••••••••"
                        />
                        <span v-if="form.errors.password" class="text-error text-xs mt-1">{{ form.errors.password }}</span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="cursor-pointer flex items-center gap-2">
                            <input type="checkbox" v-model="form.remember" class="checkbox checkbox-sm checkbox-primary rounded" />
                            <span class="label-text">Recordarme</span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="link link-primary no-underline hover:underline"
                        >
                            ¿Olvidaste tu contraseña?
                        </Link>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="btn btn-primary w-full shadow-lg shadow-primary/30"
                            :class="{ 'loading': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ form.processing ? 'Ingresando...' : 'Iniciar Sesión' }}
                        </button>
                    </div>
                </form>

                <div class="text-center text-sm text-base-content/70 mt-8">
                    ¿No tienes una cuenta?
                    <Link :href="route('register')" class="link link-primary font-bold no-underline hover:underline">
                        Regístrate gratis
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
