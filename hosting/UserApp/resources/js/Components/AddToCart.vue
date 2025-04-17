<script setup>
import { onMounted, ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    product: Object
});

const sizes = ref([]);
const colors = ref([]);

const selectedSize = ref(null);
const selectedColor = ref(null);

onMounted(() => {
    if (props.product.details.size) {
        sizes.value = props.product.details.size.split(',');
        selectedSize.value = sizes.value[0]; // Set default size to the first one
    }
    if (props.product.details.color) {
        colors.value = props.product.details.color.split(',');
        selectedColor.value = colors.value[0]; // Set default color to the first one
    }
});

const addToCart = () => {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    const existingItem = cart.find(item =>
        item.id === props.product.id &&
        item.size === selectedSize.value &&
        item.color === selectedColor.value
    );

    if(existingItem){
        existingItem.qty++;
    }else{
        cart.push({
            id: props.product.id,
            title: props.product.title,
            price: props.product.is_discount ? props.product.discount_price : props.product.price,
            image: props.product.image,
            qty: 1,
            size: selectedSize.value,
            color: selectedColor.value
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    showModal.value = false; // Close the modal after adding to cart
    toast.success('Product added to cart successfully!');

};


const showModal = ref(false);
</script>

<template>
    <div>
        <button @click="showModal = true"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors duration-200">
            Add to Cart
        </button>

        <!-- Size and Color Selection Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-white/30 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4">Select Size and Color</h3>

                <!-- Size Selection -->
                <div v-if="sizes.length > 0" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                    <div class="flex flex-wrap gap-2">
                        <button v-for="size in sizes" :key="size" @click="selectedSize = size"
                            :class="['px-3 py-1 rounded-md border', selectedSize === size ? 'bg-blue-500 text-white border-blue-500' : 'border-gray-300 hover:border-blue-500']">
                            {{ size }}
                        </button>
                    </div>
                </div>

                <!-- Color Selection -->
                <div v-if="colors.length > 0" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                    <div class="flex flex-wrap gap-2">
                        <button v-for="color in colors" :key="color" @click="selectedColor = color"
                            :class="['px-3 py-1 rounded-md border', selectedColor === color ? 'bg-blue-500 text-white border-blue-500' : 'border-gray-300 hover:border-blue-500']">
                            {{ color }}
                        </button>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button @click="showModal = false"
                        class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button @click="addToCart" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
