<script setup>
import { defineProps, computed, onMounted } from 'vue';
import { Link, router, usePage  } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast();

import Layout from '../Shared/Layout.vue';
import TableComponent from '../../Components/TableComponent.vue';

const props = defineProps({
    users: Array,
});

const columns = [
    { key: 'email', label: 'Email', searchable: false, sortable: true },
    { key: 'role', label: 'Role', searchable: true, sortable: true },
    { key: 'actions', label: 'Actions', slot: 'actions-slot', searchable: false },
];

const deleteUser = (id) => {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(`/users/${id}`, {
            onSuccess: () => {
                toast.success('User deleted successfully');
            },
            onError: () => {
                toast.error('Failed to delete user');
            },
        });
    }
}

</script>

<template>
    <Layout>
        <main class="ml-64 p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Users</h2>
                <Link href="/users/create" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                    Add User
                </Link>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <TableComponent :data="users" :columns="columns" :page-size="5">
                    <template #actions-slot="{ row }">
                        <div class="space-x-2">
                            <Link :href="`/users/${row.id}/edit`"
                                class="bg-yellow-500 text-white px-2 py-1 rounded-md">
                                Edit
                            </Link>
                            <button @click="deleteUser(row.id)" class="bg-red-500 text-white px-2 py-1 rounded-md">
                                Delete
                            </button>
                        </div>
                    </template>
                </TableComponent>
            </div>
        </main>
    </Layout>
</template>

<style></style>