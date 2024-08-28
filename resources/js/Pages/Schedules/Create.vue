<template>
  <Head title="Buat Jadwal Baru" />
  <AdminLayout>
    <template #default>
      <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
          <div>
            <h1 class="text-2xl font-bold text-center text-blue-600">Buat Jadwal Baru</h1>
          </div>
          <form @submit.prevent="submit" class="space-y-6">
            <div>
              <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
              <input
                type="text"
                v-model="form.title"
                id="title"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                placeholder="Masukkan judul"
              />
            </div>
            <div>
              <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
              <input
                type="date"
                v-model="form.date"
                id="date"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm"
              />
            </div>
            <div>
              <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
              <input
                type="time"
                v-model="form.start_time"
                id="start_time"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
              />
            </div>
            <div>
              <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
              <input
                type="time"
                v-model="form.end_time"
                id="end_time"
                required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
              />
            </div>
            <div>
              <button
                type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Buat Jadwal
              </button>
            </div>
          </form>
        </div>
      </div>
    </template>
  </AdminLayout>
</template>

<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const form = useForm({
  title: '',
  date: '',
  start_time: '',
  end_time: ''
});

const submit = () => {
  form.post(route('schedules.store'), {
    onSuccess: () => form.reset()
  });
};
</script>
<style scoped>
input[type="date"], input[type="time"], input[type="text"], input[type="month"] {
  background-color: rgb(238, 242, 247);
}
</style>
