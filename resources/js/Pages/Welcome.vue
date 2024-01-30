<script setup>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import {Head, Link, router} from '@inertiajs/vue3';
import SearchBar from '@/Components/SearchBar.vue';
import OfferListing from "@/Components/OfferListing.vue";

import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';

const offerListing = ref([]);
const showingNavigationDropdown = ref(false);

onMounted(() => {
    fetchOfferListing();
});

function fetchOfferListing() {
    axios.get('/api/offer-listing')
        .then(response => offerListing.value = response.data)
        .catch(error => console.log(error));
    console.log(offerListing)
}

// Если вам нужно определить props
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});

const logout = () => {
    router.post(route('logout'));
};

</script>


<template>
    <Head title="MeetingMoney"/>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <nav class="bg-header-1 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('/')">
                            <ApplicationMark class="block h-9 w-auto"/>
                        </Link>
                    </div>

                    <!-- Spacer element to push the navigation and settings to the right -->
                    <div class="flex-grow"></div>

                    <!-- Right side of the navbar -->
                    <div class="flex items-center">
                        <!-- Navigation Link -->
                        <Link :href="route('create-ad')" class="text-xs sm:text-sm px-2 sm:px-4 py-1 sm:py-2 bg-primary-green text-white rounded-sm hover:bg-green-600 mr-3">
                            PLACE AN AD
                        </Link>

                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative hidden sm:flex">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                             :src="$page.props.auth.user.profile_photo_url"
                                             :alt="$page.props.auth.user.name">
                                    </button>

                                    <span v-else class="inline-flex rounded-sm">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-sm text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <div class="border-t border-gray-200 dark:border-gray-600"/>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-sm text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                            @click="showingNavigationDropdown = ! showingNavigationDropdown">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"/>
                                <path
                                    :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center px-4">
                        <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                            <img class="h-10 w-10 rounded-full object-cover"
                                 :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                        </div>

                        <div>
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Основной контент -->
        <main class="flex-grow p-4">
            <div class="w-full max-w-xl mx-auto p-4">
                <h1 class="text-center text-2xl font-bold mb-4">Smart people make money here</h1>

                <SearchBar/>
            </div>
            <OfferListing :offerListing="offerListing"/>
        </main>
        <!-- Подвал -->
        <footer class="p-4 bg-gray-200">
            <!-- Содержимое подвала -->
        </footer>
    </div>
</template>

<style>

</style>

<!--<div v-if="canLogin">-->
<!--<template v-if="$page.props.auth.user">-->
<!--    <Link :href="route('dashboard')" class="hover:underline">Dashboard</Link>-->
<!--</template>-->
<!--<template v-else>-->
<!--    <Link :href="route('login')" class="text-xs sm:text-sm hover:underline">SING IN</Link>-->
<!--    <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Register</Link>-->
<!--</template>-->
<!--</div>-->



