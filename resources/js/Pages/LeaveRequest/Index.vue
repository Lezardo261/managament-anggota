<template>
  <AuthenticatedLayout>
    <template #default>
      <div class="min-h-screen bg-gray-100  p-8">
        <div class="container mx-auto bg-white shadow-lg rounded-lg p-8 max-w-7xl">
          <h1 class="text-3xl font-bold text-gray-800 mb-8">Daftar Permintaan Cuti</h1>

          <table class="min-w-full bg-white border rounded-lg">
            <thead class="bg-gray-200 text-gray-600 text-left text-sm uppercase font-medium">
              <tr>
                <th class="py-4 px-6 border-b">Tanggal</th>
                <th class="py-4 px-6 border-b">Alasan</th>
                <th class="py-4 px-6 border-b">Status</th>
                <th class="py-4 px-6 border-b">Lampiran</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="request in leaveRequests" :key="request.id" class="text-gray-700">
                <td class="py-4 px-6 border-b">{{ request.leave_date }}</td>
                <td class="py-4 px-6 border-b">{{ request.reason }}</td>
                <td class="py-4 px-6 border-b">
                  <span :class="{
                    'text-green-500 font-bold': request.status === 'Approved' || request.status === 'approved',
                    'text-yellow-500 font-bold': request.status === 'Pending' || request.status === 'pending',
                    'text-red-500 font-bold': request.status === 'Rejected' || request.status === 'rejected',
                  }">
                    {{ request.status }}
                  </span>
                </td>

                <td class="py-4 px-6 border-b">
                  <a v-if="request.attachment" :href="`/storage/${request.attachment}`" target="_blank" class="text-blue-500 hover:underline">Lihat</a>
                </td>
              </tr>
            </tbody>
          </table>

          <div class="mt-8 text-right">
            <Link href="/user/leave-requests/create" class="bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 transition">Ajukan Permintaan</Link>
          </div>
        </div>
      </div>
    </template>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  leaveRequests: Array
});
</script>
