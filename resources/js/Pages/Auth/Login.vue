<template>
    <Head title="Log in" />

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md px-8 py-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Masuk ke Akun Anda</h2>

            <form @submit.prevent="submit" class="space-y-5">
                <div>
                    <InputField
                    id="email"
                    type="email"
                    v-model="form.email"
                    label="Email"
                    required
                    :error="form.errors.email"
                    autocomplete="email"
                    />
                </div>

                <div>
                    <InputField
                    id="password"
                    type="password"
                    v-model="form.password"
                    label="Password"
                    required
                    :error="form.errors.password"
                    autocomplete="current-password"
                    />  
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
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputField from '../../Components/InputField.vue';

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
