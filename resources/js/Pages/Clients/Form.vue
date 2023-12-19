
<script setup>

import {defineProps, defineEmits } from 'vue';

const { formData, templates } = defineProps({
    formData: Object,
    templates: Array
});

const emit = defineEmits(['submit-form']);

const submitForm = () => {
    emit('submit-form');
};
</script>

<template>
    <form @submit.prevent="submitForm" class="w-full max-w-md mx-auto">
        <div class="mb-4">
            <label for="client_name" class="block text-gray-700 text-sm font-bold mb-2">Client Name:</label>
            <input type="text" id="client_name" v-model="formData.client_name" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>

        <div class="mb-4">
            <label for="client_email" class="block text-gray-700 text-sm font-bold mb-2">Client Email:</label>
            <input type="email" id="client_email" v-model="formData.client_email" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>

        <div class="mb-4">
            <label for="template" class="block text-gray-700 text-sm font-bold mb-2">Select Template:</label>
            <select id="template" v-model="formData.selectedTemplate"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">None</option>
                <option v-for="template in templates" :key="template.id" :value="template.id">
                    {{ template.name }}
                </option>
            </select>
        </div>
        <div class="mb-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Submit
            </button>
        </div>
    </form>
</template>

