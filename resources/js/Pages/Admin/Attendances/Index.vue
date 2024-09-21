<template>
  <Head title="Attendance Data" />

  <AdminLayout>
    <div class="p-6 bg-gray-100 min-h-screen">
      <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
          <!-- Heading -->
          <h1 class="text-3xl font-semibold text-gray-800">
            Attendance Data
          </h1>

          <!-- Input Date -->
          <div class="flex items-center">
            <label for="attendance-date" class="text-gray-700 font-medium mr-3">
              Select Date:
            </label>
            <input
              type="date"
              id="attendance-date"
              v-model="selectedDate"
              class="p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            />
          </div>
        </div>

        <!-- Attendance Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead>
              <tr class="bg-blue-600 text-white uppercase text-xs sm:text-sm leading-normal">
                <th class="py-3 px-4 sm:px-6 text-left">Name</th>
                <th class="py-3 px-4 sm:px-6 text-left">Eskul Name</th>
                <th class="py-3 px-4 sm:px-6 text-left">Checked In At</th>
                <th class="py-3 px-4 sm:px-6 text-left">Photo</th>
              </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
              <tr
                v-for="attendance in filteredAttendances"
                :key="attendance.id"
                class="border-b border-gray-200 hover:bg-gray-100"
              >
                <td class="py-3 px-4 sm:px-6 text-left">{{ attendance.user?.name ?? 'N/A' }}</td>
                <td class="py-3 px-4 sm:px-6 text-left">{{ attendance.schedule?.eskul?.name ?? 'N/A' }}</td>
                <td class="py-3 px-4 sm:px-6 text-left">{{ formatDateTime(attendance.checked_in_at) }}</td>
                <td class="py-3 px-4 sm:px-6 text-left">
                  <button @click="openPhotoModal(attendance.photo_path)" v-if="attendance.photo_path">
                    <img
                      :src="`/storage/${attendance.photo_path}`"
                      alt="Attendance Photo"
                      class="h-12 w-12 sm:h-16 sm:w-16 object-cover rounded-md cursor-pointer hover:opacity-75"
                    />
                  </button>
                  <span v-else>N/A</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Modal for Viewing Photo -->
        <Teleport to="body">
          <div
            v-if="isModalOpen"
            class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
            @click.self="closePhotoModal"
          >
            <div class="relative bg-white rounded-lg p-6">
              <button @click="closePhotoModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
              <img :src="`/storage/${selectedPhoto}`" alt="Expanded Attendance Photo" class="max-w-full max-h-screen object-contain" />
            </div>
          </div>
        </Teleport>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  attendances: {
    type: Array,
    required: true
  }
});

const attendances = ref(props.attendances);

const getTodayDate = () => {
  const today = new Date();
  return today.toISOString().split('T')[0];
};

const selectedDate = ref(getTodayDate());
const isModalOpen = ref(false);
const selectedPhoto = ref('');

const openPhotoModal = (photoPath) => {
  selectedPhoto.value = photoPath;
  isModalOpen.value = true;
};

const closePhotoModal = () => {
  isModalOpen.value = false;
};

const formatDateTime = (dateTimeString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
  return new Date(dateTimeString).toLocaleDateString('id-ID', options);
};

const filteredAttendances = computed(() => {
  return attendances.value.filter(attendance => {
    const attendanceDate = new Date(attendance.checked_in_at).toISOString().split('T')[0];
    return attendanceDate === selectedDate.value;
  });
});

onMounted(() => {
  console.log('Component mounted. Attendances:', attendances.value);
  console.log('Filtered Attendances:', filteredAttendances.value);
});
</script>

<style scoped>
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(0.5);
}
</style>