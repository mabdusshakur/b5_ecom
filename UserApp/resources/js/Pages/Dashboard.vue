<script setup>
import Profile from './Dashboard/Profile.vue';
import Layout from './Shared/Layout.vue'

const props = defineProps({
    profile: Object,
    user: Object,
})

</script>

<template>
    <Layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <Profile :profile="profile" :user="user" />

            </div>
        </div>
    </Layout>
</template>

<style></style>