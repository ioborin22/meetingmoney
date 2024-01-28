<template>
    <div class="shadow-lg rounded-sm mb-4 bg-white">
        <!-- ТАБы -->
        <div class="flex p-2" role="tablist">
            <button
                class="w-full p-2"
                :class="{'border-b-2 border-primary-blue': tab === 'buy', 'text-header-1': tab !== 'buy'}"
                @click="tab = 'buy'">
                BUY
            </button>
            <button
                class="w-full p-2"
                :class="{'border-b-2 border-primary-blue': tab === 'sell', 'text-header-1': tab !== 'sell'}"
                @click="tab = 'sell'">
                SELL
            </button>
        </div>
        <!-- КУПИТЬ -->
        <div v-show="tab === 'buy'" class="p-4">
            <!-- Сумма -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" placeholder="Amount" v-model="amount" @input="validateAmount"/>
                    <div v-if="amount" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button @click="clearAmount" class="text-gray-500 hover:text-gray-700">&#x2715;</button>
                    </div>
                    <p v-if="validateAmountError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Enter amount</p>
                </div>
                <!-- Токен -->
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" v-model="token" @input="validateToken" placeholder="Token"/>
                    <p v-if="validateTokenError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Enter token</p>
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
                <button class="btn bg-primary-blue text-white p-2 rounded-sm search-button" @click="performSearch">SEARCH</button>
            </div>
        </div>
        <!-- ПРОДАТЬ -->
        <div v-show="tab === 'sell'" class="p-4">
            <!-- Сумма -->
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" placeholder="Amount" v-model="amount" @input="validateAmount"/>
                    <div v-if="amount" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button @click="clearAmount" class="text-gray-500 hover:text-gray-700">&#x2715;</button>
                    </div>
                    <p v-if="validateAmountError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Enter amount</p>
                </div>
                <!-- Токен -->
                <div class="relative">
                    <input class="w-full p-2 rounded-sm focus:border-blue-500 focus:outline-none" type="text" v-model="token" @input="validateToken" placeholder="Token"/>
                    <p v-if="validateTokenError" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">Enter token</p>
                    <div v-if="token" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button @click="clearToken" class="text-gray-500 hover:text-gray-700">&#x2715;</button>
                    </div>
                    <ul v-if="filteredToken.length" class="absolute z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto">
                        <li v-for="token in filteredToken" :key="token" @click="selectToken(token)" class="p-2 hover:bg-blue-500 hover:text-white cursor-pointer">{{ token }}</li>
                    </ul>
                    <p v-if="filteredToken.length === 0 && token && !selectedToken" class="absolute p-2 z-10 w-full bg-white border border-gray-300 rounded-sm mt-2 max-h-60 overflow-auto text-red-500">No such token</p>
                </div>
                <!-- Валюта -->
                <select class="form-select rounded-sm" v-if="shouldShowCurrency()" v-model="currency">
                    <option v-for="(name, code) in availableCurrencies" :key="code" :value="code">{{ code }}</option>
                </select>
                <!-- ПОИСК -->
                <button class="btn bg-primary-blue text-white p-2 rounded-sm search-button" @click="performSearch">SEARCH</button>
            </div>
        </div>

        <!-- РЕЗУЛЬТАТ ДЛЯ ВИДИМОСТИ -->
        <div v-show="searchResults"  class="bg-gray-300 p-4">
            {{ searchResults }}
        </div>

    </div>
</template>

<script>

import tokens from '../data/tokens';
import currencies from '../data/currencies';

export default {
    // Данные компонента
    data() {
        return {
            tab: 'buy', // Текущая вкладка (Купить/Продать)
            amount: '', // Сумма для транзакции
            token: '', // Выбранный токен
            currency: '', // Выбранная валюта
            tokens: tokens, // Список всех токенов
            availableCurrencies: currencies, // Список доступных валют
            allTokens: this.createTokenList(tokens), // Список всех токенов для отображения
            filteredToken: [], // Отфильтрованный список токенов
            selectedToken: '', // Выбранный токен из списка
            validateAmountError: false, // Состояние ошибки для поля суммы
            validateTokenError: false, // Состояние ошибки для поля токена
            searchResults: '', // Для хранения результатов поиска

        };
    },

    // Вызывается после монтирования компонента
    mounted() {
        this.setDefaultCurrency(); // Установка начальной валюты
        document.addEventListener('click', this.handleGlobalClick); // Добавление глобального обработчика клика
    },

    // Методы компонента
    methods: {
        // Валидация поля суммы
        validateAmount() {
            if (this.amount === '') {
                this.validateAmountError = true;
            } else {
                this.validateAmountError = false;
                this.amount = this.amount.replace(/[^0-9.,]/g, '').replace(/(\..*)\./g, '$1');
            }
        },

        // Вызывается перед уничтожением компонента
        beforeDestroy() {
            document.removeEventListener('click', this.handleGlobalClick); // Удаление глобального обработчика клика
        },

        // Обработчик глобального клика
        handleGlobalClick(event) {
            if (!event.target.classList.contains('search-button')) {
                this.validateAmountError = false;
                this.validateTokenError = false;
            }
        },

        // Логика выполнения поиска
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

                // Вывод информации о поиске в консоль
                console.log(
                    'Поиск с параметрами:',
                    'действие:', this.tab,
                    'сумма:', this.amount,
                    'токен:', this.selectedToken,
                    'валюта:', currency
                );
            }
            if (!hasError) {
                let currency = this.shouldShowCurrency() ? this.currency : null;
                this.searchResults = `Поиск с параметрами: действие: ${this.tab}, сумма: ${this.amount}, токен: ${this.selectedToken}, валюта: ${currency}`;
            }
        },

        // Установка начальной валюты
        setDefaultCurrency() {
            const currencyKeys = Object.keys(this.availableCurrencies);
            if (currencyKeys.length > 0) {
                this.currency = currencyKeys[0];
            }
        },

        // Проверка, должна ли отображаться валюта
        shouldShowCurrency() {
            for (let category in this.tokens) {
                if (this.tokens[category][this.selectedToken]) {
                    return true;
                }
            }
            return false;
        },

        // Создание списка всех токенов
        createTokenList(tokens) {
            return Object.values(tokens).flatMap(category => Object.keys(category));
        },

        // Валидация ввода токена
        validateToken() {
            if (this.token) {
                this.filteredToken = this.allTokens.filter(token =>
                    token.toLowerCase().includes(this.token.toLowerCase()));
                this.selectedToken = null;
            } else {
                this.filteredToken = [];
            }
        },

        // Очистка поля суммы
        clearAmount() {
            this.amount = '';
            this.validateAmountError = false;
        },

        // Очистка поля токена
        clearToken() {
            this.token = '';
            this.selectedToken = null;
            this.filteredToken = [];
        },

        // Выбор токена из списка
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
