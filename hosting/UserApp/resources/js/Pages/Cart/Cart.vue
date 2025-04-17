<script setup>
import { onMounted, defineProps, reactive, ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Layout from '../../Pages/Shared/Layout.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const carts = reactive([]);

const total = computed(() => {
  return carts.reduce((sum, item) => sum + item.price * item.qty, 0);
});

const updateQuantity = (id, count, size, color) => {
  const index = carts.findIndex(cart =>
    cart.id === id &&
    cart.size === size &&
    cart.color === color
  );

  if (count === -1 && carts[index].qty === 1) {
    return;
  }

  if (count === 1) {
    carts[index].qty++;
  } else {
    carts[index].qty--;
  }
  localStorage.setItem('cart', JSON.stringify(carts));
}

const removeItem = (id, size, color) => {
  const index = carts.findIndex(cart =>
    cart.id === id &&
    cart.size === size &&
    cart.color === color
  );
  carts.splice(index, 1);
  localStorage.setItem('cart', JSON.stringify(carts));
}

const checkout = () => {
  router.post('/checkout', {
    carts: carts.map(item => ({
      id: item.id,
      title: item.title,
      price: item.price,
      image: item.image,
      qty: item.qty,
      size: item.size,
      color: item.color
    }))
  }, {
    onSuccess: (page) => {
      page.props.flash.success && toast.success(page.props.flash.success);
      page.props.flash.error && toast.error(page.props.flash.error);
    },
    onError: (error) => {
      console.log('Checkout Error', error);
    }
  });
}

onMounted(() => {
  const cartItems = JSON.parse(localStorage.getItem('cart'));
  if (cartItems) {
    carts.push(...cartItems);
    console.log('Cart Component Mounted', carts);
  }
});
</script>

<template>
  <Layout>
    <!-- Cart Content -->
    <div class="container mx-auto px-4 py-8">
      <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>
      <div class="grid grid-cols-1 gap-6">
        <!-- Cart Items -->
        <div v-for="(item, index) in carts" :key="index" class="bg-white shadow-md rounded-lg p-4">
          <div class="flex items-center space-x-4">
            <img :src="item.image" :alt="item.title" class="w-24 h-24 object-cover rounded">
            <div class="flex-grow">
              <h3 class="text-lg font-semibold">{{ item.title }}</h3>
              <div class="mt-1 text-sm text-gray-600">
                <span v-if="item.size" class="mr-4">Size: {{ item.size }}</span>
                <span v-if="item.color">Color: {{ item.color }}</span>
              </div>
              <div class="mt-2 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                  <button @click="updateQuantity(item.id, -1, item.size, item.color)" class="text-gray-600 hover:text-blue-500">-</button>
                  <span class="mx-2">{{ item.qty }}</span>
                  <button @click="updateQuantity(item.id, 1, item.size, item.color)" class="text-gray-600 hover:text-blue-500">+</button>
                </div>
                <div class="flex items-center space-x-4">
                  <span class="font-semibold">${{ item.price * item.qty }}</span>
                  <button @click="removeItem(item.id, item.size, item.color)" class="text-red-500 hover:text-red-700">Remove</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Cart Summary -->
      <div v-if="carts.length > 0" class="mt-6 bg-white shadow-md rounded-lg p-4">
        <div class="flex justify-between items-center">
          <span class="text-lg font-semibold">Total:</span>
          <span class="text-2xl font-bold text-blue-600">${{ total }}</span>
        </div>
        <button @click="checkout" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">
          Proceed to Checkout
        </button>
      </div>
      <div v-else class="text-center py-8">
        <p class="text-gray-500">Your cart is empty</p>
      </div>
    </div>
  </Layout>
</template>

<style></style>
