<template>
    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md px-8 py-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Daftar Akun Baru</h2>

            <!-- Global Error Messages -->
            <Notification
                v-for="(error, index) in globalErrors"
                :key="index"
                :message="error"
                type="error"
                :duration="5000"
            />

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div 
                        class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                        :style="{ width: `${progress}%` }"
                    ></div>
                </div>
                <div class="flex justify-between text-sm text-gray-600 mt-1">
                    <span>Langkah 1</span>
                    <span>Langkah 2</span>
                </div>
            </div>

            <!-- Step 1: Name, Email, NIS, Kelas -->
            <form v-if="currentStep === 1" @submit.prevent="nextStep" class="space-y-5">
                <InputField
                    id="name"
                    type="text"
                    v-model="form.name"
                    label="Nama Lengkap"
                    required
                    :error="form.errors.name"
                    autocomplete="name"
                />

                <InputField
                    id="email"
                    type="email"
                    v-model="form.email"
                    label="Email"
                    required
                    :error="form.errors.email"
                    autocomplete="username"
                />

                <InputField
                    id="nis"
                    type="number"
                    v-model="form.nis"
                    label="NIS"
                    required
                    :error="form.errors.nis"
                />

                <InputField
                    id="kelas"
                    type="text"
                    v-model="form.kelas"
                    label="Kelas"
                    required
                    placeholder="Contoh: XI PPL 1"
                    :error="form.errors.kelas"
                />

                <div>
                    <button 
                        type="submit" 
                        class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                        Lanjut
                    </button>
                </div>
            </form>

            <!-- Step 2: Eskul, Password, Confirm Password -->
            <form v-if="currentStep === 2" @submit.prevent="submit" class="space-y-5">
                <!-- Eskul Search and Select -->
                <div class="relative mb-4">
                    <label class="block text-sm font-medium text-gray-600">Eskul</label>
                    <input 
                        type="text"
                        v-model="searchQuery"
                        @input="filterEskuls"
                        placeholder="Cari Eskul"
                        class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />

                    <!-- Daftar Pilihan Eskul -->
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

                <InputField
                    id="password"
                    type="password"
                    v-model="form.password"
                    label="Password"
                    required
                    autocomplete="new-password"
                    :error="form.errors.password"
                />

                <InputField
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    label="Konfirmasi Password"
                    required
                    autocomplete="new-password"
                    :error="form.errors.password_confirmation"
                />

                <div class="flex justify-between">
                    <button 
                        type="button" 
                        @click="prevStep"
                        class="w-full px-4 py-2 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    >
                        Kembali
                    </button>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        :class="{'opacity-50': form.processing}"
                        class="w-full px-4 py-2 ml-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                        Daftar
                    </button>
                </div>
            </form>

            <!-- Already Registered -->
            <div class="text-center text-sm text-gray-600 mt-4">
                <span>Sudah memiliki akun?</span>
                <Link :href="route('login')" class="text-blue-600 hover:underline ml-1">Masuk</Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import Notification from '../../Components/Notification.vue';
import InputField from '../../Components/InputField.vue';

const props = defineProps({
    eskuls: Array, // Pastikan ini adalah array
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
    nis: '',
    kelas: '',
    eskul_id: [], // Array untuk menyimpan ID eskul yang dipilih
});

// Ref for global error messages
const globalErrors = ref([]);
const currentStep = ref(1);
const totalSteps = 2;
const searchQuery = ref('');
const filteredEskuls = ref([]);
const selectedEskuls = computed(() => {
    return props.eskuls.filter(eskul => form.eskul_id.includes(eskul.id));
});

const progress = computed(() => {
    return (currentStep.value / totalSteps) * 100;
});

const nextStep = () => {
    if (currentStep.value < totalSteps) {
        currentStep.value += 1;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value -= 1;
    }
};

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
    if (!form.eskul_id.includes(eskul.id)) {
        form.eskul_id.push(eskul.id);
        searchQuery.value = ''; // Clear search input
        filteredEskuls.value = []; // Hide dropdown
    }
};

const removeEskul = (eskul) => {
    form.eskul_id = form.eskul_id.filter(id => id !== eskul.id);
};

const submit = () => {
    globalErrors.value = [];

    form.post(route('register'), {
        onFinish: () => {
            console.log('Form submitted successfully');
            form.reset('password', 'password_confirmation');
        },
        onError: (errors) => {
            console.log('Form submission error:', errors);
            globalErrors.value = Object.values(errors); // Capture all error messages
        }
    });
};

// Watch searchQuery to update filteredEskuls
watch(searchQuery, filterEskuls);

// Transition effect for dropdown
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
    top: 100%; /* Adjusts position below the input */
    left: 0;
    width: 100%;
    max-height: 200px; /* Optional: Limits dropdown height */
    overflow-y: auto; /* Optional: Adds scroll if content exceeds max height */
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