<template>
    <div class="min-h-screen flex bg-gray-100">
        <!-- Sidebar -->
        <aside :class="{'-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen}" class="bg-gray-900 text-white w-64 space-y-6 py-7 px-4 absolute inset-y-0 left-0 transform lg:transform-none lg:relative transition duration-300 ease-in-out z-50 shadow-lg">
            <!-- Enhanced Title -->
            <div class="text-center mb-10">
                <div class="text-4xl font-extrabold bg-clip-text ">
                    Dashboard
                </div>
                <div class="text-sm font-medium text-gray-400 mt-1">
                    Welcome back, {{ $page.props.auth.user.name }}!
                </div>
            </div>

            <!-- Navigation -->
            <nav class="font-medium">
                <ul class="space-y-4">
                    <li>
                        <Link href="/user/dashboard" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-300">
                            <i class="fas fa-home mr-3"></i>
                            Dashboard
                        </Link>
                    </li>
                    <li>
                        <Link href="/user/schedules" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-300">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Jadwal
                        </Link>
                    </li>
                    <li>
                        <Link href="/user/leave-requests" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-300">
                            <i class="fas fa-clipboard-list mr-3"></i>
                            Pengajuan Izin/Sakit
                        </Link>
                    </li>
                </ul>
            </nav>

            <!-- User Dropdown Menu -->
            <div class="pt-4 pb-1 border-t border-gray-700 mt-6">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-200">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="font-medium text-sm text-gray-400">{{ $page.props.auth.user.email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <Link :href="route('profile.edit')" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-300">
                        <i class="fas fa-user-edit mr-3"></i>
                        Profile
                    </Link>
                    <a href="#" @click.prevent="logout" class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-300">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Log Out
                    </a>
                </div>
            </div>
        </aside>

        <!-- Mobile menu button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="toggleSidebar" class="text-gray-900 focus:outline-none">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <!-- Page Content -->
        <div class="flex-1 pt-16 lg:pt-8 px-4 lg:pl-6">
            <div class="container mx-auto py-4">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const isSidebarOpen = ref(false);

function toggleSidebar() {
    isSidebarOpen.value = !isSidebarOpen.value;
}

function logout() {
    router.post(route('logout'));
}
</script>

<style scoped>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
}

@media (min-width: 1024px) {
    aside {
        width: 16rem;
    }
    .flex-1 {
        padding-left: 1rem;
    }
}
</style>
