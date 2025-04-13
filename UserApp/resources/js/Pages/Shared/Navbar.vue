<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue';

const userDropDown = ref(false)

</script>

<template>
  <!-- Navbar -->
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 flex justify-between items-center py-4">
      <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-1">
          <img src="@/assets/logo.png" alt="Logo" class="h-8" />
          <span class="text-md font-semibold">PandaStore</span>
        </div>

        <a href="/" class="text-gray-700 hover:text-blue-500">Home</a>
        <a href="/cart.html" class="text-gray-700 hover:text-blue-500">Cart</a>
        <a href="/wishlist.html" class="text-gray-700 hover:text-blue-500">Wishlist</a>
      </div>
      <div class="relative">
        <button @click="userDropDown = !userDropDown" id="user-dropdown-btn" class="flex items-center space-x-2">
          <img src="https://dummyimage.com/40x40/000/fff&text=User" alt="User" class="h-8 w-8 rounded-full" />
          <span class="text-gray-700">John Doe</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="user-dropdown" :class="{'hidden' : !userDropDown}" class="z-10 absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg">
          <ul class="py-2">
            <li>
              <a href="/dashboard.html" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</a>
            </li>
            <li>
              <a href="/logout.html" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

</template>

<style></style>
