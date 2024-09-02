<template>
    <Head title="Task Submissions" />
    <AdminLayout>
        <div class="min-h-screen bg-gray-100 py-12 px-6">
            <div class="max-w-7xl mx-auto space-y-12">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <div class="flex items-center space-x-3">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <h1 class="text-3xl font-semibold text-gray-800">Task Submissions</h1>
                    </div>
                    <select v-model="selectedTask" @change="fetchSubmissions" class="mt-4 sm:mt-0 w-full sm:w-72 border border-gray-300 rounded-lg p-3 text-base bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled>Select a Task</option>
                        <option v-for="task in sortedTasks" :key="task.id" :value="task.id">
                            {{ task.title }}
                        </option>
                    </select>
                </div>

                <!-- Submission List -->
                <div v-if="submissions.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="submission in submissions" 
                        :key="submission.id" 
                        class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg  border border-gray-200 transform hover:-translate-y-1 hover:scale-105 transition-transform"
                    >
                        <div class="flex justify-between items-center mb-3">
                            <h2 class="text-lg font-semibold text-gray-900 truncate">
                                {{ submission.user.name }}
                            </h2>
                            <span class="text-xs text-white bg-blue-500 px-3 py-1 rounded-full">
                                {{ submission.user.class }}
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-6 line-clamp-3">
                            {{ submission.submission_text || 'No description provided.' }}
                        </p>
                        <div class="flex justify-between items-center">
                            <button 
                                @click="openModal(submission)" 
                                class="bg-blue-600 text-white text-sm py-2 px-4 rounded-lg hover:bg-blue-500 transition"
                            >
                                View Details
                            </button>
                            <span class="text-xs text-gray-400">
                                {{ new Date(submission.created_at).toLocaleDateString() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- No Submissions Message -->
                <div v-else class="text-center py-24">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6m2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-xl font-medium text-gray-600">No submissions found for the selected task.</p>
                </div>
            </div>

            <!-- Modal Component -->
            <TaskModal 
                :isVisible="isModalVisible" 
                :submission="selectedSubmission" 
                @update:isVisible="isModalVisible = $event" 
            />
        </div>
    </AdminLayout>
</template>
<script setup>
import { ref, computed } from 'vue';
import { usePage, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TaskModal from '../../Components/TaskModal.vue';
import axios from 'axios';

const { tasks } = usePage().props;
const selectedTask = ref('');
const submissions = ref([]);
const selectedSubmission = ref(null);
const isModalVisible = ref(false);
const isLoading = ref(false);

// Sort tasks by ID in descending order
const sortedTasks = computed(() => {
    return [...tasks].sort((a, b) => b.id - a.id);
});

const fetchSubmissions = async () => {
    if (selectedTask.value) {
        isLoading.value = true;
        try {
            const response = await axios.get(`/admin/tasks/${selectedTask.value}/submissions`);
            submissions.value = response.data.submissions.map(submission => ({
                ...submission,
                files: submission.files ? submission.files.split(',') : []
            }));
            selectedSubmission.value = null; // Reset selectedSubmission when fetching new data
        } catch (error) {
            console.error("Error fetching submissions:", error);
        } finally {
            isLoading.value = false;
        }
    } else {
        submissions.value = [];
        selectedSubmission.value = null;
    }
};

const openModal = (submission) => {
    selectedSubmission.value = submission;
    isModalVisible.value = true;
};
</script>

<style scoped>
/* Additional styling for the card layout */
.grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
}

h2.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

button {
    transition: all 0.3s ease;
}
</style>
