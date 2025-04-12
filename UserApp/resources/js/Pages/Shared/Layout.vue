<script setup>
import Footer from './Footer.vue';
import Navbar from './Navbar.vue';

</script>

<template>
  

  <Navbar />

  <!-- Main Content -->
  <slot />

  <!-- Footer -->
   <Footer />

</template>

<style></style>
