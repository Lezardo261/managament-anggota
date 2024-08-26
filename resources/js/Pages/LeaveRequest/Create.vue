
<template>
    <Head title="Request" />
    <div>
        <h1>Submit Leave Request</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="reason">Reason</label>
                <select v-model="form.reason" required>
                    <option value="" disabled>Select Reason</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                </select>
            </div>
            <div>
                <label for="leave_date">Leave Date</label>
                <input type="date" v-model="form.leave_date" required />
            </div>
            <div>
                <label for="attachment">Attachment (optional)</label>
                <input type="file" @change="handleFileChange" />
            </div>
            <button type="submit" :disabled="form.processing">Submit</button>
        </form>
    </div>
</template>

<script setup>
import { useForm, Head } from '@inertiajs/vue3';


const form = useForm({
    reason: '',
    leave_date: '',
    attachment: null,
});

const handleFileChange = (e) => {
    form.attachment = e.target.files[0];
};
 
const submit = () => {
    form.post(route('leave-requests.store'))
}
  
    
</script>