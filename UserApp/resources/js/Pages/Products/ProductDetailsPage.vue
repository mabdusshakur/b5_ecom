<script setup>
import { onMounted, defineProps, ref, computed, onBeforeMount } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import Layout from '../../Pages/Shared/Layout.vue';
import ProductCard from '../../Components/ProductCard.vue';
import { useToast } from 'vue-toastification';
import { Link } from '@inertiajs/vue3';
import AddToCart from '../../Components/AddToCart.vue';

const toast = useToast();

const mainImage = ref(null);

const props = defineProps({
    product: Object,
    is_on_wishlist: Boolean,
    can_review: Boolean,
    reviews: Array,
    related_products: Array,
});

onBeforeMount(() => {
    mainImage.value = props.product.image;
});

const changeImage = (newImg) => {
    mainImage.value = newImg;
}


const addToWishlist = (id) => {
    router.post('/wishlists', {
        product_id: id,
    }, {
        preserveState: true,
        preserveScroll: true,

        onSuccess: (page) => {
            page.props.flash.success && toast.success(page.props.flash.success);
            page.props.flash.error && toast.error(page.props.flash.error);
        },
    });
};

const reviewText = ref('');
const rating = ref(5);

const submitReview = () => {
    router.post('/add-review', {
        product_id: props.product.id,
        description: reviewText.value,
        rating: rating.value
    }, {
        onSuccess: (page) => {
            reviewText.value = '';
            rating.value = 5;
            page.props.flash.success && toast.success(page.props.flash.success);
            page.props.flash.error && toast.error(page.props.flash.error);
        },
        onError: (error) => {
            console.log('Review Error', error);
        }
    });
};

// Function to generate star rating display
const getStarRating = (rating) => {
    return '★'.repeat(rating) + '☆'.repeat(5 - rating);
};

</script>
<template>
    <Layout>
        <!-- Product Details Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Images Section -->
                <div>
                    <!-- Main Image -->
                    <div class="w-full h-96 bg-gray-200 rounded-lg overflow-hidden mb-4">
                        <img id="main-image" :src="mainImage" alt="Main Product Image"
                            class="w-full h-full object-cover">
                    </div>
                    <!-- Thumbnail Images -->
                    <div class="flex space-x-2">
                        <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden cursor-pointer">
                            <img :src="product.details.img1" alt="Thumbnail 1" class="w-full h-full object-cover"
                                @click="changeImage(product.details.img1)">
                        </div>
                        <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden cursor-pointer">
                            <img :src="product.details.img2" alt="Thumbnail 2" class="w-full h-full object-cover"
                                @click="changeImage(product.details.img2)">
                        </div>
                        <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden cursor-pointer">
                            <img :src="product.details.img3" alt="Thumbnail 3" class="w-full h-full object-cover"
                                @click="changeImage(product.details.img3)">
                        </div>
                        <div class="w-20 h-20 bg-gray-200 rounded-lg overflow-hidden cursor-pointer">
                            <img :src="product.details.img4" alt="Thumbnail 4" class="w-full h-full object-cover"
                                @click="changeImage(product.details.img4)">
                        </div>
                    </div>
                </div>
                <!-- Product Information -->
                <div>
                    <h2 class="text-2xl font-bold mb-4">{{ product.title }}</h2>
                    <p class="text-gray-600">{{ product.short_des }}</p>
                    <div class="flex items-center mt-4">
                        <span class="text-red-500 font-bold text-xl">
                            ${{ props.product.is_discount ? props.product.discount_price : props.product.price }}
                        </span>
                        <span v-show="props.product.is_discount" class="text-gray-400 line-through ml-2">
                            ${{ props.product.price }}
                        </span>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold">Available Options</h3>
                        <p class="text-gray-600 mt-2">Select size and color when adding to cart</p>
                    </div>
                    <div class="flex items-center mt-4">
                        <AddToCart :product="props.product" />
                        <button v-if="!is_on_wishlist" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md ml-2" @click="addToWishlist(props.product.id)">Add to Wishlist</button>
                    </div>
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Product Details</h3>
                        <ul class="list-disc pl-6 text-gray-600">
                            <li>Available Sizes: {{ product.details.size }}</li>
                            <li>Available Colors: {{ product.details.color }}</li>
                        </ul>
                    </div>
                </div>
            </div>

             <!-- Product Reviews Section -->
             <div class="mt-8">
                <h3 class="text-2xl font-bold mb-4">Customer Reviews</h3>
                <div class="bg-white shadow-md rounded-lg p-4 max-h-96 overflow-y-auto">
                    <div class="space-y-4 mb-2" v-for="(review, index) in props.reviews" :key="index">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="https://dummyimage.com/40x40/000/fff&text=User" alt="Reviewer"
                                    class="h-8 w-8 rounded-full">
                                <div>
                                    <p class="font-semibold">{{ review.customer_name }}</p>
                                    <p class="text-sm text-gray-500">{{ review.created_at }}</p>
                                </div>
                            </div>
                            <span class="text-yellow-400 text-lg">{{ getStarRating(review.rating) }}</span>
                        </div>
                        <p class="text-gray-600">
                            {{ review.description }}
                        </p>
                    </div>
                </div>
                <div v-if="props.can_review" class="mt-8">
                    <h3 class="text-2xl font-bold mb-4">Leave a Review</h3>
                    <form @submit.prevent="submitReview" class="bg-white shadow-md rounded-lg p-4">
                        <div class="mb-4">
                            <label for="review" class="block text-gray-700 font-bold mb-2">Your Review</label>
                            <textarea id="review" v-model="reviewText" rows="4" class="w-full p-2 border rounded-md"
                                placeholder="Write your review here..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="rating" class="block text-gray-700 font-bold mb-2">Rating</label>
                            <select id="rating" v-model="rating" class="w-full p-2 border rounded-md">
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Submit
                            Review</button>
                    </form>
                </div>
                <div v-else class="mt-8">
                    <p class="text-red-500">You are not eligible to leave a review for this product.</p>
                </div>
            </div>




            <!-- Related Products Section -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold mb-6">Related Products</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <ProductCard v-for="(product, index) in props.related_products" :key="index" :product="product" />
                </div>
                <div class="text-center mt-8">
                    <Link href="/products" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-colors duration-200">
                        View All Products
                    </Link>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style></style>
