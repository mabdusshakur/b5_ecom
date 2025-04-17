<script setup>
import Layout from '../Shared/Layout.vue';
import HomeFilter from './HomeFilter.vue';
import Slider from './Slider.vue';

const props = defineProps({
  sliders : Array,
  products: Array,
})

</script>

<template>

  <Layout>
    <Slider :sliders="sliders"/>
    <HomeFilter :products="products" />
  </Layout>

</template>

<style></style>
