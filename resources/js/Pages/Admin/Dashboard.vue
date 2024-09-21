<template>
    <Head title="Dashboard" />
    <AdminLayout>
      <template #default>
        <!-- Admin Overview Section -->
        <div class="bg-white p-8 shadow-lg rounded-lg mb-12">
          <h1 class="text-3xl font-semibold text-gray-700 mb-4">Admin Overview</h1>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-green-600 text-white rounded-lg shadow flex items-center">
              <i class="fas fa-tasks fa-2x mr-4"></i>
              <div>
                <h2 class="text-2xl font-semibold">Total Tasks</h2>
                <p class="text-lg">{{ totalTasks }}</p>
              </div>
            </div>
            <div class="p-6 bg-yellow-600 text-white rounded-lg shadow flex items-center">
              <i class="fas fa-hourglass-half fa-2x mr-4"></i>
              <div>
                <h2 class="text-2xl font-semibold">Pending Approvals</h2>
                <p class="text-lg">{{ pendingApprovals }}</p>
              </div>
            </div>
            <div class="p-6 bg-blue-600 text-white rounded-lg shadow flex items-center">
              <i class="fas fa-calendar-day fa-2x mr-4"></i>
              <div>
                <h2 class="text-2xl font-semibold">Jadwal Hari Ini</h2>
                <p class="text-lg">
                  {{ hasScheduleToday ? 'Ada jadwal hari ini' : 'Tidak ada jadwal hari ini' }}
                </p>
              </div>
            </div>
          </div>
          <div class="mt-6 p-6 bg-gray-100 rounded-lg">
            <h2 class="text-2xl font-semibold text-gray-700">
              Eskul: 
              <span v-if="!eskuls.length">Tidak tersedia</span>
              <span v-else>
                <span class="eskul-names">
                  <span v-for="eskul in eskuls" :key="eskul.id" class="eskul-name">
                    {{ eskul.name }}
                  </span>
                </span>
              </span>
            </h2>
          </div>
        </div>
  
        <!-- Section List User -->
        <div class="bg-white p-8 shadow-lg rounded-lg mb-12">
          <div class="flex flex-col lg:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-700 mb-4 lg:mb-0 flex items-center">
              <i class="fas fa-users mr-2"></i>
              Daftar Anggota
            </h1>
            <div class="flex items-center w-full lg:w-auto">
              <input
                v-model="searchQuery"
                type="text"
                class="border border-gray-300 rounded py-2 px-4 w-full lg:w-64 focus:outline-none focus:ring-2 focus:ring-blue-600"
                placeholder="Search"
              />
            </div>
          </div>
          <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="min-w-full bg-white rounded-lg">
              <thead>
                <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                  <th class="sticky top-0 left-0 px-6 py-3 text-left font-semibold text-white bg-blue-600">Nama</th>
                  <th class="px-6 py-3 text-left font-semibold text-white">Email</th>
                  <th class="px-6 py-3 text-center font-semibold text-white">NIS</th>
                  <th class="px-6 py-3 text-center font-semibold text-white">Kelas</th>
                  <th class="px-6 py-3 text-center font-semibold text-white">Role</th>
                  <th class="px-6 py-3 text-center font-semibold text-white">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in paginatedUsers" :key="user.encrypted_id" class="border-b border-gray-200">
                  <td class="sticky left-0 bg-white px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ user.name }}</td>
                  <td class="px-6 py-4 text-gray-700">{{ user.email }}</td>
                  <td class="px-6 py-4 text-center text-gray-700">{{ user.nis }}</td>
                  <td class="px-6 py-4 text-center text-gray-700">{{ user.kelas }}</td>
                  <td class="px-6 py-4 text-center">
                    <div class="relative">
                      <select v-model="user.role" @change="updateRole(user.encrypted_id, user.role)" class="block w-full px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                      </select>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <DeleteButton :delete-route="'admin.user.destroy'" :routeParams="{ user: user.encrypted_id }" confirmMessage="Anda yakin menghapus user ini?" @deleted="handleUserDeleted(user.encrypted_id)" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="flex justify-end items-center mt-6">
            <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200">
              Previous
            </button>
            <span class="mx-4 text-gray-600 text-sm">Page {{ currentPage }} of {{ totalPages }}</span>
            <button @click="nextPage" :disabled="currentPage >= totalPages" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200">
              Next
            </button>
          </div>
        </div>
        <!-- Section User Statistics -->
        <div class="bg-white p-8 shadow-lg rounded-lg">
          <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-700 flex items-center">
              <i class="fas fa-chart-bar mr-2"></i>
              Statistik Anggota
            </h1>
            <button 
              @click="exportToExcel"
              class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 shadow flex items-center"
            >
              <i class="fas fa-file-excel mr-2"></i>
              Export
            </button>
          </div>
          <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-50 rounded-lg overflow-hidden">
              <thead>
                <tr class="bg-green-600 text-white text-sm leading-normal">
                  <th class="py-3 px-6 text-left font-semibold">Name</th>
                  <th class="py-3 px-6 text-center font-semibold">Kehadiran</th>
                  <th class="py-3 px-6 text-center font-semibold">Izin</th>
                  <th class="py-3 px-6 text-center font-semibold">Sakit</th>
                </tr>
              </thead>
              <tbody class="text-gray-600 text-sm font-light">
                <tr v-for="stat in paginatedStats" :key="stat.user.id" class="border-b border-gray-200 hover:bg-gray-100 transition duration-150">
                  <td class="py-4 px-6 text-left whitespace-nowrap">
                    <span class="font-medium">{{ stat.user.name }}</span>
                  </td>
                  <td class="py-4 px-6 text-center">{{ stat.attendances }}</td>
                  <td class="py-4 px-6 text-center">{{ stat.izin }}</td>
                  <td class="py-4 px-6 text-center">{{ stat.sakit }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="flex justify-end items-center mt-6">
            <button @click="prevStatPage" :disabled="statPage === 1" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200">
              Previous
            </button>
            <span class="mx-4 text-gray-600 text-sm">Page {{ statPage }} of {{ statTotalPages }}</span>
            <button @click="nextStatPage" :disabled="statPage >= statTotalPages" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-200">
              Next
            </button>
          </div>
        </div>
      </template>
    </AdminLayout>
</template>
  
  

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';
import { router, Head } from '@inertiajs/vue3';
import DeleteButton from '../../Components/DeleteButton.vue';

const searchQuery = ref('');
const props = defineProps({
    users: Array,       
    userStats: Array,   
    totalTasks: Number,
    pendingApprovals: Number,
    hasScheduleToday: Boolean,
    eskuls: Object
});

const itemsPerPage = 10;

const updateRole = (encryptedId, newRole) => {
    router.put(route('admin.user.updateRole', encryptedId), { role: newRole });
};

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

const statPage = ref(1);
const sortedStats = computed(() => {
    return props.userStats.sort((a, b) => a.user.name.localeCompare(b.user.name));
});

const paginatedStats = computed(() => {
    const start = (statPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return sortedStats.value.slice(start, end);
});

const statTotalPages = computed(() => Math.ceil(sortedStats.value.length / itemsPerPage));

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
            user.role.toLowerCase().includes(query) ||
            (user.nis && user.nis.toString().toLowerCase().includes(query)) ||  // Filter by NIS
            (user.kelas && user.kelas.toLowerCase().includes(query))            // Filter by Kelas
        )
        .sort((a, b) => a.name.localeCompare(b.name));
});


// Export to Excel function
function exportToExcel() {
    window.location.href = route('admin.exportUserStats');
}

const handleUserDeleted = (deletedId) => {
    users = users.filter(user => user.encrypted_id !== deletedId);
};
</script>

