<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    data: {
        type: Array,
        required: true,
    },
    columns: {
        type: Array,
        required: true,
    },
    pageSize: {
        type: Number,
        default: 5,
    },
});

const searchQuery = ref('');
const sortColumn = ref('');
const sortDirection = ref('asc');
const currentPage = ref(1);

const filteredData = computed(() => {
    const query = searchQuery.value.toLowerCase().trim();

    // Filter data based on search query
    let filtered = props.data.filter((row) => {
        return props.columns
            .filter((column) => column.searchable)
            .some((column) => {
                const value = String(row[column.key]).toLowerCase();
                return value.includes(query);
            });
    });

    // Sort data based on the selected column and direction
    if (sortColumn.value) {
        filtered = filtered.sort((a, b) => {
            if (sortDirection.value === 'asc') {
                return a[sortColumn.value] > b[sortColumn.value] ? 1 : -1;
            } else {
                return a[sortColumn.value] < b[sortColumn.value] ? 1 : -1;
            }
        });
    }

    return filtered;
});

// Computed property for paginated data
const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * props.pageSize;
    const end = start + props.pageSize;
    return filteredData.value.slice(start, end);
});

// Total number of pages
const totalPages = computed(() => {
    return Math.ceil(filteredData.value.length / props.pageSize);
});

// Functions for sorting and pagination
const toggleSort = (column) => {
    if (!column.sortable) return; // Do not allow sorting if column is not sortable

    if (sortColumn.value === column.key) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column.key;
        sortDirection.value = 'asc';
    }
};

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};
</script>

<template>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Search Input -->
        <div class="p-4">
            <input v-model="searchQuery" type="text" placeholder="Search..."
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
        </div>

        <!-- Table -->
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th v-for="column in columns" :key="column.key" class="p-3 text-left cursor-pointer"
                        :class="{ 'cursor-default': !column.sortable }" @click="toggleSort(column)">
                        {{ column.label }}
                        <span v-if="sortColumn === column.key && column.sortable" class="ml-2">
                            {{ sortDirection === 'asc' ? '▲' : '▼' }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in paginatedData" :key="index" class="border-b">
                    <td v-for="column in columns" :key="column.key" class="p-3">
                        <slot v-if="column.slot" :name="column.slot" :row="row"></slot>
                        <span v-else>{{ row[column.key] }}</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex justify-between items-center p-4">
            <div>
                <button class="px-3 py-2 bg-gray-200 rounded-l-md" :disabled="currentPage === 1"
                    @click="goToPage(currentPage - 1)">
                    Previous
                </button>
                <button v-for="page in totalPages" :key="page" class="px-3 py-2 bg-gray-200"
                    :class="{ 'bg-blue-500 text-white': page === currentPage }" @click="goToPage(page)">
                    {{ page }}
                </button>
                <button class="px-3 py-2 bg-gray-200 rounded-r-md" :disabled="currentPage === totalPages"
                    @click="goToPage(currentPage + 1)">
                    Next
                </button>
            </div>
            <div class="text-sm text-gray-500">
                Showing {{ (currentPage - 1) * pageSize + 1 }} -
                {{
                    Math.min(
                        currentPage * pageSize,
                        filteredData.length
                    )
                }}
                of {{ filteredData.length }} results
            </div>
        </div>
    </div>
</template>