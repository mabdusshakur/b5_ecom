<script setup>
import { ref } from 'vue';
import ProductCard from '../../Components/ProductCard.vue';
import Layout from '../Shared/Layout.vue';
import { router } from '@inertiajs/vue3';

const search = ref('')
const selectedCategories = ref([])
const selectedBrands = ref([])

const min_price = ref(null)
const max_price = ref(null)

const filterProducts = () => {
    router.get('/products', {
        search: search.value,
        categories: selectedCategories.value,
        brands: selectedBrands.value,
        min_price: min_price.value,
        max_price: max_price.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
}

const toggleCategory = (categoryId) => {

    const index = selectedCategories.value.indexOf(categoryId);

    if (index === -1) {
        selectedCategories.value.push(categoryId);
    } else {
        selectedCategories.value.splice(index, categoryId);
    }

    filterProducts();
}

const toggleBrand = (brandId) => {

    const index = selectedBrands.value.indexOf(brandId);

    if (index === -1) {
        selectedBrands.value.push(brandId);
    } else {
        selectedBrands.value.splice(index, brandId);
    }

    filterProducts();
}

const props = defineProps({
    products: Array,
    categories: Array,
    brands: Array,
})

</script>

<template>

    <Layout>
        <!-- All Products Content -->
        <div class="container mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold mb-6">All Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Filters Sidebar -->
                <div class="md:col-span-1 bg-white shadow-md p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4">Filters</h3>

                    <div class="flex-grow max-w-sm my-2">
                        <input type="text" placeholder="Search products..." v-on:keyup="filterProducts" v-model="search"
                            class="w-full p-2 border rounded-md" />
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold mb-2">Category</h4>
                        <div class="space-y-2">
                            <label v-for="(category, index) in categories" :key="index"
                                class="flex items-center space-x-2">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-500"
                                    @change="toggleCategory(category.id)">
                                <span>{{ category.name }}</span>
                            </label>
                        </div>
                    </div>
                    <!-- Brand Filter -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold mb-2">Brand</h4>
                        <div class="space-y-2">
                            <label v-for="(brand, index) in brands" :key="index" class="flex items-center space-x-2">
                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-500"
                                    @change="toggleBrand(brand.id)">
                                <span>{{ brand.name }}</span>
                            </label>
                        </div>
                    </div>
                    <!-- Price Range Filter -->
                    <div>
                        <h4 class="text-sm font-semibold mb-2">Price Range</h4>
                        <div class="flex space-x-2">
                            <input type="number" placeholder="Min" class="w-full p-2 border rounded-md"
                                v-model="min_price">
                            <input type="number" placeholder="Max" class="w-full p-2 border rounded-md"
                                v-model="max_price">
                        </div>
                    </div>
                    <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md w-full"
                        @click="filterProducts">Apply Filters</button>
                </div>

                <!-- Product Grid -->
                <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <ProductCard v-for="(product, index) in products" :key="index" :product="product" />
                </div>
            </div>
        </div>
    </Layout>

</template>

<style></style>
