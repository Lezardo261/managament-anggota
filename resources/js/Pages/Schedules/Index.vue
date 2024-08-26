<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const video = ref(null)
const canvas = ref(null)
const photoData = ref('')
const selectedScheduleId = ref(null)
const userAttendances = ref([])

const props = defineProps({
  schedules: Array,
  userAttendances: Array
})

const getTodayDateTime = (time) => {
  const today = new Date()
  const dateStr = today.toISOString().split('T')[0]
  return new Date(`${dateStr}T${time}`)
}

const filteredSchedules = computed(() => {
  const now = new Date()
  return props.schedules
    .filter(schedule => {
      const endTime = getTodayDateTime(schedule.end_time)
      return endTime > now
    })
    .sort((a, b) => b.id - a.id)
})

onMounted(() => {
  userAttendances.value = props.userAttendances
})

watch(selectedScheduleId, (newVal) => {
  if (newVal !== null) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(stream => {
        video.value.srcObject = stream
      })
      .catch(err => {
        console.error("Error accessing the camera: ", err)
      })
  }
})

const takePicture = () => {
  const context = canvas.value.getContext('2d')
  context.drawImage(video.value, 0, 0, 640, 480)
  photoData.value = canvas.value.toDataURL('image/png')
}

const selectSchedule = (id) => {
  selectedScheduleId.value = id
}

const submitAttendance = () => {
  if (photoData.value && selectedScheduleId.value) {
    Inertia.post(route('attendances.store'), {
      photo: photoData.value,
      schedule_id: selectedScheduleId.value
    })
  } else {
    console.error("Photo data or schedule ID is missing")
  }
}

const isAttendanceMarked = (scheduleId) => {
  return userAttendances.value.includes(scheduleId)
}
</script>

<template>
  <Head title="Schedules" />
  <AuthenticatedLayout>
    <template #default>
      <div class="p-6 bg-gray-100 min-h-screen flex flex-col items-center">
        <div v-if="schedules.length" class="w-full max-w-3xl mb-8">
          <div
            v-for="schedule in filteredSchedules"
            :key="schedule.id"
            class="bg-white shadow-md rounded-lg p-6 mb-4 transition-transform transform hover:scale-105"
          >
            <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ schedule.title }}</h3>
            <p class="text-gray-600 mb-4">{{ schedule.start_time }} - {{ schedule.end_time }}</p>
            <button
              @click="selectSchedule(schedule.id)"
              class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition"
            >
              Select
            </button>
          </div>
        </div>
    
        <div v-if="selectedScheduleId" class="w-full max-w-3xl">
          <video
            ref="video"
            width="640"
            height="480"
            autoplay
            class="border rounded-lg shadow-lg mb-4"
          ></video>
          <button
            v-if="!isAttendanceMarked(selectedScheduleId)"
            @click="takePicture"
            class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition mb-4"
          >
            Ambil Foto
          </button>
          <canvas ref="canvas" class="hidden"></canvas>
          <button
            v-if="photoData && !isAttendanceMarked(selectedScheduleId)"
            @click="submitAttendance"
            class="bg-indigo-500 text-white py-2 px-4 rounded hover:bg-indigo-600 transition"
          >
            Submit Absensi
          </button>
          <p v-if="isAttendanceMarked(selectedScheduleId)" class="text-green-600 font-bold mt-4">
            Anda telah melakukan absensi.
          </p>
        </div>
      </div>
      
    </template>
  </AuthenticatedLayout>
</template>

<style scoped>
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
}

button {
    font-size: 1rem;
    font-weight: 600;
}

video {
    max-width: 100%;
}

@media (max-width: 768px) {
    .w-full {
        width: 100%;
    }
}
</style>
