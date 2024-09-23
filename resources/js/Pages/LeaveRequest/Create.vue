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
                <div class="relative mb-4">
                    <label class="block text-sm font-medium text-gray-600">Eskul</label>
                    <input 
                        type="text"
                        v-model="searchQuery"
                        @input="filterEskuls"
                        placeholder="Cari Eskul"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />
                    <transition name="fade" @enter="enter" @leave="leave">
                        <div v-if="filteredEskuls.length && searchQuery" class="absolute top-full mt-1 w-full border border-gray-300 rounded-lg bg-white shadow-lg z-10">
                            <div v-for="eskul in filteredEskuls" :key="eskul.id" class="p-2 border-b last:border-b-0 cursor-pointer hover:bg-gray-100" @click="addEskul(eskul)">
                                {{ eskul.name }}
                            </div>
                        </div>
                    </transition>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-600">Eskul Terpilih</label>
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span v-for="eskul in selectedEskuls" :key="eskul.id" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center border border-blue-300">
                                {{ eskul.name }}
                                <button @click="removeEskul(eskul)" class="ml-2 text-red-600 hover:text-red-800">×</button>
                            </span>
                        </div>
                    </div>
                    <span v-if="form.errors.eskul_id" class="text-red-600 text-sm">{{ form.errors.eskul_id }}</span>
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
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import { ref, computed, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    eskuls: Array,
});

const form = useForm({
    reason: '',
    leave_date: '',
    eskul_ids: [],
    attachment: null,
});

const searchQuery = ref('');
const filteredEskuls = ref([]);
const selectedEskuls = computed(() => {
    return props.eskuls.filter(eskul => form.eskul_ids.includes(eskul.id));
});

const filterEskuls = () => {
    if (searchQuery.value.trim()) {
        filteredEskuls.value = props.eskuls.filter(eskul =>
            eskul.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    } else {
        filteredEskuls.value = [];
    }
};

const addEskul = (eskul) => {
    if (!form.eskul_ids.includes(eskul.id)) {
        form.eskul_ids.push(eskul.id);
        searchQuery.value = '';
        filteredEskuls.value = [];
    }
};

const removeEskul = (eskul) => {
    form.eskul_ids = form.eskul_ids.filter(id => id !== eskul.id);
};

const handleFileChange = (e) => {
    form.attachment = e.target.files[0];
};

const submit = () => {
    console.log(form);
    form.post(route('leave-requests.store'));
};

watch(searchQuery, filterEskuls);

const enter = (el, done) => {
    el.style.opacity = 0;
    el.offsetHeight; // trigger reflow
    el.style.transition = 'opacity 0.2s ease';
    el.style.opacity = 1;
    done();
};

const leave = (el, done) => {
    el.style.transition = 'opacity 0.2s ease';
    el.style.opacity = 0;
    done();
};
</script>

<style scoped>
/* Styling for dropdown to avoid affecting layout */
.relative {
    position: relative;
}

.absolute {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.1);
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
}

.bg-blue-100 {
    background-color: #ebf8ff;
}

.text-blue-800 {
    color: #2b6cb0;
}
</style>
