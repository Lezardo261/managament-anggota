<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-4 fixed top-0 left-0 w-full z-50 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-4">
                <!-- Brand -->
                <div class="text-2xl font-bold flex items-center space-x-2">
                    <i class="fas fa-user-shield"></i>
                    <span>Dashboard</span>
                </div>
                <!-- Menu for larger screens -->
                <ul class="hidden md:flex space-x-8 items-center">
                    <!-- Home Dropdown -->
                    <li class="relative group">
                        <div class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105 cursor-pointer">
                            <i class="fas fa-home"></i>
                            <span class="hidden md:inline">Home</span>
                        </div>
                        <div class="absolute left-0 mt-1 w-48 bg-white text-gray-700 rounded-lg shadow-lg py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <Link href="/admin/dashboard" class="block px-4 py-2 hover:bg-gray-100">
                                Home Admin
                            </Link>
                            <Link href="/admin/user/dashboard" class="block px-4 py-2 hover:bg-gray-100">
                                Home User
                            </Link>
                        </div>
                    </li>
                    <!-- Buat Dropdown -->
                    <li class="relative group">
                        <div class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105 cursor-pointer">
                            <i class="fas fa-calendar-plus"></i>
                            <span class="hidden md:inline">Buat</span>
                        </div>
                        <div class="absolute left-0 mt-1 w-48 bg-white text-gray-700 rounded-lg shadow-lg py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <Link href="/admin/schedules/create" class="block px-4 py-2 hover:bg-gray-100">
                                Buat Kehadiran
                            </Link>
                            <Link href="/admin/tasks/create" class="block px-4 py-2 hover:bg-gray-100">
                                Buat Tugas
                            </Link>
                        </div>
                    </li>
                    <li>
                        <Link href="/admin/attendances" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-table"></i>
                            <span class="hidden md:inline">Absensi</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/leave-requests" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-envelope"></i>
                            <span class="hidden md:inline">Sakit/Izin</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/tasks" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-tasks"></i>
                            <span class="hidden md:inline">Tugas</span>
                        </Link>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout" class="flex items-center space-x-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-out-alt text-lg"></i>
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
                    <!-- Mobile Home Dropdown -->
                    <li>
                        <Link href="/admin/dashboard" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-home mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Home Admin</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/user/dashboard" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-home mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Home User</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/schedules/create" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-calendar-plus mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Buat Kehadiran</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/tasks/create" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-calendar-plus mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Buat Tugas</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/attendances" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-table mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Absensi</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/leave-requests" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-envelope mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Izin/Sakit</span>
                        </Link>
                    </li>
                    <li>
                        <Link href="/admin/tasks" class="block px-4 py-2 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-tasks mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Tugas</span>
                        </Link>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout" class="block px-4 py-4 hover:text-gray-300 transition-transform duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-out-alt text-lg mr-2"></i> <!-- Menambahkan mr-2 -->
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>

        </nav>

        <!-- Page Content -->
        <div class="pt-16">
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
body {
    margin: 0;
    padding-top: 5rem;
}

.navbar {
    background: linear-gradient(to right, #1e3a8a, #3b82f6); /* Gradient background */
}

.navbar a {
    color: white;
}

@media (max-width: 768px) {
    .navbar {
        background: linear-gradient(to right, #1e3a8a, #3b82f6);
    }
}

i.fas {
    font-size: 1.25rem;
}
</style>
