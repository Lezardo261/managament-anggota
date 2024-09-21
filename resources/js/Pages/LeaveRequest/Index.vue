<template>
  <Head title="Daftar Izin/Sakit" />
  <AuthenticatedLayout class="bg-gray-100">
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="p-6 sm:px-8 bg-white border-b border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
              <h1 class="text-2xl font-bold text-gray-900 mb-4 sm:mb-0">
                Daftar Izin/Sakit
              </h1>
              <Link
                href="/user/leave-requests/create"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Ajukan
              </Link>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
              <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                  <tr class="text-left">
                    <th class="bg-blue-600 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs text-white">Tanggal</th>
                    <th class="bg-blue-600 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs text-white">Alasan</th>
                    <th class="bg-blue-600 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs text-white">Eskul</th>
                    <th class="bg-blue-600 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs text-white">Status</th>
                    <th class="bg-blue-600 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs text-white text-center">Lampiran</th>
                    <th class="bg-blue-600 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs text-white">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="request in leaveRequests" :key="request.id" class="hover:bg-gray-100 transition-colors duration-200">
                    <td class="border-dashed border-t border-gray-200 px-6 py-4">{{ request.leave_date }}</td>
                    <td class="border-dashed border-t border-gray-200 px-6 py-4">{{ request.reason }}</td>
                    <td class="border-dashed border-t border-gray-200 px-6 py-4">
                      <span v-for="eskul in request.eskuls" :key="eskul.id" class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2 mb-2">{{ eskul.name }}</span>
                    </td>
                    <td class="border-dashed border-t border-gray-200 px-6 py-4">
                      <span :class="statusClass(request.status)" class="py-1 px-3 rounded-full text-xs">
                        {{ request.status }}
                      </span>
                    </td>
                    <td class="border-dashed border-t border-gray-200 px-6 py-4 flex justify-center items-center text-center">
                      <a v-if="request.attachment" :href="`/storage/${request.attachment}`" target="_blank" class="text-blue-600 hover:text-blue-900 transition duration-200 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                      </a>
                    </td>
                    <td class="border-dashed border-t border-gray-200 px-6 py-4">
                      <DeleteButton 
                        :deleteRoute="'leave-requests.destroy'"
                        :routeParams="{ id: request.id }"
                        confirmMessage="Are you sure you want to delete this leave request?"
                        @deleted="handleDeleted"
                        class="text-red-600 hover:text-red-900 transition duration-200 ease-in-out"
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import DeleteButton from '../../Components/DeleteButton.vue';

const props = defineProps({
  leaveRequests: Array
});

const statusClass = (status) => {
  const statusLower = status.toLowerCase();
  switch (statusLower) {
    case 'approved':
      return 'bg-green-100 text-green-800';
    case 'pending':
      return 'bg-yellow-100 text-yellow-800';
    case 'rejected':
      return 'bg-red-100 text-red-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
};
</script>