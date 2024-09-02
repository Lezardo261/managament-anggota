<template>
  <Head title="Daftar Izin/Sakit" />
  <AuthenticatedLayout class="overflow-x-hidden">
    <template #default>
      <div class="min-h-screen bg-gray-100 p-4 md:p-8">
        <div class="container mx-auto bg-white shadow-lg rounded-lg p-4 md:p-8 max-w-7xl  ">
          <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8">Daftar Izin/Sakit</h1>

          <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-50 border rounded-lg">
              <thead class="bg-blue-600 text-white text-center text-xs md:text-sm uppercase font-semibold">
                <tr>
                  <th class="py-2 px-4 md:py-4 md:px-6 border-b">Tanggal</th>
                  <th class="py-2 px-4 md:py-4 md:px-6 border-b">Alasan</th>
                  <th class="py-2 px-4 md:py-4 md:px-6 border-b text-center">Status</th>
                  <th class="py-2 px-4 md:py-4 md:px-6 border-b">Lampiran</th>
                  <th class="py-2 px-4 md:py-4 md:px-6 border-b text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="text-center text-xs md:text-sm">
                <tr v-for="request in leaveRequests" :key="request.id" class="text-gray-700 hover:bg-blue-50 transition">
                  <td class="py-2 px-4 md:py-4 md:px-6 border-b">{{ request.leave_date }}</td>
                  <td class="py-2 px-4 md:py-4 md:px-6 border-b">{{ request.reason }}</td>
                  <td class="py-2 px-4 md:py-4 md:px-6 border-b text-center">
                    <span :class="{
                      'bg-green-100 text-green-800 font-semibold py-1 px-2 rounded': request.status === 'Approved' || request.status === 'approved',
                      'bg-yellow-100 text-yellow-800 font-semibold py-1 px-2 rounded': request.status === 'Pending' || request.status === 'pending',
                      'bg-red-100 text-red-800 font-semibold py-1 px-2 rounded': request.status === 'Rejected' || request.status === 'rejected',
                    }">
                      {{ request.status }}
                    </span>
                  </td>

                  <td class="py-2 px-4 md:py-4 md:px-6 border-b">
                    <a v-if="request.attachment" :href="`/storage/${request.attachment}`" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                  </td>
                  <td class="py-2 px-4 md:py-4 md:px-6 border-b">
                    <div class="flex justify-center">
                      <button 
                        @click="deleteRequest(request.id)"
                        class="bg-red-500 text-white py-1 px-2 md:py-2 md:px-4 rounded-lg hover:bg-red-600 transition"
                      >
                        Hapus
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mt-6 md:mt-8 text-right">
            <Link href="/user/leave-requests/create" class="bg-blue-500 text-white py-2 px-4 md:py-3 md:px-6 rounded-lg hover:bg-blue-600 transition">Ajukan</Link>
          </div>
        </div>
      </div>
    </template>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link, router, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  leaveRequests: Array
});

const deleteRequest = (id) => {
  if (confirm('Apakah Anda yakin ingin menghapus permintaan ini?')) {
    router.delete('/user/leave-requests/' + id);
  }
};
</script>

<style>
@media (max-width: 468px) {
  .max-w-7xl{
    max-width: 80%;
    margin-left: -10px;
  }
}
</style>
