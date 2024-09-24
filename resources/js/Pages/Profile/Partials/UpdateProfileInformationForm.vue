<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NumberInput from '@/Components/NumberInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import InputField from '../../../Components/InputField.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    nis: user.nis || '',
    kelas: user.kelas || '',
});

console.log('Form data before submit:', form);

const submit = () => {
    form.put(route('profile.update'));
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <InputField
                id="name" label="Name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name"/>
            <InputField id="email" label="Email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username"/>
            <InputField id="nis" label="NIS" type="text" class="mt-1 block w-full" v-model="form.nis" required autofocus autocomplete="nis"/>
            <InputField id="kelas" label="Kelas" type="text" class="mt-1 block w-full" v-model="form.kelas" required autofocus autocomplete="kelas"/>
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        </form>
  
    </section>
</template>
