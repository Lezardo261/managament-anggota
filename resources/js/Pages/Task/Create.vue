<template>
    <Head title="Tugas" />
    <AdminLayout>
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Tugas</h1>            
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="eskul" class="block text-sm font-medium text-gray-700">Ekskul</label>
                    <select v-model="form.eskul_id" id="eskul"
                        class="mt-2 block w-full border border-gray-400 rounded-md shadow-sm bg-gray-100 focus:bg-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-300 transition duration-150 ease-in-out" required>
                        <option value="" disabled>Pilih Ekskul</option>
                        <option v-for="eskul in eskuls" :key="eskul.id" :value="eskul.id">{{ eskul.name }}</option>
                    </select>
                </div>
                <div>
                    <!-- <label for="title" class="block text-sm font-medium text-gray-700">Title</label> -->
                    <InputField
                    id="title"
                    type="text"
                    v-model="form.title"
                    label="Label Tugas"
                    required
                    :error="form.errors.title"
                    placeholder="Masukan task title"
                    />
                    <!-- <input v-model="form.title" id="title" type="text" placeholder="Enter task title"
                        class="mt-2 block w-full border border-gray-400 rounded-md shadow-sm bg-gray-100 focus:bg-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-300 transition duration-150 ease-in-out" required /> -->
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description" id="description" placeholder="Enter task description"
                        class="mt-2 block w-full border border-gray-400 rounded-md shadow-sm bg-gray-100 focus:bg-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-300 transition duration-150 ease-in-out" rows="4"></textarea>
                </div>
                <div>
                    <InputDate
                    id="date"
                    v-model="form.date"
                    label="Date"
                    :required="true"
                    :error="form.errors.date"
                    />
                    <!-- <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input v-model="form.date" id="date" type="date"
                        class="mt-2 block w-full border border-gray-400 rounded-md shadow-sm bg-gray-100 focus:bg-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-300 transition duration-150 ease-in-out" required /> -->
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        Create Task
                    </button>
                </div>
            </form>
        </div>
        <Notification v-if="successMessage" :message="successMessage" type="success" :duration="5000" />
        <Notification v-if="errorMessage" :message="errorMessage" type="error" :duration="5000" /> 
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '../../Layouts/AdminLayout.vue';
import InputField from '../../Components/InputField.vue';
import InputDate from '../../Components/InputDate.vue';
import Notification from '../../Components/Notification.vue';

const successMessage = ref('');
const errorMessage = ref('');


const props = defineProps({
    eskuls: Array,
});

const form = useForm({
    eskul_id: '',
    title: '',
    description: '',
    date: '',
});

const submit = () => {
    form.post(route('tasks.store'), {
        onSuccess: () => {
        successMessage.value = 'Jadwal berhasil dibuat!';
        form.reset();
        },
        onError: () => {
        errorMessage.value = 'Terjadi kesalahan saat membuat jadwal.';
        }
    });
};
</script>   