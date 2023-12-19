<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';

const { clients } = defineProps(['clients']);

</script>

<template>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div>
        <h1 class="text-2xl font-semibold mb-4">Clients</h1>
        <ul>
            <li v-for="client in clients" :key="client.id" class="mb-2">
                {{ client.email }}
            </li>
        </ul>
        </div>
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Manage Data:</h2>
            <div class="flex space-x-4">
                <Link :href="route('clients.index')" class="text-blue-500 hover:underline">View Clients</Link>
                <Link :href="route('templates.index')" class="text-blue-500 hover:underline">View Templates</Link>
            </div>
        </div>
    </AuthenticatedLayout>

</template>

