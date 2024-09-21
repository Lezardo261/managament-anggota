<template>
    <div>
      <label :for="id" class="block text-sm font-medium text-gray-600">{{ label }}</label>
      <input 
        :id="id" 
        type="date" 
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)" 
        :min="min" 
        :max="max" 
        :required="required"
        class="mt-2 w-full px-4 py-2 border rounded-lg focus:ring bg-gray-100 focus:ring-blue-200 focus:border-blue-500"
      />
      <span v-if="error" class="text-red-600 text-sm">{{ error }}</span>
    </div>
  </template>
  
<script setup>
import { defineProps, defineEmits } from 'vue';
  
const props = defineProps({
    id: String,
    label: String,
    modelValue: String,
    min: String,
    max: String,
    required: { type: Boolean, default: false },
    error: String,
});
  
const emit = defineEmits(['update:modelValue']);
</script>
<style scoped>
input[type="date"]::-webkit-calendar-picker-indicator {
  filter: invert(100%);
}
</style>