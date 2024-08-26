<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
});

const errors = ref({});

const submit = () => {
    form.put(route('admin.users.update', props.user.id), {
        onError: (errors) => {
            console.log(errors);  // Log errors to see what is causing the issue
            errors.value = errors;
        },
        onSuccess: (response) => {
            console.log(response);  // Log response to verify successful update
            alert('User updated successfully');
        },
    });
};

const goBack = () => {
  router.get(route('admin.dashboard'));
};
</script>

<template>
  <AdminLayout>
    <template #default>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Edit User</h2>
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form @submit.prevent="submit">
            <div class="mb-4">
              <label for="name" class="block text-gray-700">Name</label>
              <input v-model="form.name" type="text" id="name" class="border rounded-md p-2" />
              <span v-if="errors.name" class="text-red-500">{{ errors.name }}</span>
            </div>
            <div class="mb-4">
              <label for="email" class="block text-gray-700">Email</label>
              <input v-model="form.email" type="email" id="email" class="border rounded-md p-2" />
              <span v-if="errors.email" class="text-red-500">{{ errors.email }}</span>
            </div>
            <div class="mb-4">
              <label for="role" class="block text-gray-700">Role</label>
              <select v-model="form.role" id="role" class="border rounded-md p-2">
                <option value="admin">Admin</option>
                <option value="user">User</option>
              </select>
              <span v-if="errors.role" class="text-red-500">{{ errors.role }}</span>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <button type="button" @click="goBack" class="bg-gray-500 text-white px-4 py-2 rounded ml-4">Back</button>
          </form>
        </div>
      </div>
    </template>
  </AdminLayout>
</template>
