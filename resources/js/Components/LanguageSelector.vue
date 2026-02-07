<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const currentLocale = computed(() => page.props.locale);
</script>

<template>
    <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-sm m-1 uppercase">
            {{ currentLocale }}
        </div>
        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
            <li><Link :href="route('lang.switch', 'es')">Castellano 🇪🇸</Link></li>
            <li><Link :href="route('lang.switch', 'en')">English 🇬🇧</Link></li>
            <li><Link :href="route('lang.switch', 'fr')">Français 🇫🇷</Link></li>
        </ul>
    </div>
</template>
