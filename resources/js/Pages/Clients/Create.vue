<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ClientForm from '@/Pages/Clients/Form.vue';
import { ref, defineProps  } from 'vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    templates: Array
});

const formData = ref({
    client_name: '',
    client_email: '',
    selectedTemplate: ''
});

const submitForm = () => {
    router.post('/add-client', formData.value);
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <section class="p-6 mt-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1 class="font-semibold text-xl text-gray-300 text-center">
                Create New Client with form template to populate
            </h1>
            <div class="p-10 m-15 text-gray-300 text-center">
                Manage Client
                <ClientForm class="p-5 m-5 border-2 border-grey-400 rounded-md" :formData="formData" :templates="props.templates" @submit-form="submitForm" />
            </div>
        </section>
    </AuthenticatedLayout>
</template>
