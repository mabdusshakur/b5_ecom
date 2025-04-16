<script setup>
import { defineProps, onMounted } from 'vue';
import Layout from './Shared/Layout.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    payment_methods: Array,
    payable: Number,
    vat: Number,
    total: Number,
    order_created: Boolean,
    order_id: Number
});

onMounted(() => {
    if (props.order_created) {
        // Clear the cart from localStorage
        localStorage.removeItem('cart');
        toast.success('Order placed successfully! Your cart has been cleared.');
    }
});
</script>

<template>
    <Layout>
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Payment Summary -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4">Payment Summary</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold">${{ total }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">VAT (3%):</span>
                            <span class="font-semibold">${{ vat }}</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold">Total Payable:</span>
                                <span class="text-lg font-bold text-blue-600">${{ payable }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-6">Select Payment Method</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="(method, index) in payment_methods" :key="index"
                            class="border rounded-lg p-4 hover:border-blue-500 transition-colors duration-200">
                            <div class="flex items-center space-x-4">
                                <img :src="method.logo" :alt="method.name" class="w-12 h-12 object-contain">
                                <div class="flex-1">
                                    <h3 class="font-semibold">{{ method.name }}</h3>
                                    <a :href="method.redirectGatewayURL"
                                        class="inline-block mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors duration-200">
                                        Pay Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style></style>