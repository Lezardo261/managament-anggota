<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Task Cards -->
                <div class="px-4 sm:px-0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="task in paginatedTasks" :key="task.id" class="bg-white shadow-lg rounded-lg border border-gray-200 overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xl">
                            <div class="p-6 flex flex-col h-full">
                                <!-- Task Header -->
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ task.title }}</h3>
                                    <span class="text-sm text-gray-500">{{ task.date }}</span>
                                </div>
                                <!-- Task Description -->
                                <p class="text-gray-700 mb-4">{{ task.description }}</p>
                                <!-- Task Status -->
                                <div class="flex items-center mb-4 text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" :class="task.is_submitted ? 'text-green-500' : 'text-yellow-500'" viewBox="0 0 20 20" fill="currentColor">
                                        <path v-if="task.is_submitted" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-11h2v6h-2v-6zm0 8h2v2h-2v-2z" />
                                        <path v-else d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11h-2v6h2v-6zm-2 6v-1h2v1h-2z" />
                                    </svg>
                                    <p>Status: {{ task.is_submitted ? 'Completed' : 'Not Completed' }}</p>
                                </div>
                                <!-- Action Button -->
                                <div class="flex-grow flex items-end">
                                    <button
                                        @click="openSubmitPopup(task.id, task.description)" 
                                        :class="{
                                            'px-4 py-2 font-semibold rounded-lg transition-colors duration-300': true,
                                            'bg-blue-600 text-white hover:bg-blue-700 shadow-md': !task.is_submitted,
                                            'bg-gray-400 text-white cursor-not-allowed shadow-sm': task.is_submitted
                                        }"
                                        :disabled="task.is_submitted"
                                        class="w-full"
                                        title="Click to submit or view details"
                                    >
                                        {{ task.is_submitted ? 'Completed' : 'Submit' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination Controls -->
                <div class="mt-8 flex justify-between items-center">
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow-md hover:bg-gray-300 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M13.293 14.293a1 1 0 01-1.414 0L8 11.414 5.121 14.293a1 1 0 01-1.414-1.414L7.586 10 3.707 6.121a1 1 0 111.414-1.414L8 8.586l3.879-3.879a1 1 0 111.414 1.414L8.414 10l4.879 4.879a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2">Previous</span>
                    </button>
                    <span class="text-gray-700 text-lg">Page {{ currentPage }} of {{ totalPages }}</span>
                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow-md hover:bg-gray-300 transition-colors duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span class="mr-2">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6.707 5.707a1 1 0 011.414 0L12 8.586l3.879-3.879a1 1 0 111.414 1.414L13.414 10l4.879 4.879a1 1 0 01-1.414 1.414L12 11.414l-3.879 3.879a1 1 0 01-1.414-1.414L10.586 10 6.707 6.121a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            <TaskSubmitPopup ref="taskSubmitPopup" />
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskSubmitPopup from '@/Components/TaskSubmitPopup.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    tasks: Array,
});

const itemsPerPage = 6;
const currentPage = ref(1);

const paginatedTasks = computed(() => {
    const sortedTasks = [...props.tasks].sort((a, b) => b.id - a.id);
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return sortedTasks.slice(start, end);
});

const totalPages = computed(() => Math.ceil(props.tasks.length / itemsPerPage));

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

const taskSubmitPopup = ref(null);
const openSubmitPopup = (taskId, taskDescription) => {
    taskSubmitPopup.value.openPopup(taskId, taskDescription);
};
</script>
