<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, defineProps, reactive, onMounted } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    user: Object,
    profile: Object
});

const user = ref(props.user);

const form = useForm({
    cus_name: '',
    cus_add: '',
    cus_city: '',
    cus_state: '',
    cus_postcode: '',
    cus_country: '',
    cus_phone: '',
    cus_fax: '',
    ship_name: '',
    ship_add: '',
    ship_city: '',
    ship_state: '',
    ship_postcode: '',
    ship_country: '',
    ship_phone: ''
});

const updateProfile = () => {
    form.post('/profile', {
        onSuccess: (page) => {
            page.props.flash.success && toast.success(page.props.flash.success);
            page.props.flash.error && toast.error(page.props.flash.error);
        },
        onError: (error) => {
            console.log('Profile Error', error);
        }
    });
}


const formMail = useForm({
    email: ''
});

const updateMail = () => {
    formMail.post('/profile/mail', {
        onSuccess: (page) => {
            page.props.flash.success && toast.success(page.props.flash.success);
            page.props.flash.error && toast.error(page.props.flash.error);
        },
        onError: (error) => {
            console.log('Profile Error', error);
        }
    });
}

const formPassword = useForm({
    current_password: '',
    password: '',
    password_confirmation: ''
});

const updatePassword = () => {
    formPassword.post('/profile/password', {
        onSuccess: (page) => {
            page.props.flash.success && toast.success(page.props.flash.success);
            page.props.flash.error && toast.error(page.props.flash.error);
        },
        onError: (error) => {
            console.log('Profile Error', error);
        }
    });
}

onMounted(() => {
    form.cus_name = props.profile.cus_name,
        form.cus_add = props.profile.cus_add,
        form.cus_city = props.profile.cus_city,
        form.cus_state = props.profile.cus_state,
        form.cus_postcode = props.profile.cus_postcode,
        form.cus_country = props.profile.cus_country,
        form.cus_phone = props.profile.cus_phone,
        form.cus_fax = props.profile.cus_fax,
        form.ship_name = props.profile.ship_name,
        form.ship_add = props.profile.ship_add,
        form.ship_city = props.profile.ship_city,
        form.ship_state = props.profile.ship_state,
        form.ship_postcode = props.profile.ship_postcode,
        form.ship_country = props.profile.ship_country,
        form.ship_phone = props.profile.ship_phone
    formMail.email = user.value.email;
});

</script>


<template>
    <!-- Profile Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Left Column: Profile Update Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Update Profile</h3>
            <form @submit.prevent="updateProfile">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="mb-4">
                        <label for="cus_name" class="block text-gray-700 font-bold mb-2">Customer Name</label>
                        <input type="text" id="cus_name" class="w-full p-2 border rounded-md" v-model="form.cus_name">
                    </div>
                    <div class="mb-4">
                        <label for="cus_add" class="block text-gray-700 font-bold mb-2">Customer Address</label>
                        <input type="text" id="cus_add" class="w-full p-2 border rounded-md" v-model="form.cus_add">
                    </div>
                    <div class="mb-4">
                        <label for="cus_city" class="block text-gray-700 font-bold mb-2">Customer City</label>
                        <input type="text" id="cus_city" class="w-full p-2 border rounded-md" v-model="form.cus_city">
                    </div>
                    <div class="mb-4">
                        <label for="cus_state" class="block text-gray-700 font-bold mb-2">Customer State</label>
                        <input type="text" id="cus_state" class="w-full p-2 border rounded-md" v-model="form.cus_state">
                    </div>
                    <div class="mb-4">
                        <label for="cus_postcode" class="block text-gray-700 font-bold mb-2">Customer Postcode</label>
                        <input type="text" id="cus_postcode" class="w-full p-2 border rounded-md"
                            v-model="form.cus_postcode">
                    </div>
                    <div class="mb-4">
                        <label for="cus_country" class="block text-gray-700 font-bold mb-2">Customer Country</label>
                        <input type="text" id="cus_country" class="w-full p-2 border rounded-md"
                            v-model="form.cus_country">
                    </div>
                    <div class="mb-4">
                        <label for="cus_phone" class="block text-gray-700 font-bold mb-2">Customer Phone</label>
                        <input type="text" id="cus_phone" class="w-full p-2 border rounded-md" v-model="form.cus_phone">
                    </div>
                    <div class="mb-4">
                        <label for="cus_fax" class="block text-gray-700 font-bold mb-2">Customer Fax</label>
                        <input type="text" id="cus_fax" class="w-full p-2 border rounded-md" v-model="form.cus_fax">
                    </div>
                    <div class="mb-4">
                        <label for="ship_name" class="block text-gray-700 font-bold mb-2">Shipping Name</label>
                        <input type="text" id="ship_name" class="w-full p-2 border rounded-md" v-model="form.ship_name">
                    </div>
                    <div class="mb-4">
                        <label for="ship_add" class="block text-gray-700 font-bold mb-2">Shipping Address</label>
                        <input type="text" id="ship_add" class="w-full p-2 border rounded-md" v-model="form.ship_add">
                    </div>
                    <div class="mb-4">
                        <label for="ship_city" class="block text-gray-700 font-bold mb-2">Shipping City</label>
                        <input type="text" id="ship_city" class="w-full p-2 border rounded-md" v-model="form.ship_city">
                    </div>
                    <div class="mb-4">
                        <label for="ship_state" class="block text-gray-700 font-bold mb-2">Shipping State</label>
                        <input type="text" id="ship_state" class="w-full p-2 border rounded-md"
                            v-model="form.ship_state">
                    </div>
                    <div class="mb-4">
                        <label for="ship_postcode" class="block text-gray-700 font-bold mb-2">Shipping Postcode</label>
                        <input type="text" id="ship_postcode" class="w-full p-2 border rounded-md"
                            v-model="form.ship_postcode">
                    </div>
                    <div class="mb-4">
                        <label for="ship_country" class="block text-gray-700 font-bold mb-2">Shipping Country</label>
                        <input type="text" id="ship_country" class="w-full p-2 border rounded-md"
                            v-model="form.ship_country">
                    </div>
                    <div class="mb-4">
                        <label for="ship_phone" class="block text-gray-700 font-bold mb-2">Shipping Phone</label>
                        <input type="text" id="ship_phone" class="w-full p-2 border rounded-md"
                            v-model="form.ship_phone">
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Save Changes</button>
            </form>
        </div>

        <!-- Right Column: Change Password & Email Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Change Password & Email</h3>

            <form class="my-2" @submit.prevent="updateMail">
                <div class="mb-4">
                    <label for="current-password" class="block text-gray-700 font-bold mb-2">
                        Current Email
                    </label>
                    <input type="text" id="current-password" class="w-full p-2 border rounded-md"
                        v-model="formMail.email">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                    Update Mail
                </button>
            </form>

            <form @submit.prevent="updatePassword">
                <div class="mb-4">
                    <label for="current-password" class="block text-gray-700 font-bold mb-2">Current
                        Password</label>
                    <input type="password" id="current-password" class="w-full p-2 border rounded-md"
                        v-model="formPassword.current_password">
                </div>
                <div class="mb-4">
                    <label for="new-password" class="block text-gray-700 font-bold mb-2">New Password</label>
                    <input type="password" id="new-password" class="w-full p-2 border rounded-md"
                        v-model="formPassword.password">
                </div>
                <div class="mb-4">
                    <label for="confirm-password" class="block text-gray-700 font-bold mb-2">Confirm New
                        Password</label>
                    <input type="password" id="confirm-password" class="w-full p-2 border rounded-md"
                        v-model="formPassword.password_confirmation">
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</template>

<style></style>
