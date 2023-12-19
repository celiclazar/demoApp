<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router  } from '@inertiajs/vue3';

const formData = {
    client_name: '',
    client_email: '',
    selectedTemplate: '',
};

const submitForm = () => {
    router.post('/internal-portal', formData);
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <section class="p-6 mt-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="font-semibold text-xl text-gray-300">
                <h1>This is going to be some admin page for internal users</h1>
                <p class="italic">Some kind of notifications can be displayed here</p>
            </div>
        </section>

        <div class="flex flex-col md:flex-row justify-between items-center mt-8 space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex-1">
        <div class="bg-gray-800 rounded-lg py-2 px-4">
            <h3 class="text-blue-800 font-semibold">Manage Clients</h3>
            <Link :href="route('clients.index')" class="text-blue-600 hover:text-blue-800 hover:underline">View Clients</Link>
            <br>
            <Link :href="route('clients.add')" class="text-blue-600 hover:text-blue-800 hover:underline">Add Client</Link>

        </div>
        </div>

        <div class="flex-1">
        <div class="bg-gray-800 rounded-lg py-2 px-4">
            <h3 class="text-green-800 font-semibold">Manage Templates</h3>
            <Link :href="route('templates.index')" class="text-green-600 hover:text-green-800 hover:underline">View Templates</Link>
            <br>
            <Link :href="route('templates.add')" class="text-green-600 hover:text-green-800 hover:underline">Add Template</Link>
        </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
