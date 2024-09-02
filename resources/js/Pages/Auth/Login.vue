<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md px-8 py-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Masuk ke Akun Anda</h2>

            <form @submit.prevent="submit" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />
                    <span v-if="form.errors.email" class="text-red-600 text-sm">{{ form.errors.email }}</span>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-200 focus:border-blue-500"
                    />
                    <span v-if="form.errors.password" class="text-red-600 text-sm">{{ form.errors.password }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-600">
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            class="mr-2 leading-tight"
                        />
                        <span>Ingat Saya</span>
                    </label>
                    
                    <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-blue-600 hover:underline">
                        Lupa Password?
                    </Link>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        :class="{'opacity-50': form.processing}"
                        class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
