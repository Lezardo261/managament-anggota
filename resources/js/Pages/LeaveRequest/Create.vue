<template>
    <AuthenticatedLayout>
        <Head title="Request" />
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-semibold mb-6">Ajukan Sakit/Izin</h1>
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                    <select v-model="form.reason" required class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled>Select Reason</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                    </select>
                </div>
                <div>
                    <label for="leave_date" class="block text-sm font-medium text-gray-700">Leave Date</label>
                    <input type="date" v-model="form.leave_date" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>
                <div>
                    <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment (optional)</label>
                    <input type="file" @change="handleFileChange" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                </div>
                <div>
                    <button type="submit" :disabled="form.processing" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';

const form = useForm({
    reason: '',
    leave_date: '',
    attachment: null,
});

const handleFileChange = (e) => {
    form.attachment = e.target.files[0];
};

const submit = () => {
    form.post(route('leave-requests.store'));
};
</script>
