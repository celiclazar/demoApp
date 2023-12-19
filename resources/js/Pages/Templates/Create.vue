<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TemplateForm from '@/Pages/Templates/Form.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'

const formData = ref({
    template_name: '',
    selectedFields: []
});

const submitForm = (emittedFormData) => {
    router.post('/add-template', emittedFormData);
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <section class="p-6 mt-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1 class="font-semibold text-xl text-gray-300 text-center">
                Create New Form Template for Clients
            </h1>
            <div class="p-10 m-15 text-gray-300 text-center">
                Manage Template
                <TemplateForm class="p-5 m-5 border-2 border-grey-400 rounded-md" :formData="formData" @submit-form="submitForm" />
            </div>
        </section>
    </AuthenticatedLayout>
</template>
