<template>
  <Head title="Schedules" />
  <AuthenticatedLayout>
    <template #default>
      <div class="p-6 bg-gray-100 min-h-screen flex flex-col items-center">
        <!-- Display message if no schedules are available -->
        <div v-if="!schedules.length" class="text-center text-gray-600 text-lg font-medium">
          Tidak ada jadwal
        </div>

        <!-- Display schedules if they are available -->
        <div v-if="schedules.length" class="w-full max-w-3xl mb-8">
          <div
            v-for="schedule in filteredSchedules"
            :key="schedule.id"
            class="bg-white shadow-md rounded-lg p-6 mb-4 transition-transform transform hover:scale-105"
          >
            <h3 class="text-2xl font-semibold text-gray-800 mb-2">{{ schedule.title }}</h3>
            <p class="text-gray-600 mb-4">{{ schedule.start_time }} - {{ schedule.end_time }}</p>
            <button
              v-if="!isAttendanceMarked(schedule.id)"
              @click="selectSchedule(schedule.id)"
              class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition"
            >
              Select
            </button>
          </div>
        </div>

        <Teleport to="body">
          <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
              <h2 class="text-2xl font-bold mb-4">Take Attendance</h2>
              <video
                ref="video"
                width="640"
                height="480"
                autoplay
                class="border rounded-lg shadow-lg mb-4 w-full"
              ></video>
              <button
                v-if="!isAttendanceMarked(selectedScheduleId)"
                @click="takePicture"
                class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition mb-4"
              >
                Ambil Foto
              </button>
              <canvas ref="canvas" class="w-40 ml-3"></canvas>
              <button
                v-if="photoData && !isAttendanceMarked(selectedScheduleId)"
                @click="submitAttendance"
                class="bg-indigo-500 text-white py-2 px-4 rounded hover:bg-indigo-600 transition mb-4"
              >
                Submit Absensi
              </button>
              <p v-if="isAttendanceMarked(selectedScheduleId)" class="text-green-600 font-bold mt-4">
                Anda telah melakukan absensi.
              </p>
              <button @click="closeModal" class="text-red-500 mt-4 ml-3">Close</button>
            </div>
          </div>
        </Teleport>
      </div>
    </template>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const video = ref(null)
const canvas = ref(null)
const photoData = ref('')
const selectedScheduleId = ref(null)
const isModalOpen = ref(false)
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

const selectSchedule = (id) => {
  selectedScheduleId.value = id
  isModalOpen.value = true

  navigator.mediaDevices.getUserMedia({ 
    video: { 
      width: { min: 640, ideal: 1280, max: 1920 },
      height: { min: 480, ideal: 720, max: 1080 }
    }
  })
  .then(stream => {
    if (video.value) {
      video.value.srcObject = stream
    }
  })
  .catch(err => {
    console.error("Error accessing the camera: ", err)
  })
}

const takePicture = () => {
  if (video.value && canvas.value) {
    const context = canvas.value.getContext('2d')
    
    const videoWidth = video.value.videoWidth;
    const videoHeight = video.value.videoHeight;

    const sx = (videoWidth - 640) / 2; 
    const sy = (videoHeight - 480) / 2; 

    canvas.value.width = 760;
    canvas.value.height = 720;

    context.drawImage(video.value, sx, sy, 760, 720, 0, 0, 760, 720)
    
    photoData.value = canvas.value.toDataURL('image/png')
  } else {
    console.error("Video or canvas is not available")
  }
}

const submitAttendance = async () => {
  if (photoData.value && selectedScheduleId.value) {
    try {
      await router.post(route('attendances.store'), {
        photo: photoData.value,
        schedule_id: selectedScheduleId.value
      })

      userAttendances.value.push(selectedScheduleId.value) // Update local userAttendances
      closeModal()
    } catch (error) {
      console.error("Error submitting attendance: ", error)
    }
  } else {
    console.error("Photo data or schedule ID is missing")
  }
}

const closeModal = () => {
  isModalOpen.value = false
  selectedScheduleId.value = null // Reset selected schedule
}

const isAttendanceMarked = (scheduleId) => {
  return userAttendances.value.includes(scheduleId)
}
</script>

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

.w-full {
    width: 100%;
}
</style>