<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { useToast } from 'vue-toastification';
import Layout from '../Shared/Layout.vue';

const flash = computed(() => usePage().props.flash);
const toast = useToast();

const slideImage = ref(null);


const props = defineProps({
    slide: Object
});

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        slideImage.value = URL.createObjectURL(file);
    }
}
const form = useForm({
    active: '',
    image: null,
    '_method': 'PUT',
});

const submitForm = () => {
    form.post(`/sliders/${props.slide.id}`, {
        onSuccess: () => {
            flash.value.success && toast.success(flash.value.success);
            flash.value.error && toast.error(flash.value.error);
        },
        onError: () => {
            toast.error('Failed to add slide. Please try again.');
        }
    });
};

onMounted(() => {
    if (props.slide) {
        form.active = props.slide.active;
        slideImage.value = props.slide.image;
    }
});

</script>

<template>
    <Layout>
        <!-- Main Content -->
        <main class="ml-64 p-8">
            <h2 class="text-2xl font-bold mb-6">Edit Slide</h2>
            <form class="bg-white shadow-md rounded-lg p-6" @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="slide-active" class="block text-gray-700 font-bold mb-2">Is Active</label>
                    <select id="slide-active" class="w-full p-2 border rounded-md" v-model="form.active" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="slide-image" class="block text-gray-700 font-bold mb-2">Image</label>
                    <input type="file" id="slide-image" class="w-full p-2 border rounded-md"
                        v-on:change="handleImageChange">
                </div>
                <div class="mb-4">
                    <img :src="slideImage" alt="Slide Image" class="w-32 h-32 rounded-md mb-4">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Edit Slide</button>
            </form>
        </main>
    </Layout>
</template>

<style></style>