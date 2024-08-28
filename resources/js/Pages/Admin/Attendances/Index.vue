<template>
  <Head title="Data Absensi" />
    <AdminLayout class="pt-20">
      <template #default>
        <div class="p-6 bg-gray-100 min-h-screen">
          <h1 class="text-2xl font-bold mb-4">Data Absensi</h1>
          
          <!-- Input tanggal dan tombol filter -->
          <div class="mb-4">
            <label for="filter-date" class="mr-2">Filter Tanggal:</label>
            <input
              type="date"
              id="filter-date"
              v-model="selectedDate"
              class="p-2 border rounded"
            />
            <button
              @click="filterByDate"
              class="ml-2 px-4 py-2 bg-blue-500 text-white rounded"
            >
              Filter
            </button>
          </div>
  
          <table class="min-w-full bg-white">
            <thead>
              <tr>
                <th class="py-2 px-4 border-b">Nama Pengguna</th>
                <th class="py-2 px-4 border-b">Deskripsi</th>
                <th class="py-2 px-4 border-b">Waktu Absen</th>
                <th class="py-2 px-4 border-b">Foto</th>
              </tr>
            </thead>
            <tbody class="text-center text-xs md:text-sm ">
              <tr v-for="attendance in filteredAttendances" :key="attendance.id">
                <td class="py-2 px-4 border-b">{{ attendance.user_name }}</td>
                <td class="py-2 px-4 border-b">{{ attendance.schedule_title }}</td>
                <td class="py-2 px-4 border-b">{{ attendance.created_at }}</td>
                <td class="py-2 px-4 border-b text-center">
                  <img :src="`/storage/${attendance.photo_path}`" alt="Photo" class="h-16 w-16 object-cover mx-auto">
                </td>

              </tr>
            </tbody>
          </table>
        </div>
      </template>
    </AdminLayout>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import { Head } from '@inertiajs/vue3';
  const props = defineProps({
    attendances: Array,
  });
  
  const getTodayDate = () => {
    const today = new Date();
    return today.toISOString().split('T')[0];
  };
  
  const selectedDate = ref(getTodayDate());
  
  const filteredAttendances = computed(() => {
    const dateToFilter = selectedDate.value || getTodayDate();
    return props.attendances.filter(attendance => {
      const attendanceDate = attendance.created_at.split(' ')[0];
      return attendanceDate === dateToFilter;
    });
  });
  
  const filterByDate = () => {
    // Filter logic handled by computed property
  };
  
  onMounted(() => {
    document.getElementById('filter-date').value = selectedDate.value;
  });
  </script>
  