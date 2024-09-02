<template>
    <Head title="Tugas" />
    <AdminLayout >
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Tugas</h1>            
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input v-model="form.title" id="title" type="text" placeholder="Enter task title"
                        class="mt-2 block w-full border border-gray-400 rounded-md shadow-sm bg-gray-100 focus:bg-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-300 transition duration-150 ease-in-out" required />
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="form.description" id="description" placeholder="Enter task description"
                        class="mt-2 block w-full border border-gray-400 rounded-md shadow-sm bg-gray-100 focus:bg-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-300 transition duration-150 ease-in-out" rows="4"></textarea>
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input v-model="form.date" id="date" type="date"
                        class="mt-2 block w-full border border-gray-400 rounded-md shadow-sm bg-gray-100 focus:bg-gray-200 focus:border-blue-600 focus:ring focus:ring-blue-300 transition duration-150 ease-in-out" required />
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from '../../Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    date: '',
});

const submit = () => {
    form.post(route('tasks.store'), {
        onSuccess: () => {
            form.reset();
        }
    });
};

</script>
<style scoped>
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(100%);
}
</style>