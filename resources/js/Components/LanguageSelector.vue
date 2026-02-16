<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const locales = {
    es: { flag: '🇪🇸', label: 'Español' },
    en: { flag: '🇬🇧', label: 'English' },
    fr: { flag: '🇫🇷', label: 'Français' },
};

const currentLocale = computed(() => page.props.locale, 'es');
</script>

<template>
    <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-sm m-1 gap-2 border-base-content/20">
            <span class="text-lg">{{ locales[currentLocale]?.flag }}</span>
            <span class="hidden md:inline">{{ locales[currentLocale]?.label }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
        </div>
        <ul tabindex="0" class="dropdown-content z-[50] menu p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-200">
            <li v-for="(data, code) in locales" :key="code">
                <a
                    :href="route('lang.switch', code)"
                    :class="{ 'active': currentLocale === code }"
                    class="flex justify-between"
                >
                    <span class="flex items-center gap-2">
                        <span class="text-xl">{{ data.flag }}</span> {{ data.label }}
                    </span>
                    <span v-if="currentLocale === code" class="text-success font-bold">✓</span>
                </a>
            </li>
        </ul>
    </div>
</template>
