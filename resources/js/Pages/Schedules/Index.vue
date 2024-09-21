<template>
  <Head title="Schedules" />
  <AuthenticatedLayout>
    <template #default>
      <div class="p-8 min-h-screen flex flex-col items-center">
        <!-- Display message if no schedules are available -->
        <div v-if="!schedules.length" class="text-center text-gray-700 text-xl font-medium">
          Tidak ada jadwal tersedia
        </div>

        <!-- Display schedules if they are available -->
        <div v-if="schedules.length" class="w-full max-w-3xl grid grid-cols-1 gap-6">
          <div
            v-for="schedule in filteredSchedules"
            :key="schedule.id"
            class="bg-white shadow-md rounded-lg p-6 transition-transform duration-200 hover:scale-100"
          >
            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ schedule.title }}</h3>
            <p class="text-gray-600 mb-4">{{ schedule.start_time }} - {{ schedule.end_time }}</p>
            <button
              v-if="!isAttendanceMarked(schedule.id)"
              @click="selectSchedule(schedule.id)"
              class="bg-blue-500 text-white font-medium py-2 px-4 rounded hover:bg-blue-600 transition-colors"
            >
              Pilih Jadwal
            </button>
            <p v-else class="text-green-600 font-medium mt-2">Absensi sudah dilakukan</p>
          </div>
        </div>

        <!-- Modal for Attendance -->
        <Teleport to="body">
          <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
              <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ambil Absensi</h2>
              <video ref="video" class="w-full h-48 bg-gray-200 rounded-md mb-4" autoplay></video>
              
              <div class="flex justify-center mb-4">
                <button
                  v-if="!isAttendanceMarked(selectedScheduleId)"
                  @click="takePicture"
                  class="bg-green-500 text-white font-medium py-2 px-4 rounded hover:bg-green-600 transition-colors"
                >
                  Ambil Foto
                </button>
              </div>
              
              <canvas ref="canvas" class="hidden"></canvas>
              
              <div class="flex justify-between mt-4">
                <button
                  v-if="photoData && !isAttendanceMarked(selectedScheduleId)"
                  @click="submitAttendance"
                  class="bg-indigo-500 text-white font-medium py-2 px-4 rounded hover:bg-indigo-600 transition-colors"
                >
                  Submit Absensi
                </button>
                <button @click="closeModal" class="text-red-500 font-medium">Tutup</button>
              </div>
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
  const result = new Date(`${dateStr}T${time}`)
  if (time.split(':')[0] < '12') {
    result.setDate(result.getDate() + 1) // Add a day for times after midnight
  }
  return result
}
const filteredSchedules = computed(() => {
  const now = new Date()
  const filtered = props.schedules
    .filter(schedule => {
      const endTime = getTodayDateTime(schedule.end_time)
      
      return endTime > now
    })
    .sort((a, b) => b.id - a.id)
  return filtered
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

      userAttendances.value.push(selectedScheduleId.value)
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
  selectedScheduleId.value = null 
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
    font-weight: 500;
}

video {
    max-width: 100%;
}

.w-full {
    width: 100%;
}
</style>