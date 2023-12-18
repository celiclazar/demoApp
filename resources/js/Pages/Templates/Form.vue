<script setup>

import {ref, defineEmits } from 'vue';

const emit = defineEmits(['submit-form']);
const clientFields = [
    'company_name',
    'phone',
    'email',
    'tax_id',
    'driver_licence_image',
    'payment_information'
];
const formData = ref({
    template_name: '',
    selectedFields: []
});
const submitForm = () => {
    emit('submit-form',  formData.value);
};

</script>

<template>
    <form @submit.prevent="submitForm" class="w-full max-w-md mx-auto">
        <div class="mb-4">
            <label for="template_name" class="block text-gray-700 text-sm font-bold mb-2">Template Name:</label>
            <input type="text" id="template_name" v-model="formData.template_name" required
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Select Fields:</label>
            <div v-for="field in clientFields" :key="field">
                <input type="checkbox" :id="field" :value="field" v-model="formData.selectedFields">
                <label :for="field" class="ml-2 text-gray-700">{{ field }}</label>
            </div>
        </div>

        <div class="mb-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Submit
            </button>
        </div>
    </form>
</template>

