<script setup>
import { onMounted, computed } from 'vue';
import Layout from '../Shared/Layout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();
const flash = computed(() => usePage().props.flash);

const props = defineProps({
    setting: Object
});

const form = useForm({
    'store_id': '',
    'store_password': '',
    'currency': '',
    'success_url': '',
    'fail_url': '',
    'cancel_url': '',
    'ipn_url': '',
    'init_url': ''
});

onMounted(() => {
    if (props.setting) {
        form.store_id = props.setting.store_id;
        form.store_password = props.setting.store_password;
        form.currency = props.setting.currency;
        form.success_url = props.setting.success_url;
        form.fail_url = props.setting.fail_url;
        form.cancel_url = props.setting.cancel_url;
        form.ipn_url = props.setting.ipn_url;
        form.init_url = props.setting.init_url;
    }
});


const submitForm = () => {
    form.put(`/settings/${props.setting.id}`, {
        onSuccess: () => {
            flash.value.success && toast.success(flash.value.success);
            flash.value.error && toast.error(flash.value.error);
        }
    });
};
</script>

<template>
    <Layout>
        <div class="flex justify-center">
            <main class="ml-64 p-8">
                <h3 class="text-lg font-bold mb-4">SSLCommerz Payment Gateway Configuration</h3>
                <form class="bg-white shadow-md rounded-lg p-6" @submit.prevent="submitForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="store-id" class="block text-gray-700 font-bold mb-2">Store ID</label>
                            <input type="text" id="store-id" class="w-full p-2 border rounded-md"
                                placeholder="Enter Store ID" required v-model="form.store_id">
                        </div>
                        <div class="mb-4">
                            <label for="store-password" class="block text-gray-700 font-bold mb-2">Store
                                Password</label>
                            <input type="text" id="store-password" class="w-full p-2 border rounded-md"
                                placeholder="Enter Store Password" required v-model="form.store_password">
                        </div>
                        <div class="mb-4">
                            <label for="currency" class="block text-gray-700 font-bold mb-2">Currency</label>
                            <input type="text" id="currency" class="w-full p-2 border rounded-md"
                                placeholder="Enter Store ID" required v-model="form.currency">
                        </div>
                        <div class="mb-4">
                            <label for="success-url" class="block text-gray-700 font-bold mb-2">Success URL</label>
                            <input type="text" id="success-url" class="w-full p-2 border rounded-md"
                                v-model="form.success_url" required>
                        </div>
                        <div class="mb-4">
                            <label for="fail-url" class="block text-gray-700 font-bold mb-2">Fail URL</label>
                            <input type="text" id="fail-url" class="w-full p-2 border rounded-md"
                                v-model="form.fail_url" required>
                        </div>
                        <div class="mb-4">
                            <label for="cancel-url" class="block text-gray-700 font-bold mb-2">Cancel URL</label>
                            <input type="text" id="cancel-url" class="w-full p-2 border rounded-md"
                                v-model="form.cancel_url" required>
                        </div>
                        <div class="mb-4">
                            <label for="ipn-url" class="block text-gray-700 font-bold mb-2">IPN URL</label>
                            <input type="text" id="ipn-url" class="w-full p-2 border rounded-md" v-model="form.ipn_url"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="init-url" class="block text-gray-700 font-bold mb-2">INIT URL</label>
                            <input type="text" id="init-url" class="w-full p-2 border rounded-md"
                                v-model="form.init_url" required>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Settings</button>
                </form>
            </main>
        </div>
    </Layout>
</template>

<style></style>