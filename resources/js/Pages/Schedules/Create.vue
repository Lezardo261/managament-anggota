<template>
  <Head title="Buat Jadwal Baru" />
  <AdminLayout style="margin-top: -60px;">
    <template #default>
      <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
          <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">Buat Jadwal Baru</h1>\
          </div>
          <form @submit.prevent="submit" class="space-y-6">
            <div>
              <label for="eskul" class="block text-sm font-medium text-gray-700">Eskul</label>
              <select
                v-model="form.eskul_id"
                id="eskul"
                required
                class="mt-1 block w-full px-3 py-2 border bg-gray-100 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2  focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
              >
                <option v-for="eskul in eskuls" :key="eskul.id" :value="eskul.id">{{ eskul.name }}</option>
              </select>
            </div>
            <div>
              <InputField
                id="title"
                type="text"
                v-model="form.title"
                label="Deskripsi Singkat"
                required
                :error="form.errors.title"
                />
            </div>
            <div>
              <InputDate
                id="date"
                v-model="form.date"
                label="Tanggal"
                :required="true"
                :error="form.errors.date"
              />
            </div>
            <div>
              <InputTime
                id="start_time"
                v-model="form.start_time"
                label="Waktu Mulai"
                :required="true"
                :error="form.errors.start_time"
              />
            </div>
            <div>
              <InputTime
                id="end_time"
                v-model="form.end_time"
                label="Waktu Berakhir"
                :required="true"
                :error="form.errors.end_time"
              />
            </div>
            <div>
              <button
                type="submit"
                class="w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Buat Jadwal
              </button>
            </div>
          </form>
        </div>
      </div>
      <Notification v-if="successMessage" :message="successMessage" type="success" :duration="5000" />
      <Notification v-if="errorMessage" :message="errorMessage" type="error" :duration="5000" />
    </template>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputField from '../../Components/InputField.vue';
import InputDate from '../../Components/InputDate.vue';
import InputTime from '../../Components/InputTime.vue';
import Notification from '../../Components/Notification.vue';
const props = defineProps({
  scheduleCount: Number,
  eskuls: Array, 
});

const successMessage = ref('');
const errorMessage = ref('');

const form = useForm({
  eskul_id: '',
  title: '',
  date: '',
  start_time: '',
  end_time: ''
});

const submit = () => {
  form.post(route('schedules.store'), {
    onSuccess: () => {
      successMessage.value = 'Jadwal berhasil dibuat!';
      form.reset();
    },
    onError: () => {
      errorMessage.value = 'Terjadi kesalahan saat membuat jadwal.';
    }
  });
};
</script>

<style scoped>
input[type="date"], input[type="time"], input[type="text"], select {
  background-color: rgb(238, 242, 247);
}

input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
  filter: invert(100%);
}
</style>
