<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Head, Link } from '@inertiajs/vue3';
import SearchBar from '@/Components/SearchBar.vue';
import OfferListing from "@/Components/OfferListing.vue";

const offerListing = ref([]);

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

</script>



<template>
    <Head title="MeetingMoney" />

    <div class="flex flex-col min-h-screen selection:bg-primary-blue selection:text-white">
        <!-- Шапка -->
        <header class="bg-header-1 shadow-md">
            <div class="container mx-auto p-2 sm:p-6">
                <!-- Логотип и навигация -->
                <div class="flex justify-between items-center">
                    <div class="text-center tight-spacing">
                        <h2 class="text-lg sm:text-xl font-black">MeetingMoney</h2>
                        <span class="text-xs sm:text-sm">profit conversations</span>
                    </div>


                    <!-- Навигационные ссылки и вход/регистрация -->
                    <div class="flex items-center">
                        <!-- Навигационные ссылки -->
                        <nav class="mr-6">
                            <Link :href="route('create-ad')" class="text-xs sm:text-sm px-2 sm:px-2 py-1 sm:py-2 bg-primary-green text-white rounded hover:bg-green-600">PLACE AN AD</Link>
                        </nav>


                        <!-- Разместить объявление/Вход -->
                        <div v-if="canLogin">
                            <template v-if="$page.props.auth.user">
                                <Link :href="route('dashboard')" class="hover:underline">Dashboard</Link>
                            </template>
                            <template v-else>
                                <Link :href="route('login')" class="text-xs sm:text-sm hover:underline">SING IN</Link>
                                <!--                        <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Register</Link>-->
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Основной контент -->
        <main class="flex-grow p-4">
            <div class="w-full max-w-xl mx-auto p-4">
                <h1 class="text-center text-2xl font-bold mb-4">Smart people make money here</h1>

                <SearchBar/>
            </div>

            <OfferListing :offerListing="offerListing" />
        </main>

        <!-- Подвал -->
        <footer class="p-4 bg-gray-200">
            <!-- Содержимое подвала -->
            ...
        </footer>
    </div>
</template>

<style>
.tight-spacing h2 {
    margin-bottom: -8px;
    line-height: 1.1; /* Уменьшаем высоту строки */
}
</style>
