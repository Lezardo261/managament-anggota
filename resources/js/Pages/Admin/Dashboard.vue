<template>
    <Head title="Dashboard" />
    <AdminLayout class="pt-20">
        <template #default>
            <!-- Section List User -->
            <div class="bg-white p-6 shadow rounded-lg mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold mb-4 lg:mb-0">List User</h1>
                    <div class="flex items-center w-full lg:w-auto">
                        <input
                            v-model="searchQuery"
                            type="text"
                            class="border border-gray-300 rounded-l-lg py-2 px-4 w-full lg:w-64 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="Search by Name/Email/Role"
                        />
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 w-full lg:w-auto">
                            Search
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-blue-500 text-white">
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Email</th>
                                <th class="py-3 px-6 text-left">NIS</th>
                                <th class="py-3 px-6 text-left">Kelas</th>
                                <th class="py-3 px-6 text-left">Kontak</th>
                                <th class="py-3 px-6 text-left">Role</th>
                                <th class="py-3 px-6 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-gray-100">
                                <td class="py-3 px-6">{{ user.name }}</td>
                                <td class="py-3 px-6">{{ user.email }}</td>
                                <td class="py-3 px-6">{{ user.nis }}</td>
                                <td class="py-3 px-6">{{ user.kelas }}</td>
                                <td class="py-3 px-6">{{ user.kontak }}</td>
                                <td class="py-3 px-6">{{ user.role }}</td>
                                <td class="py-3 px-6 text-center">
                                    <button @click="editUser(user.id)" class="bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500">Edit</button>
                                    <button @click="deleteUser(user.id)" class="bg-red-500 text-white px-4 py-2 rounded-lg ml-2 hover:bg-red-600">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end mt-4">
                    <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-l-lg hover:bg-gray-300">Previous</button>
                    <button @click="nextPage" :disabled="currentPage >= totalPages" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-r-lg hover:bg-gray-300">Next</button>
                </div>
            </div>

            <!-- Section User Statistics -->
            <div class="bg-white p-6 shadow rounded-lg">
                <h1 class="text-2xl font-bold mb-6">User Statistics</h1>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-green-500 text-white">
                                <th class="py-3 px-6 text-left">Name</th>
                                <th class="py-3 px-6 text-left">Attendances</th>
                                <th class="py-3 px-6 text-left">Izin</th>
                                <th class="py-3 px-6 text-left">Sakit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="stat in paginatedStats" :key="stat.user.id" class="hover:bg-gray-100">
                                <td class="py-3 px-6">{{ stat.user.name }}</td>
                                <td class="py-3 px-6">{{ stat.attendances }}</td>
                                <td class="py-3 px-6">{{ stat.izin }}</td>
                                <td class="py-3 px-6">{{ stat.sakit }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end mt-4">
                    <button @click="prevStatPage" :disabled="statPage === 1" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-l-lg hover:bg-gray-300">Previous</button>
                    <button @click="nextStatPage" :disabled="statPage >= statTotalPages" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-r-lg hover:bg-gray-300">Next</button>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>
<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';
import { router, Head } from '@inertiajs/vue3';

const searchQuery = ref('');
const props = defineProps({
    users: Array,
    userStats: Array,
});

const itemsPerPage = 10;

// List User Pagination
const currentPage = ref(1);
const paginatedUsers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredUsers.value.slice(start, end);
});
const totalPages = computed(() => Math.ceil(filteredUsers.value.length / itemsPerPage));

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

// User Statistics Pagination
const statPage = ref(1);
const paginatedStats = computed(() => {
    const start = (statPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.userStats.slice(start, end);
});
const statTotalPages = computed(() => Math.ceil(props.userStats.length / itemsPerPage));

const nextStatPage = () => {
    if (statPage.value < statTotalPages.value) statPage.value++;
};

const prevStatPage = () => {
    if (statPage.value > 1) statPage.value--;
};

const filteredUsers = computed(() => {
    if (!searchQuery.value) {
        return props.users.sort((a, b) => a.name.localeCompare(b.name));
    }

    const query = searchQuery.value.toLowerCase();
    return props.users
        .filter(user =>
            user.name.toLowerCase().includes(query) ||
            user.email.toLowerCase().includes(query) ||
            user.role.toLowerCase().includes(query)
        )
        .sort((a, b) => a.name.localeCompare(b.name));  // Sorting the filtered users by name
});


const editUser = (id) => {
    router.get(`/admin/users/${id}/edit`);
}

const deleteUser = (id) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete('/admin/users/' + id);
    }
}
</script>
