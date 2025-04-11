<script setup>
import Sidebar from './Sidebar.vue'
</script>

<template>
  <!-- Sidebar -->
  <div class=" h-screen">
    <Sidebar />

    <!-- Main Content -->
    <slot />
  </div>
</template>

<style >
    
</style>


