<template>
    <teleport to="body">
        <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-semibold mb-4">Tugas</h2>
                <p class="text-gray-700 mb-4 whitespace-normal">{{ taskDescription }}</p> <!-- Tambahkan whitespace-normal -->
                 <form @submit.prevent="submitTask">
                    <div class="mb-4">
                        <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                        <textarea v-model="submissionText" id="answer" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="files" class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <input @change="handleFileUpload" id="files" type="file" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"/>
                    </div>
                    <div v-if="previewImages.length" class="mb-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                        <div class="flex flex-wrap gap-2">
                            <div v-for="(src, index) in previewImages" :key="index" class="border rounded-lg overflow-hidden w-24 h-24">
                                <img :src="src" alt="Image Preview" class="w-full h-full object-cover" />
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button @click="closePopup" type="button" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md mr-2">Cancel</button>
                        <button type="submit" :disabled="isSubmitting" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                            {{ isSubmitting ? 'Submitting...' : 'Submit' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </teleport>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const visible = ref(false);
const submissionText = ref('');
const files = ref([]);
const previewImages = ref([]);
const taskId = ref(null);
const isSubmitting = ref(false);
const taskDescription = ref('');

const openPopup = (id, description) => {
    taskId.value = id;
    taskDescription.value = description;
    visible.value = true;
};

const closePopup = () => {
    visible.value = false;
    submissionText.value = '';
    files.value = [];
    previewImages.value = [];
    isSubmitting.value = false;
};

const handleFileUpload = (event) => {
    const selectedFiles = Array.from(event.target.files);
    files.value = selectedFiles;

    previewImages.value = [];
    selectedFiles.forEach(file => {
        if (file.type.startsWith('image/')) {
            previewImages.value.push(URL.createObjectURL(file));
        }
    });
};

const submitTask = () => {
    if (isSubmitting.value) return;
    isSubmitting.value = true;

    const formData = new FormData();
    formData.append('submission_text', submissionText.value);
    files.value.forEach((file, index) => {
        formData.append(`files[${index}]`, file);
    });
    formData.append('task_id', taskId.value);

    router.post('/user/tasks/submit', formData, {
        onFinish: closePopup,
    });
};

defineExpose({ openPopup });
</script>
<style scoped>
.text-gray-700 {
    white-space: normal; 
    word-break: break-word; 
}
</style>
