<script setup>
import { defineProps, ref, computed, onMounted} from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Layout from '../Shared/Layout.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();
const flash = computed(() => usePage().props.flash);

const props = defineProps({
    user: Object,
});

const form = useForm({
    email: '',
    password: '',
    role: ''
});

const submitForm = () => {
    form.put(`/users/${props.user.id}`, {
        onSuccess: () => {
            flash.value.success && toast.success(flash.value.success);
            flash.value.error && toast.error(flash.value.error);
        },
    });
}

onMounted(() => {
    if (props.user) {
        form.email = props.user.email;
        form.role = props.user.role;
    }
});

</script>
<template>
    <Layout>
        <div class="flex ">
            <main class="ml-64 p-8">
                <h2 class="text-2xl font-bold mb-6">Update User</h2>
                <form class="bg-white shadow-md rounded-lg p-6" @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label for="user-email" class="block text-gray-700 font-bold mb-2">Email</label>
                        <input type="email" id="user-email" class="w-full p-2 border rounded-md"
                            placeholder="Enter email" v-model="form.email" required>
                    </div>
                    <div class="mb-4">
                        <label for="user-password" class="block text-gray-700 font-bold mb-2">Password</label>
                        <input type="password" id="user-password" class="w-full p-2 border rounded-md"
                            placeholder="Enter password" v-model="form.password">
                    </div>
                    <div class="mb-4">
                        <label for="user-role" class="block text-gray-700 font-bold mb-2">Role</label>
                        <select id="user-role" class="w-full p-2 border rounded-md" v-model="form.role" required>
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update User</button>
                </form>
            </main>
        </div>
    </Layout>
</template>

<style></style>