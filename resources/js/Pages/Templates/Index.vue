<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from  '@inertiajs/vue3';

const props = defineProps({
    templates: Array
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>
        <div class="max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Templates</h2>
            <ul>
                <li v-for="template in props.templates" :key="template.id" class="mb-2">
                    <Link :href="route('templates.edit', { id: template.id })" class="font-medium text-gray-700">
                        {{ template.name }}
                    </Link>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>

</template>
