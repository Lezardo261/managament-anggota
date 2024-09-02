<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #default>
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <!-- Task Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="task in paginatedTasks" :key="task.id" class="bg-white shadow-md rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ task.title }}</h3>
                            <p class="text-gray-700 mb-4 truncate">{{ task.description }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <p>{{ task.date }}</p>
                                <button
                                    @click="openSubmitPopup(task.id, task.description)" 
                                    :class="{
                                        'px-4 py-2 font-semibold rounded-lg shadow-md transition-colors duration-300': true,
                                        'bg-blue-600 text-white hover:bg-blue-700': !task.is_submitted,
                                        'bg-green-600 text-white cursor-not-allowed': task.is_submitted
                                    }"
                                >
                                    {{ task.is_submitted ? 'Selesai' : 'Kerjakan' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination Controls -->
                <div class="mt-6 flex justify-between items-center">
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow-sm hover:bg-gray-300 transition-colors duration-300"
                    >
                        &laquo; Previous
                    </button>
                    <span class="text-gray-700">Page {{ currentPage }} of {{ totalPages }}</span>
                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg shadow-sm hover:bg-gray-300 transition-colors duration-300"
                    >
                        Next &raquo;
                    </button>
                </div>
            </div>

            <!-- Include TaskSubmitPopup Component -->
            <TaskSubmitPopup ref="taskSubmitPopup" />
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskSubmitPopup from '@/Components/TaskSubmitPopup.vue';
import { Head, router } from '@inertiajs/vue3';

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
    console.log('taskId:', taskId);
};
</script>
