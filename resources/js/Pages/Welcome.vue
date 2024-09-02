<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
const page = usePage();
const userIsAdmin = page.props.auth.user && page.props.auth.user.role === 'admin';
</script>

<template>
    <Head title="Selamat Datang di Aplikasi Absensi" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md px-6">
            <!-- Header -->
            <div class="text-center py-10">
                <h1 class="text-4xl font-bold text-black dark:text-white">
                    Selamat Datang di Aplikasi Absensi
                </h1>
                <p class="mt-4 text-lg text-black/70 dark:text-white/70">
                    Kelola kehadiran dan absensi anggota dengan mudah.
                </p>
            </div>

            <!-- Tombol Login dan Register -->
            <div class="mt-8 flex flex-col items-center gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="userIsAdmin ? route('admin.dashboard') : route('dashboard')"
                    class="w-full text-center py-2 px-4 bg-blue-600 text-white font-semibold rounded-md transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600"
                >
                    Masuk ke Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="w-full text-center py-2 px-4 bg-blue-600 text-white font-semibold rounded-md transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    >
                        Login
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="w-full text-center py-2 px-4 bg-gray-600 text-white font-semibold rounded-md transition hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-600"
                    >
                        Register
                    </Link>
                </template>
            </div>
        </div>
    </div>
</template>
