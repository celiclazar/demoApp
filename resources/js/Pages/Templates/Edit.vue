<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed  } from 'vue';
import { router } from '@inertiajs/vue3';

const clientFields = [
    'company_name',
    'phone',
    'email',
    'tax_id',
    'driver_licence_image',
    'document_file',
    'payment_information'
];

const props = defineProps({
    template: Object
});

const selectedFields = computed(() => {
    return JSON.parse(props.template.fields);
});

const templateData = ref({
    name: props.template.name,
    selectedFields: selectedFields.value
});


const submitUpdate = () => {
    router.put(`/templates/${props.template.id}`, {
        name: templateData.value.name,
        fields: JSON.stringify(templateData.value.selectedFields)
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-md mx-auto">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Template</h2>
            <form @submit.prevent="submitUpdate">
                <div class="mb-4">
                    <label for="template_name" class="block text-gray-700 text-sm font-bold mb-2">Template Name:</label>
                    <input type="text" id="template_name" v-model="templateData.name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Fields:</label>
                    <div v-for="field in clientFields" :key="field">
                        <input type="checkbox" :id="field" :value="field" v-model="templateData.selectedFields">
                        <label :for="field" class="ml-2 text-gray-700">{{ field }}</label>
                    </div>
                </div>

                <div class="mb-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Update Template
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

