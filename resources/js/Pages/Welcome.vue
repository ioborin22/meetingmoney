<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Head, Link } from '@inertiajs/vue3';
import SearchBar from '@/Components/SearchBar.vue';

const offerListing = ref([]);

onMounted(() => {
    fetchOfferListing();
});

function fetchOfferListing() {
    axios.get('/api/offer-listing')
        .then(response => offerListing.value = response.data)
        .catch(error => console.log(error));
}

// Если вам нужно определить props
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center bg-gray-100 dark:bg-gray-900 selection:bg-blue-500 selection:text-white">

        <!--Login/Register-->
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Register</Link>
            </template>
        </div>

        <SearchBar/>
    </div>
</template>

<style>

</style>
