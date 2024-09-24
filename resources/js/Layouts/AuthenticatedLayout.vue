<template>
    <div class="min-h-screen flex bg-gray-100">
        <!-- Sidebar -->
        <aside :class="{'-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen}"
               class="fixed bg-gray-800 text-gray-100 w-64 space-y-6 py-7 px-2 inset-y-0 left-0 transform lg:translate-x-0 transition duration-200 ease-in-out z-50 shadow-lg">
            <!-- Title -->
            <div class="text-center mb-8">
                <div class="text-2xl font-bold text-white">
                    Dashboard
                </div>
                <div class="text-sm font-medium text-gray-400 mt-1">
                    Welcome, {{ $page.props.auth.user.name }}
                </div>
            </div>

            <!-- Navigation -->
            <nav class="text-sm">
                <ul class="space-y-2">
                    <li>
                        <Link :href="route('dashboard')"
                              :class="{'bg-gray-900 text-white': route().current('dashboard')}"
                              class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-150">
                            <i class="fas fa-home mr-3"></i>
                            <span>Dashboard</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('schedules.user.index')"
                              :class="{'bg-gray-900 text-white': route().current('schedules.user.index')}"
                              class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-150">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            <span>Kehadiran</span>
                        </Link>
                    </li>
                    <li>
                        <Link :href="route('leave-requests.index')"
                              :class="{'bg-gray-900 text-white': route().current('leave-requests.index')}"
                              class="flex items-center px-4 py-2 hover:bg-gray-700 rounded-lg transition duration-150">
                            <i class="fas fa-clipboard-list mr-3"></i>
                            <span>Pengajuan Izin/Sakit</span>
                        </Link>
                    </li>
                </ul>
            </nav>

            <!-- User Profile Link -->
            <div class="relative px-4 border-t border-gray-700 mt-6 pt-4">
                <Link :href="route('profile.edit')" class="cursor-pointer flex items-center">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" :src="'https://ui-avatars.com/api/?name=' + $page.props.auth.user.name" :alt="$page.props.auth.user.name">
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-200">{{ $page.props.auth.user.name }}</div>
                        <div class="text-xs text-gray-400">{{ $page.props.auth.user.email }}</div>
                    </div>
                </Link>
            </div>

            <!-- Divider -->
            <div class=" pb-2 px-4 ">
                <a @click.prevent="logout"
                   class="block px-4 py-2 text-sm text-red-400 hover:bg-gray-700 rounded-lg transition duration-150 cursor-pointer">
                    <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                </a>
            </div>
        </aside>

        <!-- Mobile menu button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="toggleSidebar"
                    class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <!-- Page Content -->
        <div class="flex-1 lg:ml-64 overflow-hidden">
            <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 overflow-x-hidden">
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const isSidebarOpen = ref(window.innerWidth >= 1024);

function toggleSidebar() {
    isSidebarOpen.value = !isSidebarOpen.value;
}

function handleResize() {
    isSidebarOpen.value = window.innerWidth >= 1024;
}
function logout() {
    router.post(route('logout'));
}
onMounted(() => {
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});
</script>
