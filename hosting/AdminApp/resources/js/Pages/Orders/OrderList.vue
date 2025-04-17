<script setup>
import { defineProps } from 'vue';
import Layout from '../Shared/Layout.vue';
import { Link } from '@inertiajs/vue3';
import TableComponent from '../../Components/TableComponent.vue';

const props = defineProps({
    invoices: Array
});


const columns = [
    { key: 'id', label: 'Order Number', searchable: true, sortable: true },
    { key: 'customer', label: 'Customer', slot: 'customer-slot', searchable: true, sortable: true },
    { key: 'total', label: 'Amount', searchable: true, sortable: true },
    { key: 'payment_status', label: 'Payment Status', slot: 'payment-status-slot', searchable: true, sortable: true },
    { key: 'delivery_status', label: 'Delivery Status', slot: 'delivery-status-slot', searchable: true, sortable: true },
    { key: 'created_at', label: 'Date', slot: 'date-slot', searchable: true, sortable: true },
    { key: 'actions', label: 'Actions', slot: 'actions-slot', searchable: false },
];

const getStatusColor = (status) => {
    const colors = {
        Success: 'bg-green-100 text-green-800',
        Pending: 'bg-yellow-100 text-yellow-800',
        Fail: 'bg-red-100 text-red-800',
        Cancel: 'bg-gray-100 text-gray-800',
        Processing: 'bg-blue-100 text-blue-800',
        Shipped: 'bg-indigo-100 text-indigo-800',
        Delivered: 'bg-green-100 text-green-800',
        Cancelled: 'bg-red-100 text-red-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
    <Layout>
        <main class="ml-64 p-8">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h2 class="text-2xl font-semibold mb-4">Orders</h2>
                            <div class="overflow-x-auto">
                                <TableComponent :data="invoices" :columns="columns" :page-size="5">
                                    <template #customer-slot="{ row }">
                                        <span>{{ row.customer.cus_name }}</span>
                                    </template>
                                    <template #payment-status-slot="{ row }">
                                        <span :class="getStatusColor(row.payment_status)">
                                            {{ row.payment_status }}
                                        </span>
                                    </template>
                                    <template #delivery-status-slot="{ row }">
                                        <span :class="getStatusColor(row.delivery_status)">
                                            {{ row.delivery_status }}
                                        </span>
                                    </template>
                                    <template #date-slot="{ row }">
                                        <span>{{ new Date(row.created_at).toLocaleDateString() }}</span>
                                    </template>
                                    <template #actions-slot="{ row }">
                                        <Link :href="`/orders/${row.id}`" class="text-blue-500">View</Link>
                                    </template>
                                </TableComponent>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </Layout>
</template>