<template>
    <div class="shadow-lg border border-gray-200 rounded-lg">

        <!-- Tabs for switching -->
        <div class="flex p-2 space-x-1 bg-white" role="tablist">
            <button
                class="w-full p-2 text-black-500 border-b-4 border-transparent hover:border-white focus:border-blue-500"
                :class="{'border-blue-500 bg-white': tab === 'buy'}"
                @click="tab = 'buy'">
                ПОКУПКА
            </button>
            <button
                class="w-full p-2 text-black-500 border-b-4 border-transparent hover:border-white focus:border-blue-500"
                :class="{'border-blue-500 bg-white': tab === 'sell'}"
                @click="tab = 'sell'">
                ПРОДАЖА
            </button>
        </div>

        <!-- Content for BUY tab -->
        <div v-show="tab === 'buy'" class="p-4 bg-white">
            <div class="flex space-x-2">
                <input class="flex-1 form-input" type="text" placeholder="Количество"/>
                <select class="form-select">
                    <option>PayPal</option>
                    <!-- Здесь можно добавить дополнительные опции -->
                </select>
                <select class="form-select">
                    <option>RUB</option>
                    <!-- Здесь можно добавить дополнительные валюты -->
                </select>
                <select class="form-select">
                    <option>Русский</option>
                    <!-- Здесь можно добавить дополнительные языки -->
                </select>
                <button class="btn btn-primary">ПОИСК</button>
            </div>
        </div>

        <!-- Content for SELL tab -->
        <div v-show="tab === 'sell'" class="p-4 bg-white">
            <div class="flex space-x-2">
                <input class="flex-1 form-input" type="text" placeholder="Количество"/>
                <select class="form-select">
                    <option>BTC</option>
                    <!-- Здесь можно добавить дополнительные опции -->
                </select>
                <select class="form-select">
                    <option>RUB</option>
                    <!-- Здесь можно добавить дополнительные валюты -->
                </select>
                <select class="form-select">
                    <option>Русский</option>
                    <!-- Здесь можно добавить дополнительные языки -->
                </select>
                <button class="btn btn-primary">ПОИСК</button>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            tab: 'buy', // Default tab
        };
    },
};
</script>

<style>
/* Your styles here */
.btn-primary {
    @apply bg-blue-500 text-white p-2;
}
</style>
