<script setup>
import { defineProps, ref } from 'vue';
import Layout from '../Shared/Layout.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();
const props = defineProps({
    invoice: Object
});

const form = useForm({
    payment_status: props.invoice.payment_status,
    delivery_status: props.invoice.delivery_status,
});

const submitForm = () => {
    form.put(`/orders/${props.invoice.id}`, {
        onSuccess: () => {
            toast.success('Order status updated successfully');
        },
        onError: (errors) => {
            toast.error('Failed to update order status');
        }
    });
};
</script>

<template>
    <Layout>
        <main class="ml-64 p-8">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-2xl font-semibold">Order Details</h2>
                                <span class="text-lg font-medium">Order #{{ invoice.id }}</span>
                            </div>

                            <!-- Order Status Section -->
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-4">Order Status</h3>
                                <form @submit.prevent="submitForm" class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Payment
                                                Status</label>
                                            <select v-model="form.payment_status"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="Success">Success</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Fail">Fail</option>
                                                <option value="Cancel">Cancel</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Delivery
                                                Status</label>
                                            <select v-model="form.delivery_status"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="Pending">Pending</option>
                                                <option value="Processing">Processing</option>
                                                <option value="Shipped">Shipped</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                            Update Status
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Customer Information -->
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Name</p>
                                        <p class="font-medium">{{ invoice.customer?.cus_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Phone</p>
                                        <p class="font-medium">{{ invoice.customer?.cus_phone }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-sm text-gray-600">Address</p>
                                        <p class="font-medium">{{ invoice.customer?.cus_add }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Name</p>
                                        <p class="font-medium">{{ invoice.customer?.ship_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Phone</p>
                                        <p class="font-medium">{{ invoice.customer?.ship_phone }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-sm text-gray-600">Address</p>
                                        <p class="font-medium">{{ invoice.customer?.ship_add }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Product</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Quantity</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Size</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Color</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Price</th>
                                                <th
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="product in invoice.products" :key="product.id">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ product.product.title }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ product.quantity }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ product.size }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ product.color }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    ${{ product.price }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    ${{ (product.price * product.quantity).toFixed(2) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Subtotal</p>
                                        <p class="font-medium">${{ invoice.total }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">VAT</p>
                                        <p class="font-medium">${{ invoice.vat }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Total Amount</p>
                                        <p class="font-medium">${{ invoice.payable }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Order Date</p>
                                        <p class="font-medium">{{ new Date(invoice.created_at).toLocaleDateString() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </Layout>
</template>