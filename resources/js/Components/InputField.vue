<template>
  <div>
    <label :for="id" class="block text-sm font-medium text-gray-600">{{ label }}</label>
    <input 
      :id="id" 
      :type="type" 
      :value="modelValue" 
      @input="handleInput" 
      :placeholder="placeholder" 
      :class="inputClass"
      :required="required"
      :autocomplete="autocomplete"
      autofocus
      class="bg-gray-100 focus:bg-gray-200"
    />
    <span v-if="error" class="text-red-600 text-sm">{{ error }}</span>
  </div>
</template>
  
<script setup>
import { ref, computed, defineProps, defineEmits } from 'vue';

// Define props
const props = defineProps({
    id: String,
    type: { type: String, default: 'text' },
    modelValue: [String, Number],
    label: String,
    placeholder: String,
    required: { type: Boolean, default: false },
    autocomplete: { type: String, default: 'off' },
    error: String
});

// Define emits
const emit = defineEmits(['update:modelValue']);

// Computed class for the input
const inputClass = computed(() => `
    mt-2 w-full px-4 py-2 border rounded-lg
    focus:ring focus:ring-blue-200 focus:border-blue-500
`);

// Handle input event
const handleInput = (event) => {
  emit('update:modelValue', event.target.value);
};
</script>

<!-- <template>
    <div>
      <label :for="id" class="block text-sm font-medium text-gray-600">{{ label }}</label>
      <input 
        :id="id" 
        :type="type" 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" 
        :placeholder="placeholder" 
        :class="inputClass"
        :required="required"
        :autocomplete="autocomplete"
        autofocus
        class="bg-gray-100 focus:bg-gray-200"
      />
      <span v-if="error" class="text-red-600 text-sm">{{ error }}</span>
    </div>
</template>
  
<script setup>
import { computed } from 'vue';
  
const props = defineProps({
    id: String,
    type: { type: String, default: 'text' },
    modelValue: [String, Number],
    label: String,
    placeholder: String,
    required: { type: Boolean, default: false },
    autocomplete: { type: String, default: 'off' },
    error: String
});
  
const emits = defineEmits(['update:modelValue']);
  
const inputClass = computed(() => `
    mt-2 w-full px-4 py-2 border rounded-lg
    focus:ring focus:ring-blue-200 focus:border-blue-500
`);
</script> -->