<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <aside class="w-64 bg-gray-800 text-white h-screen fixed">
      <div class="p-4">
        <h3 class="text-xl font-bold mb-6">Editor Panel</h3>
        <ul class="mt-4 space-y-2">
          <li><Link href="/dashboard" class="hover:bg-gray-700 p-2 block rounded">Dashboard</Link></li>
          <li><Link href="/categories" class="hover:bg-gray-700 p-2 block rounded">Categories</Link></li>
          <li><Link href="/brands" class="hover:bg-gray-700 p-2 block rounded">Brands</Link></li>
          <li><Link href="/sliders" class="hover:bg-gray-700 p-2 block rounded">Slides</Link></li>
          <li><Link href="/products" class="hover:bg-gray-700 p-2 block rounded">Products</Link></li>
          <li><Link href="/orders" class="hover:bg-gray-700 p-2 block rounded">Orders</Link></li>
        </ul>
      </div>
    </aside>
</template>

<style >
    
</style>


