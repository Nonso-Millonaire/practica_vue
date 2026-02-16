<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import LanguageSelector from '@/Components/LanguageSelector.vue';
import { computed } from 'vue';

defineProps({ canLogin: Boolean, canRegister: Boolean });

// 1. Accedemos a las traducciones que nos envía Laravel
const page = usePage();
const t = computed(() => page.props.translations);
const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Bienvenido" />

    <div class="min-h-screen flex flex-col bg-base-200 font-sans text-base-content">
        <nav class="navbar bg-base-100 shadow-sm px-6 lg:px-12 sticky top-0 z-40">
            <div class="flex-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-primary/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight hidden sm:inline">Instituto<span class="text-primary">App</span></span>
                </div>
            </div>

            <div class="flex-none gap-3">
                <LanguageSelector />

                <div v-if="canLogin" class="flex gap-2">
                    <Link v-if="user" :href="route('dashboard')" class="btn btn-primary btn-sm rounded-lg">
                        {{ t?.dashboard || 'Dashboard' }}
                    </Link>
                    <template v-else>
                        <Link :href="route('login')" class="btn btn-ghost btn-sm">
                            {{ t?.login || 'Login' }}
                        </Link>
                        <Link v-if="canRegister" :href="route('register')" class="btn btn-primary btn-sm shadow-md shadow-primary/30">
                            {{ t?.register || 'Register' }}
                        </Link>
                    </template>
                </div>
            </div>
        </nav>

        <main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">
            <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-secondary/5 rounded-full blur-3xl"></div>

            <div class="text-center max-w-3xl z-10 animate-fade-in-up">
                <div class="badge badge-outline badge-lg mb-6 py-4 px-6 opacity-70">
                    {{ new Date().getFullYear() }} Academic System v1.0
                </div>

                <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
                    {{ t?.welcome_title || 'Gestión Educativa Inteligente' }}
                </h1>

                <p class="text-xl opacity-70 mb-10 max-w-2xl mx-auto leading-relaxed">
                    {{ t?.welcome_subtitle || 'Plataforma integral...' }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <Link v-if="!user" :href="route('login')" class="btn btn-primary btn-lg rounded-xl px-10 shadow-xl hover:scale-105 transition-transform">
                        {{ t?.access_portal || 'Acceder al Portal' }}
                    </Link>
                    <Link v-else :href="route('dashboard')" class="btn btn-primary btn-lg rounded-xl px-10 shadow-xl hover:scale-105 transition-transform">
                        {{ t?.dashboard || 'Dashboard' }}
                    </Link>

                    <a href="https://laravel.com" target="_blank" class="btn btn-outline btn-lg rounded-xl px-10">
                        {{ t?.documentation || 'Documentación' }}
                    </a>
                </div>
            </div>
        </main>

        <footer class="footer items-center p-4 bg-base-100 text-base-content/50 border-t border-base-200 justify-center">
            <p>Copyright © {{ new Date().getFullYear() }} - {{ t?.copyright || 'Todos los derechos reservados' }}</p>
        </footer>
    </div>
</template>

<style>
.animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
@keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
