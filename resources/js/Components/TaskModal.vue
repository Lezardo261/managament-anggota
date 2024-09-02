<template>
    <transition name="fade">
        <div v-if="isVisible" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-full sm:max-w-md md:max-w-lg lg:max-w-xl">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800">Submission Details</h2>
                    <button @click="close" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="text-gray-800 space-y-2">
                    <p><strong>Nama:</strong> {{ submission.user.name }}</p>
                    <p><strong>Kelas:</strong> {{ submission.user.class }}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <p class="text-gray-700 mt-2 break-words">
                        {{ submission.submission_text }}
                    </p>
                </div>


                <!-- Multiple Image Preview with Carousel on Mobile -->
                <div v-if="files && files.length" class="mt-6">
                    <strong>File Previews:</strong>
                    <div class="block md:hidden mt-4">
                        <!-- Mobile Carousel -->
                        <div class="relative">
                            <div class="carousel-inner relative w-full overflow-hidden">
                                <div
                                    v-for="(file, index) in files"
                                    :key="index"
                                    :class="['carousel-item', { 'hidden': index !== currentSlide }]"
                                    class="relative w-full h-64 flex justify-center items-center transition-opacity duration-500 ease-in-out"
                                >
                                    <img :src="getFileUrl(file)" alt="File Preview" class="max-w-full max-h-full rounded-md shadow-md" @click="openImageViewer(getFileUrl(file))" />
                                </div>
                            </div>
                            <!-- Left Button -->
                            <button
                                @click="prevSlide"
                                class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-700 bg-opacity-50 hover:bg-opacity-75 text-white px-2 py-2 rounded-full focus:outline-none"
                            >
                                &#10094;
                            </button>
                            <!-- Right Button -->
                            <button
                                @click="nextSlide"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-700 bg-opacity-50 hover:bg-opacity-75 text-white px-2 py-2 rounded-full focus:outline-none"
                            >
                                &#10095;
                            </button>
                        </div>
                    </div>

                    <!-- Grid Display on Larger Screens -->
                    <div class="hidden md:grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-4">
                        <div v-for="(file, index) in files" :key="index" class="flex flex-col items-center">
                            <img :src="getFileUrl(file)" alt="File Preview" class="max-w-full h-auto rounded-md shadow-md" @click="openImageViewer(getFileUrl(file))" />
                        </div>
                    </div>
                </div>
                <div v-if="!files || !files.length" class="text-gray-800 mt-4">
                    <strong>Files:</strong>
                    <p>Tidak ada file yang diunggah.</p>
                </div>
            </div>
        </div>
    </transition>

    <!-- Image Viewer Modal -->
    <transition name="fade">
        <div v-if="imageViewerVisible" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
            <button @click="closeImageViewer" class="absolute top-4 right-4 text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img :src="currentImage" alt="Preview" class="max-w-full max-h-full rounded-lg shadow-lg" />
        </div>
    </transition>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    isVisible: Boolean,
    submission: Object,
});

const emit = defineEmits(['update:isVisible']);

const files = ref([]);
const currentSlide = ref(0);
const imageViewerVisible = ref(false);
const currentImage = ref('');

const close = () => {
    emit('update:isVisible', false);
};

const getFileUrl = (file) => {
    return `/storage/${file}`;
};

const decodeFiles = () => {
    if (props.submission && props.submission.file) {
        try {
            files.value = JSON.parse(props.submission.file);
        } catch (error) {
            console.error("Error parsing files:", error);
        }
    }
};

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % files.value.length;
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + files.value.length) % files.value.length;
};

const openImageViewer = (imageUrl) => {
    currentImage.value = imageUrl;
    imageViewerVisible.value = true;
};

const closeImageViewer = () => {
    imageViewerVisible.value = false;
    currentImage.value = '';
};

watch(() => props.submission, decodeFiles);
onMounted(decodeFiles);
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>