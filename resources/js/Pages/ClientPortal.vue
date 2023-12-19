<script setup>

import { ref } from 'vue';
import { router, Head } from '@inertiajs/vue3';

const props = defineProps({
    template_fields: Array,
    client: Object
});

const formData = ref({});
const formErrors = ref({});
props.template_fields.forEach((field) => {
    formData.value[field] = props.client[field] || '';
});

formData.value.hp_field = '';

const submitForm = () => {
    const dataToSubmit = new FormData();

    for (const [key, value] of Object.entries(formData.value)) {
        dataToSubmit.append(key, value);
    }

    router.post(`/client-portal/${props.client.access_token}/save`, dataToSubmit, {
        onSuccess: () => {
            console.log('Form submitted successfully');
            // Handle success
        },
        onError: (errors) => {
            formErrors.value = errors;
        }
    });
};

const isFileField = (fieldName) => {
    return fieldName.includes('_image') || fieldName.includes('_file');
};

const handleFileChange = (event, fieldName) => {
    const file = event.target.files[0];
    formData.value[fieldName] = file;
};

</script>

<template>
    <Head title="Client Portal" />
        <div>
            <h2 class="font-semibold text-xl text-gray-800">Client Portal</h2>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submitForm" class="space-y-4">
                            <!-- Honeypot field (hidden from users) -->
                            <input type="text" name="hp_field" style="display: none;" v-model="formData.hp_field" />
                            <div v-for="fieldName in template_fields" :key="fieldName" class="flex flex-col">
                                <label :for="fieldName" class="mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{ fieldName }}
                                </label>
                                <input v-if="!isFileField(fieldName)" type="text" :id="fieldName" v-model="formData[fieldName]"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <input v-if="isFileField(fieldName)" type="file" :id="fieldName" @change="event => handleFileChange(event, fieldName)"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
<!--                                <span class="text-red-600" v-if="formErrors.value[fieldName]">{{ formErrors.value[fieldName][0] }}</span>-->
                            </div>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>
