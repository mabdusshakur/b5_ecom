<script setup>
import { computed, defineProps, onMounted } from 'vue';
import Layout from '../../Pages/Shared/Layout.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();
const flash = computed(() => usePage().props.flash);


const props = defineProps({
    email: String,
});

const form = useForm({
    otp: '',
    email : props.email,
});

onMounted(() => {
    form.otp = '';
    form.email = props.email;
});

const verifyOTP = () => {
    form.post(`/otp/verify`, {
        onSuccess: () => {
            flash.value.success && toast.success(flash.value.success);
            flash.value.error && toast.error(flash.value.error);
        },
    });
}

</script>
<template>
    <Layout>
        <!-- OTP Verification Form -->
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4 text-center">OTP Verification</h2>
                <p class="text-gray-600 text-center mb-6">
                    We have sent a 6-digit OTP code to your email. Please enter it below to verify your account.
                </p>
                <form @submit.prevent="verifyOTP">
                    <div class="mb-6">
                        <label for="otp" class="block text-gray-700 font-bold mb-2">Enter OTP</label>
                        <input type="text" id="otp" class="w-full p-2 border rounded-md" placeholder="Enter 6-digit OTP"
                            maxlength="6" required v-model="form.otp">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white w-full py-2 rounded-md hover:bg-blue-600">
                        Verify OTP
                    </button>
                </form>
                <p class="text-center mt-4 text-gray-600">
                    <Link href="/otp/resend" method="post" :data="{'email' : email}" class="text-blue-500 hover:text-blue-700">Resend OTP</Link>
                </p>
            </div>
        </div>
    </Layout>
</template>

<style></style>