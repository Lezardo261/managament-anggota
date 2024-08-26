<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navbar -->
        <nav class="bg-blue-800 text-white py-4 fixed top-0 left-0 w-full z-50 shadow-md">
            <div class="container mx-auto flex justify-between items-center">
                <div class="text-2xl font-bold">Dashboard Admin</div>
                <ul class="flex space-x-6">
                    <li>
                        <Link href="/admin/dashboard" class="hover:text-gray-300 transition-colors duration-300">Home</Link>
                    </li>
                    <li>
                        <Link href="/admin/schedules/create" class="hover:text-gray-300 transition-colors duration-300">Buat Jadwal</Link>
                    </li>
                    <li>
                        <Link href="/admin/attendances" class="hover:text-gray-300 transition-colors duration-300">Lihat Data</Link>
                    </li>
                    <li>
                        <Link href="/admin/leave-requests" class="hover:text-gray-300 transition-colors duration-300">Lihat Pengajuan</Link>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout" class="hover:text-gray-300 transition-colors duration-300">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="">
            <div class="container mx-auto py-8">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3';

function logout() {
    router.post(route('admin.logout'));
}
</script>

<style scoped>
/* Adjust this padding according to your navbar height */
body {
    margin: 0;
    padding-top: 4rem; /* Height of the navbar */
}
</style>
