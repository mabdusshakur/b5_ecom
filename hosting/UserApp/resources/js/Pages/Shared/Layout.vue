<script setup>
import Footer from './Footer.vue';
import Navbar from './Navbar.vue';

</script>

<template>
  <div class="min-h-screen flex flex-col">

    <Navbar />

    <!-- Main Content -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Footer -->
    <Footer />
  </div>

</template>

<style></style>
