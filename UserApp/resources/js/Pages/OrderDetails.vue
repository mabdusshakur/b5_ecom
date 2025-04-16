<script setup>
import Layout from './Shared/Layout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    order: {
        type: Object,
        required: true
    }
});

const getStatusColor = (status) => {
    switch (status) {
        case 'Success':
            return 'bg-green-200 text-green-800';
        case 'Pending':
            return 'bg-yellow-200 text-yellow-800';
        case 'Fail':
            return 'bg-red-200 text-red-800';
        case 'Cancel':
            return 'bg-gray-200 text-gray-800';
        case 'Processing':
            return 'bg-blue-200 text-blue-800';
        case 'Shipped':
            return 'bg-purple-200 text-purple-800';
        case 'Delivered':
            return 'bg-green-200 text-green-800';
        default:
            return 'bg-gray-200 text-gray-800';
    }
};

const getStatusText = (status) => {
    switch (status) {
        case 'Success':
            return 'Paid';
        case 'Pending':
            return 'Pending';
        case 'Fail':
            return 'Failed';
        case 'Cancel':
            return 'Cancelled';
        case 'Processing':
            return 'Processing';
        case 'Shipped':
            return 'Shipped';
        case 'Delivered':
            return 'Delivered';
        default:
            return status;
    }
};
</script>

<template>
    <Layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Order Header -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold">Order Details</h2>
                            <div class="flex items-center space-x-4">
                                <a :href="`/order/${order.id}/invoice`"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Download Invoice
                                </a>
                                <span class="text-gray-600">Order #{{ order.order_number }}</span>
                                <div class="flex space-x-2">
                                    <span :class="getStatusColor(order.payment_status)" class="px-3 py-1 rounded-full">
                                        Payment: {{ getStatusText(order.payment_status) }}
                                    </span>
                                    <span :class="getStatusColor(order.delivery_status)" class="px-3 py-1 rounded-full">
                                        Delivery: {{ getStatusText(order.delivery_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Customer Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Customer Information</h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium">Name:</span> {{ order.customer_details.name }}</p>
                                    <p><span class="font-medium">Phone:</span> {{ order.customer_details.phone }}</p>
                                    <p><span class="font-medium">Address:</span> {{ order.customer_details.address }}
                                    </p>
                                    <p><span class="font-medium">City:</span> {{ order.customer_details.city }}</p>
                                    <p><span class="font-medium">State:</span> {{ order.customer_details.state }}</p>
                                    <p><span class="font-medium">Country:</span> {{ order.customer_details.country }}
                                    </p>
                                    <p><span class="font-medium">Post Code:</span> {{ order.customer_details.postCode }}
                                    </p>
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Shipping Information</h3>
                                <div class="space-y-2">
                                    <p><span class="font-medium">Name:</span> {{ order.shipping_details.name }}</p>
                                    <p><span class="font-medium">Phone:</span> {{ order.shipping_details.phone }}</p>
                                    <p><span class="font-medium">Address:</span> {{ order.shipping_details.address }}
                                    </p>
                                    <p><span class="font-medium">City:</span> {{ order.shipping_details.city }}</p>
                                    <p><span class="font-medium">State:</span> {{ order.shipping_details.state }}</p>
                                    <p><span class="font-medium">Country:</span> {{ order.shipping_details.country }}
                                    </p>
                                    <p><span class="font-medium">Post Code:</span> {{ order.shipping_details.postCode }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="p-3 text-left">Product</th>
                                            <th class="p-3 text-left">Price</th>
                                            <th class="p-3 text-left">Quantity</th>
                                            <th class="p-3 text-left">Size</th>
                                            <th class="p-3 text-left">Color</th>
                                            <th class="p-3 text-left">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="product in order.products" :key="product.id" class="border-b">
                                            <td class="p-3">
                                                <div class="flex items-center">
                                                    <img :src="product.image" :alt="product.title"
                                                        class="w-16 h-16 object-cover mr-4">
                                                    <span>{{ product.title }}</span>
                                                </div>
                                            </td>
                                            <td class="p-3">${{ product.price }}</td>
                                            <td class="p-3">{{ product.quantity }}</td>
                                            <td class="p-3">{{ product.size }}</td>
                                            <td class="p-3">{{ product.color }}</td>
                                            <td class="p-3">${{ product.total }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="p-3 text-right font-semibold">Total Amount:</td>
                                            <td class="p-3 font-semibold">${{ order.amount }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold mb-3">Order Summary</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p><span class="font-medium">Order Date:</span> {{ order.date }}</p>
                                    <p><span class="font-medium">Payment Status:</span> {{ getStatusText(order.payment_status)}}</p>
                                    <p><span class="font-medium">Delivery Status:</span> {{ order.delivery_status }}</p>
                                </div>
                                <div>
                                    <p><span class="font-medium">Total Amount:</span> ${{ order.amount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>