<script setup>
import { ref } from 'vue';
import ProductCard from '../../Components/ProductCard.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  products: Array,
});

const currentFilter = ref('null');

const filterProducts = (filter) => {
  currentFilter.value = filter;
  router.get('/', { filter },{
    preserveState: true,
    preserveScroll: true,
  });
};
</script>

<template>
  <!-- Horizontal Filter for Remarks -->
  <div class="container mx-auto px-4 py-6">
    <div class="flex space-x-4 overflow-x-auto">
      <button @click="filterProducts('special')" :class="{'bg-blue-500 text-white' : currentFilter == 'special', 'bg-gray-200 text-gray-700' : currentFilter !== 'special'}" class="px-4 py-2 rounded-full whitespace-nowrap">
        Special
      </button>
      <button @click="filterProducts('popular')" :class="{'bg-blue-500 text-white' : currentFilter == 'popular', 'bg-gray-200 text-gray-700' : currentFilter !== 'popular'}" class="px-4 py-2 rounded-full whitespace-nowrap">
        Popular
      </button>
      <button @click="filterProducts('trending')" :class="{'bg-blue-500 text-white' : currentFilter == 'trending', 'bg-gray-200 text-gray-700' : currentFilter !== 'trending'}" class="px-4 py-2 rounded-full whitespace-nowrap">
        Trending
      </button>
      <button @click="filterProducts('regular')" :class="{'bg-blue-500 text-white' : currentFilter == 'regular', 'bg-gray-200 text-gray-700' : currentFilter !== 'regular'}" class="px-4 py-2 rounded-full whitespace-nowrap">
        Regular
      </button>
    </div>
  </div>

  <!-- Product Card Section -->
  <div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6">Featured Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

      <ProductCard v-for="(product, index) in products" :key="index" :product="product"/>

    </div>
  </div>
</template>

<style></style>
