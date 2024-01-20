<template>
    <div class="shadow-lg rounded-sm mb-4 bg-white">
        <!-- ТАБы -->
        <div class="flex p-2" role="tablist">
            <button
                class="w-full p-2"
                :class="{'border-b-2 border-blue-500': tab === 'buy'}"
                @click="tab = 'buy'">
                КУПИТЬ
            </button>
            <button
                class="w-full p-2"
                :class="{'border-b-2 border-blue-500': tab === 'sell'}"
                @click="tab = 'sell'">
                ПРОДАТЬ
            </button>
        </div>
        <!-- КУПИТЬ -->
        <div v-show="tab === 'buy'" class="p-4">
            <!-- Сумма -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" placeholder="Сумма" v-model="amount" @input="validateAmount"/>
                    <div v-if="amount" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button @click="clearAmount" class="text-gray-500 hover:text-gray-700">&#x2715;</button>
                    </div>
                    <p v-if="validateAmountError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Введите сумму</p>
                </div>
                <!-- Токен -->
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" v-model="token" @input="validateToken" placeholder="Введите токен"/>
                    <p v-if="validateTokenError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Введите токен</p>
                    <div v-if="token" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button @click="clearToken" class="text-gray-500 hover:text-gray-700">&#x2715;</button>
                    </div>
                    <ul v-if="filteredToken.length" class="absolute z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto">
                        <li v-for="token in filteredToken" :key="token" @click="selectToken(token)" class="p-2 hover:bg-blue-500 hover:text-white cursor-pointer">{{ token }}</li>
                    </ul>
                    <p v-if="filteredToken.length === 0 && token && !selectedToken" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Нет такого токена</p>
                </div>
                <!-- Валюта -->
                <select class="form-select rounded-sm" v-if="shouldShowCurrency()" v-model="currency">
                    <option v-for="(name, code) in availableCurrencies" :key="code" :value="code">{{ code }}</option>
                </select>
                <!-- ПОИСК -->
                <button class="btn bg-blue-500 text-white p-2 rounded-sm search-button" @click="performSearch">ПОИСК</button>
            </div>
        </div>
        <!-- ПРОДАТЬ -->
        <div v-show="tab === 'sell'" class="p-4">
            <!-- Сумма -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" placeholder="Сумма" v-model="amount" @input="validateAmount"/>
                    <div v-if="amount" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button @click="clearAmount" class="text-gray-500 hover:text-gray-700">&#x2715;</button>
                    </div>
                    <p v-if="validateAmountError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Введите сумму</p>
                </div>
                <!-- Токен -->
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" v-model="token" @input="validateToken" placeholder="Введите токен"/>
                    <p v-if="validateTokenError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Введите токен</p>
                    <div v-if="token" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button @click="clearToken" class="text-gray-500 hover:text-gray-700">&#x2715;</button>
                    </div>
                    <ul v-if="filteredToken.length" class="absolute z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto">
                        <li v-for="token in filteredToken" :key="token" @click="selectToken(token)" class="p-2 hover:bg-blue-500 hover:text-white cursor-pointer">{{ token }}</li>
                    </ul>
                    <p v-if="filteredToken.length === 0 && token && !selectedToken" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Нет такого токена</p>
                </div>
                <!-- Валюта -->
                <select class="form-select rounded-sm" v-if="shouldShowCurrency()" v-model="currency">
                    <option v-for="(name, code) in availableCurrencies" :key="code" :value="code">{{ code }}</option>
                </select>
                <!-- ПОИСК -->
                <button class="btn bg-blue-500 text-white p-2 rounded-sm search-button" @click="performSearch">ПОИСК</button>
            </div>
        </div>

    </div>
</template>

<script>

import tokens from '../data/tokens';
import currencies from '../data/currencies';

export default {
    data() {
        return {
            tab: 'buy', // Текущая вкладка
            amount: '', // Сумма
            token: '', // Токен
            currency: '', // Валюта
            tokens: tokens, // Опции платежных систем
            availableCurrencies: currencies, // Доступные валюты
            allTokens: this.createTokenList(tokens),
            filteredToken: [],
            selectedToken: '',
            validateAmountError: false,
            validateTokenError: false,
        };
    },
    mounted() {
        this.setDefaultCurrency();
        document.addEventListener('click', this.handleGlobalClick);
    },
    methods: {
        validateAmount() {
            if (this.amount === '') {
                this.validateAmountError = true;
            } else {
                this.validateAmountError = false;
                this.amount = this.amount.replace(/[^0-9.,]/g, '').replace(/(\..*)\./g, '$1');
            }
        },
        beforeDestroy() {
            document.removeEventListener('click', this.handleGlobalClick);
        },
        handleGlobalClick(event) {
            if (!event.target.classList.contains('search-button')) {
                this.validateAmountError = false;
                this.validateTokenError = false;
            }
        },
        performSearch() {
            let hasError = false;

            if (this.amount === '') {
                this.validateAmountError = true;
                hasError = true;
            } else {
                this.validateAmountError = false;
            }

            if (this.token === '') {
                this.validateTokenError = true;
                hasError = true;
            } else {
                this.validateTokenError = false;
            }

            if (!hasError) {
                // Проверяем, нужно ли показывать валюту
                let currency = this.shouldShowCurrency() ? this.currency : null;

                // Логика поиска
                console.log(
                    'Поиск с параметрами:',
                    'действие:', this.tab,
                    'сумма:', this.amount,
                    'токен:', this.selectedToken,
                    'валюта:', currency
                );
            }

        },
        // Установка первой валюты по умолчанию
        setDefaultCurrency() {
            const currencyKeys = Object.keys(this.availableCurrencies);
            if (currencyKeys.length > 0) {
                this.currency = currencyKeys[0];
            }
        },
        // Определяем, должен ли отображаться выбор валюты
        shouldShowCurrency() {
            for (let category in this.tokens) {
                if (this.tokens[category][this.selectedToken]) {
                    return true;
                }
            }
            return false;
        },
        createTokenList(tokens) {
            // Преобразует ваш объект tokens в массив строк
            return Object.values(tokens ).flatMap(category =>
                Object.keys(category));
        },
        validateToken() {
            if (this.token) {
                this.filteredToken = this.allTokens.filter(token =>
                    token.toLowerCase().includes(this.token.toLowerCase()));
                this.selectedToken = null; // Сбросить выбранную опцию
            } else {
                this.filteredToken = [];
            }
        },
        clearAmount() {
            this.amount = '';
            this.validateAmountError = false;
        },
        clearToken() {
            this.token = '';
            this.selectedToken = null;
            this.filteredToken = [];
        },
        selectToken(token) {
            this.token = token;
            this.selectedToken = token;
            this.filteredToken = [];
        }
    }
};
</script>


<style>

</style>
