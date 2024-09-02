<template>
    <Head title="Izin / Sakit" />
    <AdminLayout >
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Izin/Sakit</h1>
                <label class="block">
                    <span class="text-gray-700">Select Date:</span>
                    <input type="date" v-model="selectedDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </label>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">User</th>
                            <th class="py-2 px-4 border-b">Reason</th>
                            <th class="py-2 px-4 border-b">Leave Date</th>
                            <th class="py-2 px-4 border-b">Attachment</th>
                            <th class="py-2 px-4 border-b">Status</th>
                            <th class="py-2 px-4 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="request in filteredRequests" :key="request.id" class="hover:bg-gray-100 text-center">
                            <td class="py-2 px-4 border-b">{{ request.user.name }}</td>
                            <td class="py-2 px-4 border-b">{{ request.reason }}</td>
                            <td class="py-2 px-4 border-b">{{ request.leave_date }}</td>
                            <td class="py-2 px-4 border-b ">
                                <img v-if="request.attachment" 
                                     :src="`/storage/${request.attachment}`" 
                                     alt="Attachment" 
                                     class="w-24 h-24 object-cover object-center">
                            </td>
                            <td class="py-2 px-4 border-b">{{ request.status }}</td>
                            <td class="py-2 px-4 border-b">
                                <div v-if="request.status !== 'Approved'" class="flex space-x-2 justify-center">
                                    <button @click="approveRequest(request.id)" class=" bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                        Approve
                                    </button>
                                    <button @click="rejectRequest(request.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                        Reject
                                    </button>
                                </div>
                                <div v-else>
                                    <span class="text-gray-500">Approved</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
const props = defineProps({
    leaveRequests: Array
});

const selectedDate = ref(new Date().toISOString().substr(0, 10));

const filteredRequests = computed(() => {
    return props.leaveRequests.filter(request => request.leave_date === selectedDate.value);
});

const approveRequest = (id) => {
    router.post(`/admin/leave-requests/${id}/approve`);
};

const rejectRequest = (id) => {
    router.post(`/admin/leave-requests/${id}/reject`);
};
</script>
<style scoped>
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(100%);
}
</style>