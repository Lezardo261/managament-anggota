<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-600 to-purple-700">
        <!-- Menghapus logo karena Anda menyatakan tidak ingin menggunakan img logo -->
        
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg rounded-lg">
            <slot />
        </div>
    </div>
</template>
