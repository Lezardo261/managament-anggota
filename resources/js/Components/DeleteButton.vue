<template>
    <button @click="handleDelete" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
        <i class="fas fa-trash-alt"></i>
    </button>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    deleteRoute: {
        type: String,
        required: true
    },
    routeParams: {
        type: Object,
        default: () => ({})
    },
    confirmMessage: {
        type: String,
        default: 'Are you sure you want to delete this item?'
    }
});

const emit = defineEmits(['deleted']);

const handleDelete = () => {
    if (confirm(props.confirmMessage)) {
        router.delete(route(props.deleteRoute, props.routeParams), {
            onSuccess: () => emit('deleted')
        });
    }
};
</script>
