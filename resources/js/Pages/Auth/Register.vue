<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md px-8 py-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Daftar Akun Baru</h2>

            <form @submit.prevent="submit" class="space-y-5">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                    <input 
                        id="name" 
                        type="text" 
                        v-model="form.name" 
                        required 
                        autofocus 
                        autocomplete="name"
                        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />
                    <span v-if="form.errors.name" class="text-red-600 text-sm">{{ form.errors.name }}</span>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input 
                        id="email" 
                        type="email" 
                        v-model="form.email" 
                        required 
                        autocomplete="username"
                        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />
                    <span v-if="form.errors.email" class="text-red-600 text-sm">{{ form.errors.email }}</span>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input 
                        id="password" 
                        type="password" 
                        v-model="form.password" 
                        required 
                        autocomplete="new-password"
                        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />
                    <span v-if="form.errors.password" class="text-red-600 text-sm">{{ form.errors.password }}</span>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">Konfirmasi Password</label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        v-model="form.password_confirmation" 
                        required 
                        autocomplete="new-password"
                        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />
                    <span v-if="form.errors.password_confirmation" class="text-red-600 text-sm">{{ form.errors.password_confirmation }}</span>
                </div>

                <!-- Register Button -->
                <div>
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        :class="{'opacity-50': form.processing}"
                        class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                        Daftar
                    </button>
                </div>

                <!-- Already Registered -->
                <div class="text-center text-sm text-gray-600 mt-4">
                    <span>Sudah memiliki akun?</span>
                    <Link :href="route('login')" class="text-blue-600 hover:underline ml-1">Masuk</Link>
                </div>
            </form>
        </div>
    </div>
</template>