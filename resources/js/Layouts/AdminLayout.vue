<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-4 fixed top-0 left-0 w-full z-50 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <!-- Brand -->
                <div class="text-2xl font-bold">Dashboard Admin</div>
                <!-- Menu for larger screens -->
                <ul class="hidden md:flex space-x-8">
                    <li>
                        <Link href="/admin/dashboard" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/schedules/create" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Buat Jadwal</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/attendances" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-table"></i>
                            <span>Lihat Data</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/leave-requests" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-envelope"></i>
                            <span>Lihat Pengajuan</span>
                        </Link>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
                <!-- Hamburger Menu for small screens -->
                <div class="md:hidden flex items-center">
                    <button @click="isOpen = !isOpen" class="text-white">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div v-show="isOpen" class="md:hidden fixed top-16 left-0 w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg">
                <ul class="space-y-4 py-4">
                    <li>
                        <Link href="/admin/dashboard" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105 ">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/schedules/create" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Buat Jadwal</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/attendances" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-table"></i>
                            <span>Lihat Data</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/leave-requests" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-envelope"></i>
                            <span>Lihat Pengajuan</span>
                        </Link>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="">
            <div class="container mx-auto py-8 grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const isOpen = ref(false);

function logout() {
    router.post(route('admin.logout'));
}
</script>

<style scoped>
/* Adjust this padding according to your navbar height */
body {
    margin: 0;
    padding-top: 5rem; /* Height of the navbar */
}

@media (max-width: 468px) {
    .fa-home, .fa-calendar-plus, .fa-table, .fa-envelope, .fa-sign-out-alt{
        margin-right: 10px ;
    }
}
</style>
